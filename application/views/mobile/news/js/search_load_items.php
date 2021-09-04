<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-02-02
 * Time: 13:52
 */

?>

<script>
    $(window).scroll(function () {
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom <= 150 && !$('body').hasClass('js--loading')) {

            $('body').addClass('js--loading');

            var last_loaded_news    = $('#ajax__last_loaded_news').val();

            $.post('/ajax/load_news',
                {
                    'keyword'           : "<?php echo $page_content['keyword'];?>",
                    'last_loaded_news'  : last_loaded_news,
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
