<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

use FormDesigner\DB;
use FormDesigner\Field;
use FormDesigner\Form;
use FormDesigner\Table;

require_once 'FormDesigner/DB.php';
require_once 'FormDesigner/Table.php';
require_once 'FormDesigner/Field.php';
require_once 'FormDesigner/Form.php';

DB::initialize('exemplo', 'localhost', 'remote', '123');


header("Content-type: text/plain");
$items = $_REQUEST['items'];
$table = $_REQUEST['table'];

// Get the create table
$create = explode("\n", DB::getTableCreate($table));
$alter = [];
foreach ($create as $line) {
    $line = trim($line);

    if (substr($line, 0, 1) == '`') {
        $field_name = trim(substr($line, 0, strpos($line, ' ')), '`');

        if (true || isset($items[$field_name])) {

            $json = [];
            foreach (Field::getOptionsKeys() as $key) {
                $json[$key] = $items[$field_name][$key]['value'];
            }

            if (strpos($line, "COMMENT")) {
                $line = substr($line, 0, strpos($line, "COMMENT"));
            } else {
                $line = trim($line, ',');
            }

            $line = $line . "COMMENT '" . json_encode($json). "'";

            $alter[] = "ALTER TABLE $table MODIFY COLUMN $line";
        }
    }
}

foreach ($alter as $sql) {
    DB::query($sql);
}