<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */
?>
<div class="col-<?=$field->columns?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <input type="password" class="form-control<?=$field->maxlen ? ' ensure-max-length' : ''?>" id="<?=$field->name?>" value="<?=$field->value?>" <?=$field->required ? 'required' : '' ?> >
</div>
