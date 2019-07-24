<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */
?>
<div class="col-<?=$field->columns?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <input type="text" class="form-control" id="<?=$field->name?>" placeholder="<?=$field->placeholder?>" value="<?=$field->value?>" <?=$field->required ? 'required' : '' ?> >
</div>
