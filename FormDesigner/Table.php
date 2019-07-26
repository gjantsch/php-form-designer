<?php

/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

namespace FormDesigner;

class Table
{

    /**
     * @var string
     */
    public $tableName;

    /***
     * @var array
     */
    public $fields = [];

    /**
     * @var array
     */
    public $foreignKeys = [];

    /**
     * @var array
     */
    private $structure;

    /**
     * @var string
     */
    private $create;

    public function __construct($table_name)
    {
        $this->tableName = $table_name;

        $this->loadStructure();

        $this->loadForeignKeys();

    }

    /**
     * Load table structure.
     */
    public function loadStructure()
    {

        $this->structure = $this->structure ?? DB::getTableColumns($this->tableName);

        foreach ($this->structure as $key => $column) {

            $this->fields[$column['Field']] = new Field($column, $this);

        }

    }

    public function loadForeignKeys()
    {
        $create = $this->create ?? DB::getTableCreate($this->tableName);
        $create = explode("\n", $create);
        foreach ($create as $line) {
            $line = trim($line);
            $pos = strpos($line, 'FOREIGN KEY');
            if ($pos !== false) {
                $parse = explode(' ', substr($line, $pos));

                $fk = trim($parse[2], '()`');
                $references = trim($parse[4], '()`');
                $pk = trim($parse[5], ',()`');

                $this->foreignKeys[$fk] = ['fk' => $fk, 'references' =>  $references, 'pk' => $pk];

            }
        }

    }

    /**
     * Check if field is a foreign key.
     *
     * @param $field_name
     * @return bool
     */
    public function isForeignKey($field_name)
    {
        return isset($this->foreignKeys[$field_name]);
    }

    /**
     * @param $field_name
     * @return mixed
     */
    public function getForeignKey($field_name)
    {
        return $this->foreignKeys[$field_name];
    }

    /**
     * Get related records from fk.
     *
     * @param $fk
     * @param $value
     * @return array|null|\PDOStatement
     */
    public function getDataFromFK($fk, $options = [], $filter = null)
    {

        $response = null;
        if (is_string($fk) && $this->isForeignKey($fk)) {

            $fk = $this->getForeignKey($fk);
            $fk = array_merge($fk, $options);

        }

        if (is_array($filter) && count($filter)) {
            $where = '';
            $values = [];
            foreach ($filter as $key => $value) {
                $where .= " {$key}=? ";
                $values[] = $value;
            }
        }

        if (is_array($fk) && isset($fk['fk']) && isset($fk['pk']) && isset($fk['references'])) {

            $sql = "SELECT * FROM `{$fk['references']}`" . (isset($where) ? " WHERE $where " : "");
            if (isset($fk['order'])) {
                $sql .= " ORDER BY {$fk['order']}";
            }

            $response = DB::getAll($sql, $values ?? null);

        }

        return $response;
    }

    /**
     * Get fields sorted.
     * @return array
     */
    public function getFields()
    {

        $fields = $this->fields;

        usort($fields, function($a, $b) {

            return ($a->order < $b->order ? -1 : ($a->order > $b->order ? 1 : 0));

        });

        return $fields;
    }

    /**
     * @param $field_name
     * @return Field
     */
    public function getField($field_name)
    {

        return isset($this->fields[$field_name]) ? $this->fields[$field_name] : null;

    }

}