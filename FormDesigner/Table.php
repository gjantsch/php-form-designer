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

    private $strucutre;

    public function __construct($table_name)
    {
        $this->tableName = $table_name;

        $this->loadStructure();
    }

    public function loadStructure()
    {

        $this->strucutre = $this->strucutre ?? DB::getStructure($this->tableName);

        foreach ($this->strucutre as $key => $column) {

            $this->fields[] = new Field($column);

        }

    }

    public function getFields()
    {
        return $this->fields;
    }

}