<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */

$data = [];
$extra = $field->getExtra();
$empty = '';
$filter = null;
if (isset($options) && is_array($options)) {
    $filter = $options['filter'] ?? null;
    $options_only = $options['option-only'] ?? false;
}

if ($field->type == 'enum') {
    foreach ($field->enum as $value) {
        $data[$value] = $value;
    }
} else {

    if ($extra) {

        if ($extra->empty) {
            $empty = '<option value="">' . $extra->empty . '</option>';
        }

        if ($extra->from == 'foreign') {
            $records = $field->getTable()->getDataFromFK($field->name, $extra->toArray(), $filter);
        } else {
            $records = $field->getTable()->getDataFromFK($extra->toArray(), [], $filter);
        }

        foreach ($records as $record) {
            $data[$record[$extra->key]] = $record[$extra->value];
        }

    }
}

?>
<?php if (!$options_only): ?>
<div class="col-<?=$field->columns?><?=$field->visible ? '' : ' hide'?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <select class="form-control custom-select d-block w-100" id="<?=$field->name?>" <?=$field->required ? 'required' : '' ?><?=$extra->update ? "data-update=\"{$extra->update}\" data-table=\"{$field->getTable()->tableName}\" " : '' ?>>
        <?php endif; ?>
        <?=$empty?>
        <?php foreach ($data as $key => $value): ?>
            <option value="<?=$key?>"><?=$value?></option>
        <?php endforeach; ?>
        <?php if (!$options_only): ?>
    </select>
    <?php if (!empty($field->bottom)): ?>
        <small class="text-muted"><?=$field->bottom?></small>
    <?php endif; ?>
</div>
<?php endif; ?>