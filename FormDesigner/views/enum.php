<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */
?>
<div class="col-<?=$field->columns?><?=$field->visible ? '' : ' hide'?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <select class="form-control" id="<?=$field->name?>" <?=$field->required ? 'required' : '' ?>>
        <?php foreach ($field->enum as $value): ?>
            <option value="<?=$value?>"><?=$value?></option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($field->bottom)): ?>
        <small class="text-muted"><?=$field->bottom?></small>
    <?php endif; ?>
</div>
