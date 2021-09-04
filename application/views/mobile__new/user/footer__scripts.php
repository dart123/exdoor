<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.11.16
 * Time: 22:22
 */
?>


<script type="text/javascript">

    <?php
            /*
             *
             * Нотификации
             *      Закрытие нотификации и
             *
             */
    ?>

    $(document).ready( function () {


        $(".js__set_pc_version").click( function (e) {
            e.preventDefault();

            $.ajax({
                url: '/ajax/show_pc_version',
                dataType: 'json',
                type: 'POST',
                success: function (data) {
                    document.location.reload();
                }
            });
        });



        $('input[name="direction[]"]').change( function () {

            var input_value     = [];
            $('input[name="direction[]"]:checked').each(function() {
                input_value.push( $(this).val() );
            });

            if( input_value.length <= 0 ) {
                if( $(this).val() == 'sell' ) {
                    $('input[name="direction[]"][value="sell"]').prop('checked', true);
                } else if(  $(this).val() == 'buy' ) {
                    $('input[name="direction[]"][value="buy"]').prop('checked', true);
                }

                $('.notify-trigger--alert').attr('data-notifyTitle', "Внимание!")
                    .attr('data-notifyText',  "Должен быть выбран как минимум один вариант!")
                    .click();

            }

        });

        /* Заполнение профиля из сайдбара */
        $(".personal-form__step").submit(function(event) {

            event.preventDefault();

            var input           = $('.js__profile-sts__input'),
                input_type      = input.attr('name');

            if ( input_type == 'city' ) {

                input_value = $('.js__profile-sts__hidden_input').val();
                if( input_value == 0) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                        .attr('data-notifyText',  "Выберите пожалуйста город из списка!")
                        .click();
                    return;
                }

            } else if( input_type == 'direction[]') {

                input_value     = [];
                $('input[name="direction[]"]:checked').each(function() {
                    input_value.push( $(this).val() );
                });

                console.log(input_value);
                if( input_value.length <= 0 ) {
                    return;
                }


            } else {
                input_value     = input.val();
            }

            $.ajax({
                url: '/ajax/sts_user_update',
                data: {
                    'type'      : input_type,
                    'value'     : input_value
                },
                dataType: 'json',
                type: 'POST',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                },
                success: function (data) {
                    if( data ) {

                        <?php
                        /*
                            Если заполняем не бренды и не направление делятельности - обновляем данные
                        */
                        ;?>

                        if( input_type != 'brands' && input_type != 'direction' ) {

                            $(".js__user_info_block").fadeOut();

                            if( data.template == 'main' ) {
                                template            = $('#mustache__user_info_block__main').html();
                            } else if ( data.template == 'user' ) {
                                template            = $('#mustache__user_info_block__user').html();
                            }

                            output              = Mustache.render(template, data);

                            $(".js__user_info_block").replaceWith( output );



                            if( input_type == 'name' || input_type == 'last_name' ) {

                                $('.ajax__offers_full_width_container').html('').fadeOut();

                                $.ajax({
                                    url: '/ajax/load_user_content__pinned_offers',
                                    data: {
                                        'user_id'   : <?php echo $this->session->user;?>,
                                    },
                                    dataType: 'json',
                                    type: 'POST',
                                    beforeSend: function () {

                                    },
                                    success: function (data) {
                                        if (data) {
                                            template_a          = $('#mustache__ads_loop_full_width').html();
                                            template_a_modal    = $('#mustache__ads_loop_modal').html();

                                            data.forEach(function(item, i, data) {

                                                output          = Mustache.render(template_a, item);
                                                output_modal    = Mustache.render(template_a_modal, item);

                                                $('.ajax__offers_full_width_container').append([output]);
                                                $('.ajax__offers_modal_container').append([output_modal]);

                                                $('#ajax__last_loaded_offers').val(item.id);

                                            });

                                            if( data.length == 0) {
                                                $('.load-more').hide();
                                            }

                                            reinitializeMasonry();

                                        }
                                    },
                                    complete: function () {

                                    }
                                });


                                $.ajax({
                                    url: '/ajax/load_user_content',
                                    data: {
                                        'user_id'           : <?php echo $this->session->user;?>,
                                        'last_loaded_news'  : 0,
                                        'last_loaded_offers': 0,
                                        'limit'             : 10
                                    },
                                    dataType: 'json',
                                    type: 'POST',
                                    beforeSend: function () {

                                    },
                                    success: function (data) {
                                        if (data) {
                                            template_n          = $('#mustache__news_loop').html();
                                            template_n_modal    = $('#mustache__news_loop_modal').html();
                                            template_a          = $('#mustache__ads_loop_full_width').html();
                                            template_a_modal    = $('#mustache__ads_loop_modal').html();

                                            data.forEach(function(item, i, data) {
                                                if( item.post_type == 'news' )
                                                {
                                                    output          = Mustache.render(template_n, item);
                                                    output_modal    = Mustache.render(template_n_modal, item);

                                                    $('.ajax__news_container').append([output]);
                                                    $('.ajax__news_modal_container').append([output_modal]);

                                                    $('#ajax__last_loaded_news').val(item.id);

                                                }
                                                else if( item.post_type == 'offers' )
                                                {
                                                    output          = Mustache.render(template_a, item);
                                                    output_modal    = Mustache.render(template_a_modal, item);

                                                    $('.ajax__offers_full_width_container').append([output]);
                                                    $('.ajax__offers_modal_container').append([output_modal]);

                                                    $('#ajax__last_loaded_offers').val(item.id);

                                                }
                                            });

                                            if( data.length == 0) {
                                                $('.load-more').hide();
                                            }

                                            reinitializeMasonry();


                                            text  = $(".change-title").find('.filter-title').text();
                                            text1 = $(".change-title").find('.filter-title').attr("data-textF");
                                            text2 = $(".change-title").find('.filter-title').attr("data-textS");
                                            text3 = $(".change-title").find('.filter-title').attr("data-textT");

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
                                    },
                                    complete: function () {
                                        $('.ajax__offers_full_width_container').fadeIn(300);
                                    }
                                });

                            }




                        }








                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  "Спасибо! Чем больше информации вы заполните - тем лучше!")
                            .click();

                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  "В процессе обновления произошла ошибка!")
                            .click();
                    }
                },
                complete: function( result ){

                    $(".js__user_info_block").fadeIn(300);

                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
                }
            });


            $('.personal-form').removeClass('material-block-show').addClass('material-block-hide');
            setTimeout(function() {
                $('.personal-form').hide();
            }, 300);

        });

        $('.js__profile-sts__close_button').click( function () {
            event.preventDefault();

            input           = $('.js__profile-sts__input');
            input_type      = input.attr('name');

            $.ajax({
                url: '/ajax/sts_user_update',
                data: {
                    'type'      : 'notice_popup_time',
                    'value'     : input_type
                },
                dataType: 'json',
                type: 'POST',
                success: function (data) {

                    console.log( data );
                    if( data ) {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  "Мы не будем Вам больше надоедать сегодня!")
                            .click();
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  "В процессе обновления произошла ошибка!")
                            .click();
                    }
                }
            });

            $('.personal-form').removeClass('material-block-show').addClass('material-block-hide');
            setTimeout(function() {
                $('.personal-form').hide();
            }, 300);

        });

        $('body').on( 'click', '.bottom_notification-trigger__image', function() {
            if( $(this).data("url").length ) {
                document.location.href = $(this).data("url");
            }
        });

        $('body').on( 'click', '.bottom_notification-trigger__text', function() {
            if( $(this).data("url").length ) {
                document.location.href = $(this).data("url");
            }
        });

        $('body').on('click', '.bottom_notification-trigger__close', function () {
            $('.bottom_notification-trigger').fadeOut(500);

            var noty_id     = $(this).data('noty-id');
            if ( noty_id > 0  ) {
                $.ajax({
                    url:   '/ajax/close_notification',
                    data: {
                        'id'        : noty_id
                    },
                    type: 'POST',
                    dataType: 'json',
                });
            }


        });

    });

    function reinitializeMasonry(){

        var $container = $('.eq__block , .advpost__block');

        $container.imagesLoaded( function() {

            $('.js-inner-page-slider-w').each(function(){

                var slideNum = $(this).data('slider-id');

                (function () {

                    var $frame  = $('.js-inner-page-slider-w[data-slider-id="'+slideNum+'"]');
                    var $slidee = $frame.children('ul').eq(0);
                    var $wrap   = $frame.parent();

                    // Call Sly on frame
                    $frame.sly({
                        horizontal: 1,
                        itemNav: 'basic',
                        smart: 0,
                        activateOn: 'null',
                        mouseDragging: 1,
                        touchDragging: 1,
                        releaseSwing: 1,
                        startAt: 0,
                        scrollBar: $wrap.find('.scrollbar'),
                        scrollBy: 1,
                        activatePageOn: 'click',
                        pagesBar: $wrap.find('.pages'),
                        pageBuilder: function (index) {

                            console.log( $frame.find("ul > li").length );

                            if ( $frame.find("ul > li").length >= ( index + 1 ) ) {
                                return '<li>' + (index + 1) + '</li>';
                            } else {
                                return '&nbsp;';
                            }
                        },
                        speed: 300,
                        elasticBounds: 1,
                        easing: 'easeOutExpo',
                        dragHandle: 1,
                        dynamicHandle: 1,
                        clickBar: 1,

                        // Buttons
                        forward: $wrap.find('.forward'),
                        backward: $wrap.find('.backward'),
                        prev: $wrap.find('.prev'),
                        next: $wrap.find('.next'),
                        prevPage: $wrap.find('.prevPage'),
                        nextPage: $wrap.find('.nextPage')
                    });

                    // To Start button
                    $wrap.find('.toStart').on('click', function () {
                        var item = $(this).data('item');
                        // Animate a particular item to the start of the frame.
                        // If no item is provided, the whole content will be animated.
                        $frame.sly('toStart', item);
                    });

                    // To Center button
                    $wrap.find('.toCenter').on('click', function () {
                        var item = $(this).data('item');
                        // Animate a particular item to the center of the frame.
                        // If no item is provided, the whole content will be animated.
                        $frame.sly('toCenter', item);
                    });

                    // To End button
                    $wrap.find('.toEnd').on('click', function () {
                        var item = $(this).data('item');
                        // Animate a particular item to the end of the frame.
                        // If no item is provided, the whole content will be animated.
                        $frame.sly('toEnd', item);
                    });
                }());

            });

            $container.masonry( {
                itemSelector: '.eq__item , .advpost__item',
                isResizeBound: true,
                percentPosition: true,
                transitionDuration: 0,
                hiddenStyle: { opacity: 0 },
                visibleStyle: { opacity: 1 }
            } );

            $container.show();

            $container.masonry( 'reloadItems' );
            $container.masonry( 'layout' );
        });
    }

    <?php /* Обработчики socket_io ;*/;?>





    $('body').on( 'mousedown', '.reply', function (e) {

        var target_obj      = e.target;
        var obj             = $(this).find('.lower-layer');
        var news_id         = obj.attr('data-news-id');
        var name            = obj.attr('data-name');
        var author_id       = obj.attr('data-author-id');
        var current_user    = <?php echo $this->session->user;?>;

        if( current_user != author_id && ( $( target_obj ).hasClass('lower-layer') ||  $( target_obj ).hasClass('reply__text') ) )
            $('.news-'+news_id+ '-replay').closest('div.news-advpost__form').addClass('show-reply', function(){
                $('.news-'+news_id+ '-replay').focus().val( name );
            });
    /*

        if( $('.news-'+news_id+ '-replay').val().length == 0)
        {
            if( current_user != author_id )
                $('.news-'+news_id+ '-replay').focus().val( name ).closest('div.news-advpost__form').addClass('show-reply');

        }
    */
    });
</script>
