<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 18:20
 */
?>

<script>
    $(window).scroll(function () {

        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom <= 150 && !$('body').hasClass('js--loading')) {

            $('body').addClass('js--loading');

            user_id             = $('#ajax__news-user_id').val();
            last_loaded_news    = $('#ajax__last_loaded_news').val();
            last_loaded_offers  = $('#ajax__last_loaded_offers').val();

            $.post('/ajax/load_user_content',
                {
                    'user_id'           : user_id,
                    'last_loaded_news'  : last_loaded_news,
                    'last_loaded_offers': last_loaded_offers,
                    'limit'             : 10
                },
                function(result) {
                    if (result) {

                        data = $.parseJSON(result);
                        console.log(data);
                        console.log(data.length);

                        if (data.length > 0) {
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

                        } else {

                            if( !$('.ajax__news_container').hasClass('info--all-news-loaded') ){
                                $('.load-more').hide();
                                $('.notify-trigger--alert').attr('data-notifyTitle', "Это все записи")
                                    .attr('data-notifyText',  'Вы загрузили все записи, что есть')
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
</script>
