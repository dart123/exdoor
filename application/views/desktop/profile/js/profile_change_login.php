<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.07.17
 * Time: 23:03
 */

?>

<script>

    $(document).ready( function()  {


        $('.profile__change_login').fancybox({
            helpers     : {
                overlay : {
                    locked: true
                }
            },
            href        : '#modal__change_login',
            closeBtn    : false,

        });

        $('body').on('submit', '.ajax__change_login__approve', function(e) {
            e.preventDefault();
            <?php
                /*
                 * Пользователь подтвердил что хочет сменить пароль
                 * Высылаем на его текущий номер код и просим его подтвердить
                 */
                ?>

            $.ajax({
                url:   '/ajax/change_login__send_code',
                data: {
                    'lang': page_lang
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function(result){
                    if (result == 'block') {

                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  "Новое смс с кодом можно отправить не ранее, чем через 5 минут!")
                            .click();

                    } else if (result == 'true') {
                        template        = $('#change_login__place_code').html();
                        output          = Mustache.render(template);
                        $('.ajax__change_login__container').replaceWith( output );

                        $('#input__change_login__code').mask('9999', {"placeholder": ""});
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                    $('#input__change_login__code').focus();
                }
            });
        });




        $('body').on('submit', '.ajax__change_login__check_code', function(e) {
            e.preventDefault();
            <?php
            /*
             * Пользователь вводит код
             * Если правильный - позволяем ему добавить новый телефон
             * Если нет - ждем пока будет правильный
             */
            ?>
            code    = $('#input__change_login__code').val();

            $.ajax({
                url:   '/ajax/change_login__check_code',
                data: {
                    code    : code
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function(result){
                    if (result == 'true') {
                        template        = $('#change_login__new_phone').html();
                        output          = Mustache.render(template);
                        $('.ajax__change_login__container').replaceWith( output );

                        $('#input__change_login__new_phone').mask('9?999999999999', {"placeholder": ""});

                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  "Ваш код не совпадает с тем, что мы отправили по смс!")
                            .click();
                        $('#input__change_login__code').val('').focus();
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                    $('#input__change_login__new_phone').focus();
                }
            });
        });


        $('body').on('submit', '.ajax__change_login__new_phone', function(e) {
            e.preventDefault();
            <?php
            /*
             * Пользователь вводит код
             * Если правильный - позволяем ему добавить новый телефон
             * Если нет - ждем пока будет правильный
             */
            ?>
            phone_code      = $('#input__change_login__new_phone__code').val();
            phone           = $('#input__change_login__new_phone').val();

            full_phone      = phone_code + phone;

            console.log( full_phone );

            $.ajax({
                url:   '/ajax/change_login__new_phone',
                data: {
                    phone    : full_phone
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function(result){
                    if (result == 'true') {
                        template        = $('#change_login__check_pass').html();
                        output          = Mustache.render(template);
                        $('.ajax__change_login__container').replaceWith( output );
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  "Убедитесь, что указан верный номер телефона и он не используется на сайте exdor.ru")
                            .click();

                        $('#input__change_login__new_phone').val('').focus();
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                    $('#input__change_login__check_pass').focus();
                }
            });
        });


        $('body').on('submit', '.ajax__change_login__check_pass', function(e) {
            e.preventDefault();
            <?php
            /*
             * Пользователь вводит код
             * Если правильный - позволяем ему добавить новый телефон
             * Если нет - ждем пока будет правильный
             */
            ?>
            pass    = $('#input__change_login__check_pass').val();

            $.ajax({
                url:   '/ajax/change_login__check_pass',
                data: {
                    pass    : pass
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function(result){
                    if (result == 'true') {

                        location.reload();

                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  "Пароль не верный!")
                            .click();

                        $('#input__change_login__check_pass').val('').focus();
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                }
            });
        })

})

</script>
