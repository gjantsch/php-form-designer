<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @var FormDesigner\Field $field
 */
?>
<div class="col-<?=$field->columns?>">
    <label for="<?=$field->name?>"><?=$field->label?></label>
    <textarea class="form-control" id="<?=$field->name?>"><?=$field->value?></textarea>
</div>