<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */
?>
<div class="col-<?=$field->columns?><?=$field->visible ? '' : ' hide'?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <input type="password" class="form-control<?=$field->maxlen ? ' ensure-max-length' : ''?>" id="<?=$field->name?>" value="<?=$field->value?>" <?=$field->required ? 'required' : '' ?> >
    <?php if (!empty($field->bottom)): ?>
        <small class="text-muted"><?=$field->bottom?></small>
    <?php endif; ?>
</div>
