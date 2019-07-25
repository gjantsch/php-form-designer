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

require_once 'config.php';

header("Content-type: text/plain");
$items = $_REQUEST['items'];
$table = $_REQUEST['table'];

DB::setStructure($table, $items);
