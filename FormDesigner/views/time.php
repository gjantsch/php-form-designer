<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */

$class = [
    'form-control',
    'mask'
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

if (!$field->visible) {
    $class[] = 'hide';
}
?>
<div class="col-<?=$field->columns?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <div class="input-group">
        <input type="text" data-mask="00:00" class="<?=implode(' ', $class)?>" <?=implode(' ', $options)?>>
        <div class="input-group-append"><span class="input-group-text"><i class="fa fa-clock"></i></span></div>
    </div>
    <?php if (!empty($field->bottom)): ?>
        <small class="text-muted"><?=$field->bottom?></small>
    <?php endif; ?>
</div>
