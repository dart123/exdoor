<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-02-02
 * Time: 14:48
 */
?>

<script>
    $(window).scroll(function () {

        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom == 0) {
            var offset              = $('.ajax__offers_container .advpost__item').size();

            $.post('/ajax/get_offers',
                {
                    'offset'    : offset,
                    'keyword'   : '<?php echo $keyword;?>',
                },
                function(result) {
                    if (result) {

                        var data = $.parseJSON(result);
                        if (data) {
                            var template        = $('#mustache__ads_loop').html(),
                                template_modal  = $('#mustache__ads_loop_modal').html();

                            data.forEach(function(item, i, data) {
                                var output          = Mustache.render(template, item),
                                    output_modal    = Mustache.render(template_modal, item);

                                $('.ajax__offers_container').append([output]);
                                $('.ajax__offers_modal_container').append([output_modal]);

                                $('#ajax__last_loaded_ads').val(item.id);
                            });

                            if( data.length == 0) {
                                $('.load-more').hide();
                            }

                            reinitializeMasonry();
                        } else {
                            if( !$('.ajax__offers_container').hasClass('info--all-offers-loaded') ){
                                $('.load-more').hide();
                                $('.notify-trigger--alert').attr('data-notifyTitle', "Это все объявления")
                                    .attr('data-notifyText',  'Вы загрузили все актуальные объявления')
                                    .click();
                                $('.ajax__offers_container').addClass('info--all-offers-loaded');
                            }
                        }
                    }
                }
            );
        }
    });
</script>
