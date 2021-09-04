<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:29
 *
 *      Загрузка по скролу
 */

?>

<script>
    $(window).scroll(function () {

        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom <= 150 && !$('body').hasClass('js--loading')) {

            $('body').addClass('js--loading');

            var type                = $('input[name="filter__type"]').val(),
                offset              = $('.ajax__offers_container .advpost__item').size(),
                category            = [],
                brand               = [],
                price               = $('input[name="filter__price"]').val(),
                max_price           = $('input[name="filter__max_price"]').val(),
                barter              = 'no',

                sort_by             = $('select[name="filter__sort_by"]').val();

            $('input[name="filter__category[]"]:checked').each(function() {
                category.push($(this).val());
            });
            $('input[name="filter__brand[]"]:checked').each(function() {
                brand.push($(this).val());
            });

            if ( $('input[name="filter__barter"]').prop('checked') == true ) {
                barter      = 'yes';
            }

            $.post('/ajax/get_offers',
                {
                    'offset'    : offset,
                    'type'      : type,
                    'category'  : category,
                    'brand'     : brand,
                    'price'     : price,
                    'max_price' : max_price,
                    'sort_by'   : sort_by,
                    'barter'    : barter
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
                    $('body').removeClass('js--loading');
                }
            );
        }
    });
</script>
