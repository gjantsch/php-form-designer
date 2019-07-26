<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

use FormDesigner\DB;
use FormDesigner\Form;
use FormDesigner\Table;

require_once 'FormDesigner/DB.php';
require_once 'FormDesigner/Table.php';
require_once 'FormDesigner/Field.php';
require_once 'FormDesigner/FieldExtras.php';
require_once 'FormDesigner/Form.php';

require_once 'config.php';

$table_name = $_REQUEST['table'];
$field_name = $_REQUEST['field'];
$filter = $_REQUEST['filter'];

$table = new Table($table_name);
$field = $table->getField($field_name);

ob_start();
$field = Form::renderField($field, ['filter' => $filter, 'option-only' => true]);
$content = ob_get_clean();

header("Content-type: application/json");
echo json_encode([
    "field_id" => $field_name,
    "content" => $content
]);
