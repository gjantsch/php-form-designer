/**
 * Created by Gustavo Jantsch <jantsch@gmail.com>.
 */

$(function() {

    /**
     * Add Max Length Counter
     */
    $('.ensure-max-length').EnsureMaxLength(
        {
            cssClass: 'text-muted float-right',
            separator: '/',
            placement: null
        }
    );

    $('.maks').each(function(i, e){

        var mask = $(e).data('mask');
        $(e).mask(mask);

    });

    $('.needs-validation').submit(function(e, ui){

        if (e.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(e).addClass('was-validated');

    });

    moment.locale('pt-br');
    $('.datepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
    });

    $(':not([data-update=""])').change(function(e, ui){

        if (!$(this).is('select')) {
            return;
        }

        var filter = {};
        filter[$(this).attr('id')] = $(this).val();

        $.ajax({
            url: "update.php",
            method: "get",
            data: {
                table: $(this).data('table'),
                field: $(this).data('update'),
                filter: filter
            },
            success: function(data) {

                $('#' + data.field_id).html(data.content);

            }
        });


    });


});


// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict'

    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation')

        // Loop over them and prevent submission
        Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    }, false)
}())
