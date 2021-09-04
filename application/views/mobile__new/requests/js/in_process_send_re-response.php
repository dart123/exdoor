<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.08.17
 * Time: 18:39
 */
?>

<script>
    $(document).ready( function () {
        $('.js__send_re-response').click( function () {
            var request_id      = $(this).data('request-id'),
                partner_id      = $(this).data('partner-id'),
                send_re_resp    = $(this);

            $.ajax({
                url:   '/ajax/request__send_re_response',
                data: {
                    'request_id'    : request_id,
                    'partner_id'    : partner_id,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);
                },
                success: function(data){

                    if (data) {

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно')
                            .attr('data-notifyText',  'Запрос отправлен!')
                            .click();

                        send_re_resp.hide();
                        send_re_resp.parent().find('.feedback__choose-executant__unactual-disabled').removeClass('is-hidden');

                    } else {
                        location.reload();
                    }

                },
                complete: function () {
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                }
            });
        })
    })
</script>
