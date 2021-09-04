<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:31
 */
?>
<script>

    $( document ).ready( function() {

        $('.input__wrong_data').change( function () {
            if( $(this).val() != '' ) {
                $(this).removeClass('input__wrong_data');
            }
        });


        $('.js__req__modal__send_answer__open').click( function() {

            required_field = true;

            $('.js__form__required-field').each( function (index) {

                if( $(this).data('input-name') == "shipping" ) {
                    var pos_id  = $(this).data('position-id');

                    if( $('#requests-eq__isnot__'+ pos_id).prop('checked') == true && $(this).val() == '' ) {
                        $(this).addClass('input__wrong_data');
                        required_field = false;
                    }
                } else {
                    if( $(this).val() == '' ) {
                        $(this).addClass('input__wrong_data');
                        required_field = false;
                    }
                }


            });

            if ( !required_field || $('input[name="actual"]').val() == '' ) {

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Вы должны заполнить все обязательные поля')
                    .click();

            } else {

                $.fancybox.open({
                    src         : '#req__modal__send_answer',
                    closeBtn    : false
                });

            }



        });

        $('.js__request_add_form_submit').click( function () {

            $('.request__add_form').submit();

        });


    });

</script>
