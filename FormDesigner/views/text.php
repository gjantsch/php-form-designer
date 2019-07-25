<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */
$class = [
    'form-control'
];

$options = [
    "id=\"{$field->name}\"",
    "name=\"{$field->name}\"",
    "value=\"{$field->value}\""
];

if ($field->readonly) {
    $options[] = "readonly";
}

if ($field->required) {
    $options[] = "required";
}

if (!empty($field->placeholder)) {
    $options[] = "placeholder=\"$field->placeholder\"";
}

if ($field->maxlen) {
    $class[] = 'ensure-max-length';
}

if (!$field->visible) {
    $class[] = 'hide';
}

if (!empty($field->mask)) {
    $options[] = 'data-mask="' . $field->mask . '"';
    $class[] = 'mask';
}
?>
<div class="col-<?=$field->columns?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <input type="text" class="<?=implode(' ', $class)?>" <?=implode(' ', $options)?>>
    <?php if (!empty($field->bottom)): ?>
        <small class="text-muted"><?=$field->bottom?></small>
    <?php endif; ?>
</div>
