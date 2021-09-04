<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:16
 */
?>

<script>
    $(window).scroll(function () {
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        console.log( scrollBottom );

        if (scrollBottom <= 150 && !$('body').hasClass('js--loading')) {

            $('body').addClass('js--loading');

            var user_id             = <?php if( isset($page_content["project_news"]) && $page_content["project_news"] ):?>1<?php else:?> $('#ajax__news-user_id').val()<?php endif;?>;
            var taxonomy            = "<?php if( isset( $page_content["taxonomy"] ) && is_array($page_content["taxonomy"]) ): $page_content["taxonomy"]['slug']; else: echo ''; endif;?>";
            var last_loaded_news    = $('#ajax__last_loaded_news').val();

            $.post('/ajax/load_news',
                {
                    'user_id'           : user_id,
                    'taxonomy'          : taxonomy,
                    'last_loaded_news'  : last_loaded_news,
                    'limit'             : 10
                },
                function(result) {

                    if (result) {

                        var data = $.parseJSON(result);
                        if (data) {

                            var template        = $('#mustache__news_loop').html(),
                                output          = Mustache.render(template, data);
                            $('.ajax__news_container').append([output]);


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
</script>
