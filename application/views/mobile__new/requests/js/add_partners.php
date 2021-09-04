<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:37
 */

?>

<script>
    $('body').on('click', '.js__request__add_partners', function () {

        count_partners      = 0;
        avalible_partners   = 10;

        $('.ajax__selected_partners_container > .js__request__selected_partner').each( function (index) {
            count_partners++;
        });

        avalible_partners   -= count_partners;

        if( avalible_partners > 0 ) {

            partner_id              = $(this).closest('.my-partners__rcell').data('partner-id');
            partners                = [];
            partners_json           = '';
            partner_obj             = $('.my-partners__row__user_'+partner_id);
            parent_obj_container    = partner_obj.parent();

            $('.ajax__selected_partners_container > .my-partners__row__user_' + partner_id).css('display', 'table');
            partner_obj.addClass('js__request__selected_partner');
            partner_obj.find('.choose-partner').addClass('is-hidden');
            partner_obj.find('.choosen-partner').removeClass('is-hidden');


            if(  $('.ajax__selected_partners_container').find('.my-partners__row__user_' + partner_id).length == 0  ) {
                if( $('.my-partners__row__friends_delimiter').length > 0 )
                    $('.my-partners__row__friends_delimiter').removeClass('is-hidden');
                $('.ajax__selected_partners_container').append(  $(this).closest('.my-partners__row__user_' + partner_id).clone()  );
            }

            $('.js__avalible_partners_counter').text( avalible_partners-1 );

        } else {

        }




    });

    $('body').on('click', '.js__request__remove_partners', function(){

        partner_id      = $(this).closest('.my-partners__rcell').data('partner-id');
        partners        = [];
        partners_json   = '';
        partner_obj     = $('.my-partners__row__user_'+partner_id);

        if( $('.js__add_request__partners_model').find('.my-partners__row__user_' + partner_id ).length == 1 ) {

            if ( $('.ajax__selected_partners_container > div').length > 10 )
                $('.ajax__selected_partners_container > .my-partners__row__user_' + partner_id).remove();

            partner_obj.find('.choose-partner').removeClass('is-hidden');
            partner_obj.find('.choosen-partner').addClass('is-hidden');

        } else {

            partner_obj.removeClass('js__request__selected_partner');
            partner_obj.find('.choose-partner').removeClass('is-hidden');
            partner_obj.find('.choosen-partner').addClass('is-hidden');

        }



        count_partners      = 0;
        avalible_partners   = 10;

        $('.ajax__selected_partners_container > .js__request__selected_partner').each( function (index) {
            count_partners++;
        });

        avalible_partners   -= count_partners;
        $('.js__avalible_partners_counter').text( avalible_partners );
    });


    $('body').on('click', '.js__request__add__select_partners', function (event) {
        event.preventDefault();

        if( $(this).hasClass("disabled") )
            return;

        var partners        = [];

        $('.ajax__selected_partners_container > .js__request__selected_partner').each( function (index) {
            partners.push( $(this).data('partner-id')  );
        });

        $.ajax({
            url:   '/ajax/requests__add_partners',
            data: {
                partners           : partners,
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                $('.preloader').fadeIn();
                $('.preloader__img').fadeIn();
                $('body').delay(350).css({'overflow':'hidden'});
                $('.js__request__add__select_partners').prop('disabled', true);
            },
            success: function ( result ) {
                if( result != 'not added' && result != 'not array' && result != 'no connection' && result != 'already send')
                    document.location.href = "<?=$this->config->item('base_url');?>"+result;
                else if ( result == 'not array') {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Вы должны выбрать хотя бы одного партнера!')
                        .click();
                } else if ( result == 'not added') {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Произошла ошибка, не удалось отправить заявку партнерам. Повторите еще раз!')
                        .click();
                } else if ( result == 'no connection') {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText', 'Сервер недоступен, функционал ограничен! Попробуйте позднее')
                        .click();
                } else if ( result == 'already send') {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText', 'Похоже, что Ваша завяка уже отправлена партнерам. Просто обновите страницу.')
                        .click();
                    $('.js__request__add__select_partners').addClass("disabled").html("Похоже, заявка уже отправлена. Перезагрузите страницу");
                }
            },
            error: function( result ){
                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow':'visible'});

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Произошла ошибка при передачи данных в базу. Повторите еще раз!')
                    .click();

                $('.js__request__add__select_partners').prop('disabled', false);
            },
            complete: function( result ){

                if ( result.responseText == '"already send"' ) {

                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
                }
                else if( result.responseText == '"not added"' || result.responseText == '"not array"' || result.responseText == '"no connection"' ) {

                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});

                    $('.js__request__add__select_partners').prop('disabled', false).removeClass("disabled");
                }
            }
        })
    });

</script>
