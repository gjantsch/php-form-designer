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
    private $structure;

    public function __construct($table_name)
    {
        $this->tableName = $table_name;

        $this->loadStructure();
    }

    /**
     * Load table structure.
     */
    public function loadStructure()
    {

        $this->structure = $this->structure ?? DB::getStructure($this->tableName);

        foreach ($this->structure as $key => $column) {

            $this->fields[] = new Field($column);

        }

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

}