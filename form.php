<?php
/**
 * This is the generic form generator.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

use FormDesigner\Form;

?>
<?php Form::Open(); ?>
<div class="col-12">

    <h4 class="mb-3"><?= $table_name ?></h4>
    <div class="row">
        <?php echo $table ? Form::renderTable($table) : null; ?>
    </div>

    <hr class="mb-4">
    <div class="row">
        <div class="container">
            <div class="row text-center">
                <div class="col-3">
                    <button class="btn btn-info col" type="cancel">&laquo;</button>
                </div>
                <div class="col-3">
                    <button class="btn btn-primary col" type="submit">Salvar</button>
                </div>
                <div class="col-3">
                    <button class="btn btn-secondary col" type="cancel">Cancelar</button>
                </div>
                <div class="col-3">
                    <button class="btn btn-info col" type="cancel">&raquo;</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Form::Close(); ?>

