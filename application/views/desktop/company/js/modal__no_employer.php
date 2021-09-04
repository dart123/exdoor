<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 10:15
 */
?>

<script>
    $(document).ready( function() {


        $('body').on( 'click', '.ajax-candidat-noemployer', function () {

            event.preventDefault();
            var candidat    = $(this).attr('data-candidat-id');
            var parent_div  = $(this).parent().parent();

            $('.js__company__modal__no_employer').data('candidat-id', candidat);

            $.fancybox.open({
                src         : '#company__modal__no_employer',
                closeBtn    : false
            });


        });

        $('.js__company__modal__no_employer').click( function () {

            var action_button   = $(this);
            var employer_id     = action_button.data('candidat-id');

            $.ajax({
                url:   '/ajax/remove_employer',
                data: {
                    employer_id:    employer_id,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){

                },
                success: function(result){
                    if (result == 'removed') {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Успешно")
                            .attr('data-notifyText',  'Вы успешно отклонили заявку пользователя')
                            .click();

                        $('.js__candidat_employer__' + employer_id + '__company_page').hide(300, function(){
                            $('.js__candidat_employer__' + employer_id + '__company_page').remove();
                        });
                        $.fancybox.close();
                    }
                },
                complete: function( result ){

                    if( $('.js__company__page_edit__candidats__list').length > 0 ) {
                        if( $('.js__company__page_edit__candidats__list').find('.my-candidats-edit-row').length == 0 ) {
                            $('.js__company__page_edit__candidats__title').remove();
                            $('.js__company__page_edit__candidats__list').remove();

                        }
                    }

                }
            });

        });

    });
</script>
