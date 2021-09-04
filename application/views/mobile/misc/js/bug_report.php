<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.07.17
 * Time: 23:58
 */

?>

<script>

    $('.bug_reporter__send').click(function(event){
        event.preventDefault();

        message     = $('#bug_reporter__description').val();

        if ( message.length == 0 ){
            $('.notify-trigger--alert').attr('data-notifyTitle', 'Внимание!')
                .attr('data-notifyText',  'Опишите пожалуйста ошибку!')
                .click();

            $('#bug_reporter__description').addClass('input__wrong_data').focus();

            return;
        }
        $.ajax({
            url:   '/ajax/bug_reporter',
            data: {
                'message': message
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                $('.preloader').fadeIn(0);
                $('.preloader__img').fadeIn(0);
            },
            success: function(result){

                if (result) {
                    $.fancybox.close();

                    $('#bug_reporter__description').val('');

                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                        .attr('data-notifyText',  'Письмо успешно отправлено разработчикам!')
                        .click();

                } else {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Готово')
                        .attr('data-notifyText',  'При отправке письма возникла проблема, попробуйте позже!')
                        .click();
                }
            },
            complete: function( result ){
                $('.preloader__img').fadeOut('slow');
                $('.preloader').delay(350).fadeOut('slow');

            }
        });

    });

</script>
