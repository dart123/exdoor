<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:26
 *
 *      Удаляем и отменяем удаление
 */

?>

<script>

    $("body").on("click", '.ajax__remove_offer', function () {
        var id  = $(this).attr('data-offer-id');
        $.post('/ajax/remove_offer',
            { 'id': id },
            function(result) {
                if (result) {
                    $.fancybox.close();
                    $('.item-offer-'+id+ '> .after_removing_background').show();
                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                        .attr('data-notifyText',  'Ваше объявление успешно удалено!')
                        .click();
                } else {

                }
            });
    });

    $('body').on( 'click' , '.ajax__undo_remove_offer', function() {

        var id = $(this).attr('data-offer-id');

        $.post('/ajax/undo_remove_offer',
            {
                'action'    : 'undo_remove_item',
                'id'        : id,
            },
            function(result) {
                if (result) {
                    $('.item-offer-'+id+ '> .after_removing_background').hide();
                    $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно отменено')
                        .attr('data-notifyText',  'Выбранное вами объявление успешно восстановлено!')
                        .click();
                }
            });
    });
</script>
