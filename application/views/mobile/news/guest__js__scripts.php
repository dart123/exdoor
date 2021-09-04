<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:23
 */
?>


<script>
    window.addEventListener('popstate', function(e) {
        // $.fancybox.close();
        if( (history.state != null) && ('id' in history.state) && (history.state.id != undefined)) {
            var id          = history.state.id;
            $.fancybox.open('#news-post'+id);
        } else {
            $.fancybox.close();
        }
    });

    $('.fancybox__adv-news').fancybox({
        helpers     : {
            overlay : {
                locked: true
            }
        },
        afterClose  : function () {
            history.pushState( null, null, '/news/');
        }
    });

    $('body').on( 'click', '.fancybox__adv-news', function () {
        var id = $(this).attr('data-id');
        if( id != undefined)
            history.pushState( { 'id' : id }, null, '/news/'+id);
    });

    $(window).scroll(function () {
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom <= 150 && !$('body').hasClass('js--loading')) {

            $('body').addClass('js--loading');

            var user_id              = <?php if( isset($page_content["project_news"]) && $page_content["project_news"] ):?>1<?php else:?> $('#ajax__news-user_id').val()<?php endif;?>,
                last_loaded_news     = $('#ajax__last_loaded_news').val();

            $.post('/ajax/load_news',
                { 'user_id': 1, 'last_loaded_news': last_loaded_news, 'limit': 5 },
                function(result) {

                    if (result) {

                        var data = $.parseJSON(result);
                        if (data) {
                            var template        = $('#guest__mustache__news_loop').html(),
                                template_modal  = $('#guest__mustache__news_loop_modal').html(),
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

</script>
