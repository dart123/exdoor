<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 17.09.17
 * Time: 20:32
 */
?>

<script>
    
    $(document).ready( function () {
        $('.profile__save_button__security').click( function () {

            $.ajax({
                url:   '/ajax/profile__save__security',
                data: {
                    security_page       : $('select[name="security_page"]').val(),
                    security_contacts   : $('select[name="security_contacts"]').val(),
                    security_partners   : $('select[name="security_partners"]').val(),
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                },
                success: function(result){
                    if (result) {
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Ваши данные успешно обновлены!')
                            .click();
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'В процессе обновления произошла ошибка!')
                            .click();
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
                }
            });



        });
    })
    
</script>
