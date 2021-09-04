<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 17:52
 */

?>
<script>
    $('.ajax__confirm-request-finished').click( function() {

        rating          = parseInt( $('#js__rating_input').val() );
        request_id      = $(this).data('request-id');
        executor_id     = $(this).data('executor-id');

        if( rating && rating > 0 ) {

            $.ajax({
                url:   '/ajax/request__set_rating',
                data: {
                    'request_id'    : $('#js__request_id').val(),
                    'rating'        : rating,
                },
                type: 'POST',
                dataType: 'json',
                success: function(data){
                    if (data) {

                        $.post('/ajax/request__confirm_finishing',
                            {
                                'request_id':   request_id,
                                'executor_id':  executor_id
                            },
                            function(result) {
                                data  = $.parseJSON(result);
                                if(data) {
                                    document.location.reload();
                                }
                            });

                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Возникла ошибка при постановке оценки! Попробуйте позже')
                            .click();
                    }

                }
            });
        }  else {

            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                .attr('data-notifyText',  'Вы должны оценить работу партнера!')
                .click();

        }



    });
</script>
