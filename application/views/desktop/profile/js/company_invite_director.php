<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.07.17
 * Time: 12:28
 */
?>

<script>


    $(document).ready( function () {
        $('#company__invite-manager__phone').mask('+9?999999999999999', {"placeholder": ""});
    });


    /* Отправка приглашения директору компании по sms / email */
    $(".send-mail__radio--cover .radio").click(function(event){

        $('.input__wrong_data').removeClass( 'input__wrong_data' );

        if($('#send-inv__email').is(':checked')) {

            sms_msg         = $('#company__invite-manager__message').val();
            $('#company__invite-manager__message').data('sms-msg', sms_msg);
            $('#company__invite-manager__message').val( $('#company__invite-manager__message').data('email-msg') );

            $('#sms-line').fadeOut(0);
            $('#mail-line').fadeIn(300);
            $('#company__invite-manager__message').attr('maxlength', 400).removeClass('limit-sms').addClass('limit-400');

            letter_counter_400( $('#company__invite-manager__message') );

            $('#company__invite-manager__message').focus();

        } else {

            email_msg       = $('#company__invite-manager__message').val();
            $('#company__invite-manager__message').data('email-msg', email_msg);
            $('#company__invite-manager__message').val( $('#company__invite-manager__message').data('sms-msg') );

            $('#sms-line').fadeIn(300);
            $('#mail-line').fadeOut(0);
            $('#company__invite-manager__message').attr('maxlength', 67).removeClass('limit-400').addClass('limit-sms');

            letter_counter_sms( $('#company__invite-manager__message') );

            $('#company__invite-manager__message').focus();

        }
    });




    $('.js__invite_director').click(function(event){
        event.preventDefault();

        if( $('#send-inv__email').prop('checked') == true ) {

            message     = $('#company__invite-manager__message').val();
            email       = $('#company__invite-manager__email').val();
            subject     = 'Приглашение на сайт Exdor';

            if( message.length == 0 || email.length == 0 ) {

                if( email.length == 0 )
                    $('#company__invite-manager__email').addClass('input__wrong_data').focus();

                if( message.length == 0 )
                    $('#company__invite-manager__message').addClass('input__wrong_data').focus();

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Внимание!')
                    .attr('data-notifyText',  'Заполните пожалуйста необходимые поля!')
                    .click();
                return;
            }

            $.ajax({
                url:   '/ajax/send_email',
                data: {
                    'email':email, 'subject': subject, 'message': message
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

                        $('#company__invite-manager__email').val('');

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Письмо успешно отправлено!')
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










        } else if( $('#send-inv__sms').prop('checked') == true ){
            message     = $('#company__invite-manager__message').val();
            phone       = $('#company__invite-manager__phone').val();

            if( message.length == 0 || phone.length == 0 ) {

                if( phone.length == 0 )
                    $('#company__invite-manager__phone').addClass('input__wrong_data').focus();

                if( message.length == 0 )
                    $('#company__invite-manager__message').addClass('input__wrong_data').focus();

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Внимание!')
                    .attr('data-notifyText',  'Заполните пожалуйста необходимые поля!')
                    .click();

                return;
            }

            $.ajax({
                url:   '/ajax/send_sms',
                data: {
                    'message': message, 'phone':phone
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);
                },
                success: function(result){

                    if( result == 'true' ) {

                        $.fancybox.close();
                        $('#company__invite-manager__phone').val('');

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'СМС успешно отправлено!')
                            .click();

                    }
                    else if( result == 'false' || result == 'error' ) {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'При отправке смс возникла проблема, попробуйте позже!')
                            .click();
                    }
                    else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Следующее смс Вы сможете отправить через: '+ result )
                            .click();
                    }

                },
                complete: function( result ){
                    $('.preloader__img').fadeOut('slow');
                    $('.preloader').delay(350).fadeOut('slow');

                }
            });

        }

    });
</script>
