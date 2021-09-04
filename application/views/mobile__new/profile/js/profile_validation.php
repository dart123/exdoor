<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.07.17
 * Time: 12:33
 */

?>

<script>
    $(document).ready( function () {

        $('.selectize-input').click( function () {
            $(this).removeClass('input__wrong_data');
        });

        $('input[name="direction_sell"], input[name="direction_buy"]').change( function () {

            $('.show__label-c').removeClass('input__wrong_data');

            profile_sell    = $('input[name=direction_sell]').prop('checked');
            profile_buy     = $('input[name=direction_buy]').prop('checked');

            if( profile_sell == false && profile_buy == false ) {
                if( $(this).attr('name') == 'direction_sell' ) {
                    $('input[name="direction_sell"]').prop('checked', true);
                } else if(  $(this).attr('name') == 'direction_buy' ) {
                    $('input[name="direction_buy"]').prop('checked', true);
                }

                $('.notify-trigger--alert').attr('data-notifyTitle', "Внимание!")
                    .attr('data-notifyText',  "Должен быть выбран как минимум один вариант!")
                    .click();
            }
        });


        $('.profile__save_button').click( function () {

            error           = 0;
            focusObject     = false;

            if ( !$('#js-input-city-hidden').val()  ) {
                $('#js-autocomplete-city__profile').addClass('input__wrong_data');
                focusObject     = $('#js-autocomplete-city__profile');
                error++;
            }


            if ( !$('#js__select__brand_tags').val() ) {
                $('.selectize-input').addClass('input__wrong_data');
                focusObject     = $('.selectize-input');
                error++;
            }


            if ( $('input[name=direction_sell]').prop('checked') == false && $('input[name=direction_buy]').prop('checked') == false ) {

                $('.show__label-c').addClass('input__wrong_data');
                focusObject     = $('input[name=direction_sell]');
                error++

            }

            if( error == 0 ){
                var direction_sell  = 0;
                var direction_buy   = 0;
                var show_phone      = 0;

                if ( $('input[name=direction_sell]').prop('checked') == true )
                    direction_sell  = 'sell';

                if ( $('input[name=direction_buy]').prop('checked') == true )
                    direction_buy  = 'buy';

                if ( $('input[name=show_phone]').prop('checked') == true )
                    show_phone  = '1';

                $.ajax({
                    url:   '/ajax/profile__save',
                    data: {
                        name            : $('input[name=name]').val(),
                        last_name       : $('input[name=last_name]').val(),
                        second_name     : $('input[name=second_name]').val(),
                        profession_id   : $('input[name=profession_id]').val(),
                        city            : $('input[name=city]').val(),
                        contact_phone   : $('input[name=contact_phone]').val(),
                        show_phone      : show_phone,
                        direction_sell  : direction_sell,
                        direction_buy   : direction_buy,
                        brand           : $('select[name="brand[]"]').val(),
                        email           : $('input[name=email]').val(),
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

            } else {

                focusObject.focus();

                $('.notify-trigger--alert').attr('data-notifyTitle', "Внимание!")
                    .attr('data-notifyText',  "Все обязательные поля должны быть заполнены!")
                    .click();
            }

        });
    })
</script>
