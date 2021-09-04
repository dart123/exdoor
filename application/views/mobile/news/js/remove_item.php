<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:18
 */
?>
<script>

    $("body").on("click", '.ajax__news_remove', function () {
        var id  = $(this).attr('data-id');
        $.post('/ajax/remove_news',
            { 'id': id },
            function(result) {
                if ( result == 'true' ) {
                    $('.item-news-'+id+ '> .after_removing_background').show();

                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                        .attr('data-notifyText',  'Ваша новость успешно удалена!')
                        .click();
                } else if ( result == 'no_permissions' ) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'У Вас нет прав на удаление этой новости!')
                        .click();
                }
            });
    });

    $('body').on( 'click' , '.ajax__undo_remove_news', function() {

        var id = $(this).attr('data-news-id');

        $.post('/ajax/undo_remove_news',
            {
                'action'    : 'undo_remove_item',
                'id'        : id,
            },
            function(result) {
                if (result) {
                    $('.item-news-'+id+ '> .after_removing_background').hide();
                    $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно отменено')
                        .attr('data-notifyText',  'Выбранная вами новость успешно восстановлена!')
                        .click();
                }
            });
    });
</script>
