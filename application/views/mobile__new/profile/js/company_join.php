<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-04
 * Time: 15:00
 */
?>

<script>
    $( document ).ready( function () {

        $('.ajax__company_join').click( function (e) {
            e.preventDefault();
            var company_id      = $(this).data('company-id');

            $.ajax({
                url:   '/ajax/company__join',
                data: {
                    company_id  : company_id,
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
                        window.location = "<?=$this->config->item('base_url');?>/profile/company";
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'В процессе присоединения к компаниии произошла ошибка. Попробуйте позже!')
                            .click();
                    }
                },
                error: function(){

                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'В процессе присоединения к компаниии произошла ошибка. Попробуйте позже!')
                        .click();

                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
                }
            });
        })

    })
</script>
