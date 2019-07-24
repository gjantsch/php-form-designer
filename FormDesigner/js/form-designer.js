/**
 * Created by Gustavo Jantsch <jantsch@gmail.com>.
 */

var selected_control = null;

$( function() {

    /**
     * Submit changes on table.
     */
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

    /**
     * Fill properties box with selected item values.
     */
    $(".ui-icon-pencil").click(function(e, ui){

        $('#columns li').removeClass('bg-dark');

        $(this).parents('li').first().addClass('bg-dark');

        selected_control = $(this).data('name');

        $('#property-name').html(selected_control);

        $('.f-prop').each(function(i, e){

            var name = $(e).attr('id').replace('f-', '');

            if ($(e).attr('type') == 'checkbox') {
                $(e).prop('checked', items[selected_control][name].value);
            } else {
                $(e).val(items[selected_control][name].value);
            }
        });

    });

    /**
     * Handle properties edited values.
     */
    $('.f-prop').change(function(){
        var name = $(this).attr('id').replace('f-', '');

        if ($(this).attr('type') == 'checkbox') {
            items[selected_control][name].value = $(this).prop('checked');
        } else {
            items[selected_control][name].value = $(this).val();

            if (name == 'label') {
                $('#label-' + selected_control).html($(this).val())
            }
        }

    }).keyup(function(){
        var name = $(this).attr('id').replace('f-', '');

        if ($(this).attr('type') != 'checkbox') {

            items[selected_control][name].value = $(this).val();

            if (name == 'label') {
                $('#label-' + selected_control).html($(this).val())
            }

        }

    });

    /**
     * Save form changes and refresh.
     */
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
