<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 10:20
 */

?>

<script>
    $(document).ready( function ( ) {

        $('body').on( 'click', '.ajax__employer_remove', function () {

            action_button   = $(this);
            employer_id     = action_button.data('employer-id');
            $('.js__company__modal__remove_employer').data('employer-id', employer_id);

            $.fancybox({
                'href'      : '#company__modal__remove_employer',
                'closeBtn'  : false
            });


        });

        $('body').on( 'click', '.js__company__modal__remove_employer', function () {

            action_button   = $(this);
            employer_id     = action_button.data('employer-id');

            $.ajax({
                url:   '/ajax/remove_employer',
                data: {
                    employer_id:    employer_id,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                },
                success: function(result){
                    if (result =='removed') {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Успешно")
                            .attr('data-notifyText',  'Сотрудник больше не состоит в Вашей компании')
                            .click();

                        $('.my-candidats-edit-row[data-partner-id='+employer_id+']').hide(300);
                        $.fancybox.close();
                    }
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
