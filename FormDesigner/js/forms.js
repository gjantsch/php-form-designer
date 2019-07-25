/**
 * Created by Gustavo Jantsch <jantsch@gmail.com>.
 */

/**
 * Add Max Length Counter
 */
$('.ensure-max-length').EnsureMaxLength(
    {
        cssClass: '',
        separator: '/',
        placement: null
    }
);

$('.maks').each(function(i, e){

    var mask = $(e).data('mask');
    $(e).mask(mask);

});