<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 10:19
 */

?>

<script>
    $(document).ready( function ( ) {

        $('body').on('click', '.ajax-candidat-employer', function ( event ) {

            event.preventDefault();

            var candidat    = $(this).attr('data-candidat-id');
            var role        = $('#role_candidat-'+candidat );
            var profession  = $('#profession_candidat-'+candidat );
            var parent_div  = $(this).parent().parent();

            if (  ( role.val() != null ) && ( profession.val() != '' )  ) {

                $.ajax({
                    url: '/ajax/candidat_employer',
                    data: {
                        'candidat'      : candidat,
                        'role'          : role.val(),
                        'profession'    : profession.val()
                    },
                    dataType: 'json',
                    type: 'POST',
                    beforeSend: function () {
                        $('.preloader__img').fadeIn();
                        $('.preloader').fadeIn('slow');
                    },
                    success: function (result) {

                        if (result) {

                            $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно!')
                                .attr('data-notifyText', 'Теперь в Вашей компании на одного сотрудника больше!')
                                .click();

                            // Если принимаем пользователя на странице редактирования компании
                            if( $('.js__company__page_edit__candidats__list').length > 0 ) {
                                $('.js__company__page_edit__candidats__list').find('.my-candidats-edit-row[data-partner-id="'+candidat+'"]').remove();
                                parent_div.removeClass('material-block-show').addClass('material-block-hide').slideUp(300);

                                //
                                document.location.reload();
                            }


                            // Если принимаем с главной "Моя компания", обновляем контент

                            $.ajax({
                                url: '/ajax/reload_company_news',
                                dataType: 'json',
                                type: 'POST',
                                beforeSend: function () {

                                },
                                success: function (data) {
                                    if (data) {

                                        console.log('news');
                                        console.log(data);
                                        $('.ajax__news_container').html('');

                                        if( $('#mustache__news_loop').length > 0 && $('#mustache__news_loop_modal').length > 0 ) {


                                            var template_n          = $('#mustache__news_loop').html();
                                            var template_n_modal    = $('#mustache__news_loop_modal').html();

                                            data.forEach(function(item, i, data) {

                                                var output          = Mustache.render(template_n, item);
                                                var output_modal    = Mustache.render(template_n_modal, item);

                                                $('.ajax__news_container').append([output]);
                                                $('.ajax__news_modal_container').append([output_modal]);

                                                $('#ajax__last_loaded_news').val(item.id);


                                            });

                                            if( data.length == 0) {
                                                $('.load-more').hide();
                                            }

                                            reinitializeMasonry();


                                            var text  = $(".change-title").find('.filter-title').text();
                                            var text1 = $(".change-title").find('.filter-title').attr("data-textF");
                                            var text2 = $(".change-title").find('.filter-title').attr("data-textS");
                                            var text3 = $(".change-title").find('.filter-title').attr("data-textT");

                                            if (text == text1) {
                                                $('.news-advpost').fadeIn(300);
                                                $('.advpost').fadeIn(300);
                                            } else if (text == text2) {
                                                $('.news-advpost').fadeOut(300);
                                                $('.advpost').fadeIn(300);
                                            } else if (text == text3) {
                                                $('.news-advpost').fadeIn(300);
                                                $('.advpost').fadeOut(300);
                                            }


                                        }


                                    }
                                },
                                complete: function () {

                                }
                            });



                            $.ajax({
                                url: '/ajax/reload_company_requests',
                                dataType: 'json',
                                type: 'POST',
                                beforeSend: function () {

                                },
                                success: function (data_r) {
                                    if (data_r && data_r.length > 0) {


                                        if( $('#mustache__request_loop__block').length > 0) {

                                            $('.ajax__company_requests_container').html('');
                                            var template_r        = $('#mustache__request_loop__block').html();

                                            $('.js__company_requests_container__header').removeClass('is-hidden');

                                            data_r.forEach(function(item, i, data_r) {
                                                var output_r          = Mustache.render(template_r, item);
                                                $('.ajax__company_requests_container').append([output_r]);
                                            });

                                        }


                                    }
                                },
                                complete: function () {






                                    $('.preloader__img').fadeOut();
                                    $('.preloader').delay(350).fadeOut('slow');

                                    if( $('.js__company__page_edit__candidats__list').length > 0 ) {
                                        if ( $('.js__company__page_edit__candidats__list').find('.my-candidats-edit-row').length == 0 ) {
                                            $('.js__company__page_edit__candidats__title').remove();
                                            $('.js__company__page_edit__candidats__list').remove();

                                        }
                                    }





                                }
                            });


                        } else {
                            $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                                .attr('data-notifyText',  'Не удалось добавить сотрудника в Вашу организацию. Обратитесь к администратору сайта')
                                .click();
                        }

                    },
                    complete: function() {

                    }
                });

                $('.js__candidat_employer__' + candidat + '__company_page').fadeOut(300, function () {
                    $(this).remove();
                });

            } else {
                if (  ( role.val() == null ) && ( profession.val() == '' )   ) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                        .attr('data-notifyText',  'Выберите роль и укажите должность сотрудника')
                        .click();
                    role.addClass('input__wrong_data').focus();
                    profession.addClass('input__wrong_data');
                } else if ( role.val() == null &&  profession.val() != '' ) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                        .attr('data-notifyText',  'Выберите роль сотрудника')
                        .click();
                    role.addClass('input__wrong_data').focus();
                } else if ( role.val() != null && profession.val() == '' ) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                        .attr('data-notifyText',  'Укажите должность сотрудника')
                        .click();
                    profession.addClass('input__wrong_data').focus();
                }
            }


        });

    })
</script>

