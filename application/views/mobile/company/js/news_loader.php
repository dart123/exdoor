<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.07.17
 * Time: 23:27
 */

?>

<script>















    $(window).scroll(function () {
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom <= 150 && !$('body').hasClass('js--loading')) {

            $('body').addClass('js--loading');

            var text    = $('.change-title-com').find('.filter-title').text(),
                text1   = $('.change-title-com').find('.filter-title').attr("data-textCF"),
                text2   = $('.change-title-com').find('.filter-title').attr("data-textCS"),
                text3   = $('.change-title-com').find('.filter-title').attr("data-textCT"),

                // ajax call params
                company_id          = $('#ajax__news-company_id').val(),
                last_loaded_news    = $('#ajax__last_loaded_news').val(),
                type                = 'lenta',
                employers_only      = 0;

            if (text == text1) {
                // Переключаем на "ТОЛЬКО компании"
                console.log('company only');
                type            = 'solo';
                employers_only  = 0;

            } else if (text == text2) {
                // Переключаем на "Сотрудников и компании"
                console.log('employers only');
                type            = 'lenta';
                employers_only  = 1;

            } else if (text == text3) {
                // Переключаем на "Сотрудников и компании"
                console.log('all');
                type            = 'lenta';
                employers_only  = 0
            }

            $.post('/ajax/load_news',
                {
                    'company_id'        : company_id,
                    'last_loaded_news'  : last_loaded_news,
                    'type'              : type,
                    'employers_only'    : employers_only,
                    'limit'             : 10
                },
                function(result) {

                    if (result) {

                        var data = $.parseJSON(result);

                        console.log( data);

                        if (data) {
                            var template        = $('#mustache__news_loop').html(),
                                template_modal  = $('#mustache__news_loop_modal').html(),
                                output          = Mustache.render(template, data),
                                output_modal    = Mustache.render(template_modal, data);
                            $('.ajax__news_container').append([output]);
                            $('.ajax__news_modal_container').append([output_modal]);


                            data.forEach(function(item, i, data) {
                                $('#ajax__last_loaded_news').val(item.id);
                            });

                            reinitializeMasonry();

                        } else {
                            if( !$('.ajax__news_container').hasClass('info--all-news-loaded') ){
                                $('.load-more').hide();
                                $('.notify-trigger--alert').attr('data-notifyTitle', "Это все новости")
                                    .attr('data-notifyText',  'Вы загрузили все последние новости')
                                    .click();
                                $('.ajax__news_container').addClass('info--all-news-loaded')
                            }
                        }
                    }
                    $('body').removeClass('js--loading');
                }
            );
        }
    });


    $('body').on('click', '.change-title-com', function() {
        event.preventDefault();

        var text    = $(this).find('.filter-title').text(),
            text1   = $(this).find('.filter-title').attr("data-textCF"),
            text2   = $(this).find('.filter-title').attr("data-textCS"),
            text3   = $(this).find('.filter-title').attr("data-textCT"),

            // ajax call params
            company_id          = $('#ajax__news-company_id').val(),
            type                = 'lenta',
            employers_only      = 0;


        if (text == text1) {
            // Переключаем на "ТОЛЬКО СОТРУДНИКОВ"
            $(this).find(".filter-title").text(text2);
            type            = 'lenta';
            employers_only  = 1;

        } else if (text == text2) {
            // Переключаем на "Сотрудников и компании"
            $(this).find(".filter-title").text(text3);
            type            = 'lenta';
            employers_only  = 0;

        } else if (text == text3) {
            // Переключаем на "ТОЛЬКО КОМПАНИИ"
            $(this).find(".filter-title").text(text1);
            type            = 'solo';
            employers_only  = 0
        }

        $.post('/ajax/load_news',
            {
                'company_id'        : company_id,
                'last_loaded_news'  : false,
                'type'              : type,
                'employers_only'    : employers_only,
                'limit'             : 10
            },
            function(result) {

                $('.ajax__news_container').html('').removeClass('info--all-news-loaded');
                $('.ajax__news_modal_container').html('').removeClass('info--all-news-loaded');

                if (result) {

                    var data = $.parseJSON(result);

                    if (data) {

                        var template        = $('#mustache__news_loop').html(),
                            template_modal  = $('#mustache__news_loop_modal').html(),
                            output          = Mustache.render(template, data),
                            output_modal    = Mustache.render(template_modal, data);

                        $('.ajax__news_container').append([output]);
                        $('.ajax__news_modal_container').append([output_modal]);


                        data.forEach(function(item, i, data) {
                            $('#ajax__last_loaded_news').val(item.id);
                        });

                        reinitializeMasonry();

                    } else {
                        if( !$('.ajax__news_container').hasClass('info--all-news-loaded') ){
                            $('.load-more').hide();
                            $('.notify-trigger--alert').attr('data-notifyTitle', "Это все новости")
                                .attr('data-notifyText',  'Вы загрузили все последние новости')
                                .click();
                            $('.ajax__news_container').addClass('info--all-news-loaded')
                        }
                    }
                }
            }
        );

    })







</script>
