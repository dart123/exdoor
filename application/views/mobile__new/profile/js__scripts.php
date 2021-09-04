<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 24.02.2017
 * Time: 18:00
 */

?>


<script>

    if( $('#profile__company__form__add_company').length > 0 ) {

        document.querySelector('#profile__company__form__add_company').addEventListener('submit', function(e) {

            $('.my-company-profile__submit').prop('disabled', true);

        });

    }






    $(document).ready( function () {












        /*
         *
         *
         *  Обновление аватара по ajax на странице профиля
         *
         *
         */

        $('.ajax-upload-avatar-profile').change(function(){

            var input    = $(this);
            var fd       = new FormData;

            if( input.prop('files')[0].size > 7900000) {

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                    .click();
                return;

            };

            fd.append('img', input.prop('files')[0]);

            $.ajax({
                url: '/ajax/avatar_upload',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                },
                success: function (result) {
                    var data  = $.parseJSON(result),
                        alert;
                    if( data.status == 'success' ){
                        alert = $('.notify-trigger--success');


                        $('.my-pers-profile__photo').css({
                            'backgroundImage': 'url(/uploads/users/'+data.id+'/avatar/180x180_'+data.image+')',
                            'backgroundRepeat': 'no-repeat',
                            'backgroundPosition': 'center center'
                        });
                        $('.helpers-signs__content').html('');

                        $('.js__remove_avatar').removeClass('is-hidden');


                    } else  {
                        alert = $('.notify-trigger--alert');
                    }



                    alert.attr('data-notifyTitle', data.title)
                        .attr('data-notifyText',  data.text)
                        .click();

                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
                }
            });

        });




        $('.js__remove_avatar').click( function( ) {

            user_id     = $(this).data('user_id');
            action      = $(this).data('action');

            if( action == 'remove_avatar' ) {
                $.ajax({
                    url: '/ajax/avatar_remove',
                    data: {
                        'user_id': user_id,
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function (data) {

                        if( data ) {

                            $('.my-pers-profile__photo').css({'backgroundColor': '#b1eaf1', 'backgroundImage' : 'none'});
                            $('.helpers-signs__content').html('<div class="helpers-signs__icons"><i class="fa fa-user"></i> </div><span>Изменить аватар</span>');
                            $('.helpers-signs__content').show();

                            $('.js__remove_avatar').addClass('is-hidden');

                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  "Аватар успешно удален!")
                                .click();
                        } else {
                            $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                                .attr('data-notifyText',  "В процессе удаления аватара произошла ошибка!")
                                .click();
                        }
                    }
                });
            }

        });






        if( $('#company__invite-manager__message').length > 0 )
            letter_counter_400( $('#company__invite-manager__message') );

        // Для Пригласить руководителя
        $("body").on('keyup', ".limit-400", function(){
            letter_counter_400( $('#company__invite-manager__message') );
        });
        // Для Пригласить руководителя
        $("body").on('keyup', ".limit-50", function(){
            letter_counter_50( $('#company__invite-manager__message') );
        });

        $("body").on('keyup', ".limit-sms", function(){
            letter_counter_sms( $('#company__invite-manager__message') );
        });



        $('#js-autocomplete-city__profile').autocomplete({

            serviceUrl:'/ajax/get_city',
            minChars:2,
            noCache: false,
            onSearchStart:
                function () {
                    $('#js-input-city-hidden').val( '' );

                },
            onSelect:
                function(suggestion){
                    $('#js-input-city-hidden').val( suggestion.data.city_id );
                    $(this).removeClass('input__wrong_data');
                },
            onSearchError:
                function() {
                    $('#js-input-city-hidden').val( '' );
                    $(this).addClass('input__wrong_data');
                },
            formatResult:
                function(suggestion, currentValue){
                    return (suggestion.data.name+', '+ suggestion.data.region + ', ' +suggestion.data.country);
                }
        });

        /*      СТРАНИЦА КОМПАНИИ        */

        $(function() {
            $("#choose-portrait-img").change(showPreviewImage_click);
        });










        $('.my-company-profile__submit').prop('disabled', true);

        $("#dadata_input_field__inn").suggestions({
            mobileWidth: '10',
            serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
            token: "e42baa031f283e1377b9a5cbc3c421547f8dc33f",
            type: "PARTY",
            count: 15,
            params: {
                status:  ["ACTIVE"]
            },
            /* Вызывается, когда пользователь выбирает одну из подсказок */
            onSelect: function(suggestion) {
                $('#input-company-fullname').val( suggestion.data.name.full_with_opf );
                $('#input-company-shortname').val( suggestion.data.name.short_with_opf );
                $('#input-company-inn').val( suggestion.data.inn );
                $('#input-company-kpp').val( suggestion.data.kpp );
                $('#input-company-ogrn').val( suggestion.data.ogrn );
                $('#input-company-address').val( suggestion.data.address.value );

                if(suggestion.data.type == 'INDIVIDUAL') {
                    $('#input-company-manager').val( suggestion.data.name.full );
                    $('#input-company-manager-post').val( suggestion.data.opf.full );
                    $('#input-company-type').val('INDIVIDUAL');
                } else {
                    $('#input-company-type').val('ORGANIZATION');
                    if(suggestion.data.management != null){
                        $('#input-company-manager').val( suggestion.data.management.name );
                        $('#input-company-manager-post').val( suggestion.data.management.post );
                    }
                }

                $('.my-company-profile__submit').prop('disabled', false);

            },
            onSelectNothing: function(){
                $('.my-company-profile__submit').prop('disabled', true);
            },
            onSearchStart: function(){
                $('.my-company-profile__submit').prop('disabled', true);
            }
        });



    });




</script>
