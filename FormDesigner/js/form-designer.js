/**
 * Created by vijay on 23/07/19.
 */

var selected_control = null;

$( function() {

    $('select[name="table"]').change(function() {
        $('#frm-editor').submit()
    });

    $(".sortable" ).sortable({
        update: function(i, e){

            $('ul#columns .list-group-item').each(function(i, e){
                items[$(e).data('name')].order.value = i;

                if ($(e).hasClass('bg-dark')) {
                    $('#f-order').val(i);
                }
            });


        }
    });

    $(".ui-icon-pencil").click(function(e, ui){

        $('#columns li').removeClass('bg-dark');

        $(this).parents('li').first().addClass('bg-dark');

        selected_control = $(this).data('name');

        $('#f-form').prop('checked', items[selected_control].form.value);
        $('#f-visible').prop('checked', items[selected_control].visible.value);
        $('#f-label').val(items[selected_control].label.value);
        $('#f-input').val(items[selected_control].input.value);
        $('#f-order').val(items[selected_control].order.value);
        $('#f-columns').val(items[selected_control].columns.value);
        $('#f-mask').val(items[selected_control].mask.value);

    });

    $('#f-form').change(function(){
        items[selected_control].form.value = $(this).prop('checked');
    });

    $('#f-visible').change(function(){
        items[selected_control].visible.value = $(this).prop('checked');
    });

    $('#f-label').keyup(function(){
        items[selected_control].label.value = $(this).val();
        $('#label-' + selected_control).html($(this).val())
    });

    $('#f-mask').keyup(function(){
        items[selected_control].mask.value = $(this).val();
    });

    $('#f-order').keyup(function(){
        items[selected_control].order.value = $(this).val();
    });

    $('#f-columns').keyup(function(){
        items[selected_control].columns.value = $(this).val();
    });

    $('#f-input').change(function(){
        items[selected_control].input.value = $(this).val();
    });


    $('#save').click( function(e, ui){

        $(this).attr('disabled', true);

        $.ajax({
            url: 'save.php',
            data: {
                table: table,
                items: items
            },
            method: 'post',
            success: function(data) {
                window.location.reload();

            }
        });
    });

} );
