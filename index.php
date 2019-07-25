<?php
/**
 * Form Designer Sample Form.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

use FormDesigner\DB;
use FormDesigner\Form;
use FormDesigner\Table;

require_once 'FormDesigner/DB.php';
require_once 'FormDesigner/Table.php';
require_once 'FormDesigner/Field.php';
require_once 'FormDesigner/Form.php';

require_once 'config.php';

$table_name = $_REQUEST['table'] ?? null;

$tables = DB::getTables();
$table = $table_name && isset($tables[$table_name]) ? new Table($table_name) : null;

$field_types = array_diff(scandir(__DIR__ . '/FormDesigner/views'), array('..', '.'));
array_walk($field_types, function (&$item, $key) {
    $item = str_replace('.php', '', $item);
});

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Form Designer</title>

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
    <link href="assets/fontawesome-free-5.9-2.0-web/css/all.min.css" rel="stylesheet">
    <link href="assets/daterangepicker-master/daterangepicker.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <script>
        var items = {
            <?php foreach ($table->fields as $field): ?>
                "<?=$field->name?>": <?=$field->getOptions()?>,
            <?php endforeach; ?>
            };
        var table = "<?=$table_name?>";
    </script>
</head>
<body class="bg-light">
<div class="container">

    <div class="row">
        <div class="col-4">
            <form action="index.php" method="get" id="frm-editor">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Tabela:</span>
                <select name="table" class="form-control m-2">
                    <option>  -- select a table --  </option>
                    <?php foreach ($tables as $key => $value): ?>
                        <option value="<?=$key?>" <?=$key == $table_name ? 'selected' : ''?>><?=$value?></option>
                    <?php endforeach; ?>
                </select>
                <span class="badge badge-secondary badge-pill"><?=count($tables)?></span>
            </h4>
            </form>
            <?php if ($table): ?>
            <ul class="list-group mb-3 sortable" id="columns">
                <?php foreach ($table->getFields() as $field): ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed p-2" data-name="<?=$field->name?>">
                    <div>
                        <small class="text-muted"><strong><?=$field->name?></strong> - <span id="label-<?=$field->name?>"><?=$field->label?></span></small>
                        <input type="hidden" name="<?=$field->name?>" value="<?=$field->getOptions()?>">
                    </div>
                    <span class="text-muted">
                        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        <span class="ui-icon ui-icon-pencil" data-name="<?=$field->name?>"></span>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif;?>

            <ul class="list-group mb-3 small" id="f-properties-form">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <strong>Properties</strong><span id="property-name"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <form>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input f-prop" id="f-form">
                            <label class="form-check-label" for="f-form">Form</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input f-prop" id="f-visible">
                            <label class="form-check-label" for="f-visible">Visible</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input f-prop" id="f-required">
                            <label class="form-check-label" for="f-required">Required</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input f-prop" id="f-maxlen">
                            <label class="form-check-label" for="f-maxlen">Show Max Length</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input f-prop" id="f-readonly">
                            <label class="form-check-label" for="f-readonly">Readonly</label>
                        </div>

                        <div>
                            <label for="label">Label</label>
                            <input type="text" class="form-control form-control-sm input-sm f-prop" id="f-label" value="">
                        </div>

                        <div>
                            <label for="f-mask">Placeholder</label>
                            <input type="text" class="form-control form-control-sm f-prop" id="f-placeholder" value="">
                        </div>

                        <div>
                            <label for="f-bottom">Bottom line</label>
                            <input type="text" class="form-control form-control-sm f-prop" id="f-bottom" value="">
                        </div>

                        <div>
                            <label for="label">Mask</label>
                            <input type="text" class="form-control form-control-sm f-prop" id="f-mask" value="">
                        </div>

                        <div>
                            <label for="label">Input</label>
                            <select id="f-input" class="form-control form-control-sm f-prop">
                                <?php foreach ($field_types as $field_type): ?>
                                    <option value="<?=$field_type?>"<?=$field_type=='text' ? ' selected' : ''?>><?=$field_type?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="label">Order</label>
                            <input type="text" class="form-control form-control-sm f-prop" id="f-order" value="">
                        </div>

                        <div>
                            <label for="label">Columns</label>
                            <input type="text" class="form-control form-control-sm f-prop" id="f-columns" value="">
                        </div>

                        <div class="m-5">
                            <button class="btn btn-primary form-control form-control-sm" id="save">Save & Refresh</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-8">
            <div class="row">
                <?php Form::Open(); ?>
                <div class="col-12">

                    <h4 class="mb-3"><?=$table_name?></h4>
                    <div class="row">
                    <?php echo $table ? Form::renderTable($table) : null; ?>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary btn-block col-6 " type="submit">Salvar</button>
                    <button class="btn btn-secondary btn-block col-6" type="submit">Cancelar</button>
                </div>
                <?php Form::Close(); ?>
            </div>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2019 Leme</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>
<script src="assets/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="assets/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/moment.js"></script>
<script src="assets/moment-with-locales.js"></script>
<script src="assets/daterangepicker-master/daterangepicker.js"></script>
<script src="assets/fontawesome-free-5.9-2.0-web/js/all.min.js"></script>
<script src="FormDesigner/js/jquery-ensure-max-length.js"></script>
<script src="FormDesigner/js/jquery.mask.min.js"></script>
<script src="FormDesigner/js/form-designer.js"></script>
<script src="FormDesigner/js/forms.js"></script>
</html>

