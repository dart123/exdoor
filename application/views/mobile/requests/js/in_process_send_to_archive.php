<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 17:53
 */
?>
<script>

    // Отпарвялем заявку в архив принудительно
    $('body').on('click', '.ajax__request__send_to_archive', function () {
        request_id = $(this).data('request-id');
        $.ajax({
            url:   '/ajax/request__send_to_archive',
            data: {
                'request_id'    : request_id
            },
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if (data) {
                    var counter_object  = $('#js__user-<?php echo $this->session->user;?>__requests_found');
                    var count_requests  = parseInt( counter_object.text() );

                    $('.ajax__request_'+ request_id).fadeOut(300, function() {
                        counter_object.fadeOut(300, function () {
                            counter_object.text( count_requests - 1 ).fadeIn(300);
                        });
                    });

                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово!')
                        .attr('data-notifyText',  'Заявка отправлена в архив')
                        .click();

                } else {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Возникла ошибка при отправке заявки в архив! Попробуйте позже')
                        .click();
                }

            }
        });
    });

</script>
