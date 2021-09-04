<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:27
 *
 *      Прикрепление объявлений к главной
 *
 */

?>

<script>
    $("body").on("click", ".ajax__pinned_offer", function () {
        var link_object     = $(this),
            offer_id        = $(this).attr('data-id'),
            is_pinned       = $(this).attr('data-pinned');

        $.post('/ajax/pin_offer',
            {
                'id'        : offer_id,
                'is_pinned' : is_pinned
            },
            function(result) {
                if (result) {
                    var data  = $.parseJSON(result);
                    console.log( data );
                    if( data.is_pinned == true )
                    {
                        link_object.attr('data-pinned', 'true');
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Ваше объявление успешно закреплено!')
                            .click();
                    }
                    else
                    {
                        link_object.attr('data-pinned', 'false');
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Ваше объявление успешно откреплено!')
                            .click();
                    }
                } else {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Внимание, произошла ошибка!')
                        .click();
                }
            });
    });
</script>
