<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.07.17
 * Time: 20:43
 */

?>

<script>
    $(document).ready( function() {

        $('body').on('click', '.ajax__request__copy', function() {

            request_id      = $(this).data('request-id');

            $.ajax({
                url:   '/ajax/request__copy',
                data: {
                    'request_id'    : request_id,
                },
                type: 'POST',
                dataType: 'json',
                success: function(data){
                    if (data == 'true') {
                        document.location.href = "<?=$this->config->item('base_url');?>/requests/add";
                    }
                    else if (data == 'no_permissions') {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'У вас нет права копирования данной заявки!')
                            .click();
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Возникла ошибка при создании копии! Попробуйте позже')
                            .click();
                    }

                }
            });
        });

    })
</script>
