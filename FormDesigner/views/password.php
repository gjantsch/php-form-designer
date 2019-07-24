<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */
?>
<div class="col-<?=$field->columns?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <input type="password" class="form-control" id="<?=$field->name?>" placeholder="<?=$field->placeholder?>" value="<?=$field->value?>" <?=$field->required ? 'required' : '' ?> >
</div>
