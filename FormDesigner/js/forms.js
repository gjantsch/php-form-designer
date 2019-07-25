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


});
