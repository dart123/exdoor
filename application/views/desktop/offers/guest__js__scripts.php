<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:44
 */

?>



<script>



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


    /*

     Слушаем клик "Назад" в браузере.
     Если есть в стеке позиции - возвращаемся назад в истории

     */

    window.addEventListener('popstate', function(e) {
        // $.fancybox.close();
        if( (history.state != null) && ('id' in history.state) && (history.state.id != undefined)) {
            var id          = history.state.id;

            //fancy_link  = $(".fancybox__adv-news[href='#adv-post"+ id +"']");
            //fancy_link.removeAttr('data-id').fancybox().trigger('click').attr('data-id', id);

            $.fancybox.open('#adv-post'+id);
        } else {
            $.fancybox.close();
        }

    });


    $(document).ready(function () {

        /*

         Открываем пост в модальном окне.
         Добавляем в историю, чтобы можно было по кнопке браузера вернуться "Назад"

         */

        $('.fancybox__adv-news').fancybox({
            helpers     : {
                overlay : {
                    locked: true
                }
            },
            afterClose  : function () {
                history.pushState( null, null, '/offers/<?php echo $ads_type;?>/');
            }
        });

        $('body').on( 'click', '.fancybox__adv-news', function () {
            var id = $(this).attr('data-id');
            if( id != undefined) {

                history.pushState( { 'id' : id }, null, '/offers/<?php echo $ads_type;?>/'+id);

                $.ajax({
                    url:   '/ajax/offers__view',
                    data: {
                        'offer_id'      : id,
                    },
                    type: 'POST',
                    dataType: 'json',
                });
            }

        });

        $('.ajax__adv_filter_input').change( function() {

            filter_link = '',
                type        = $('input[name="filter__type"]').val(),
                category    = [],
                brand       = [],
                price       = $('input[name="filter__price"]').val(),
                max_price   = $('input[name="filter__max_price"]').val(),
                barter      = 'no',

                sort_by     = $('select[name="filter__sort_by"]').val();

            filter_link += '?filter=true';
            filter_link += '&type='+type;
            filter_link += '&price='+price;
            filter_link += '&max_price='+max_price;
            filter_link += '&sort_by='+sort_by;

            $('input[name="filter__category[]"]:checked').each(function() {
                filter_link += '&cat[]='+$(this).val();
                category.push($(this).val());
            });
            $('input[name="filter__brand[]"]:checked').each(function() {
                filter_link += '&brand[]='+$(this).val();
                brand.push($(this).val());
            });

            if ( $('input[name="filter__barter"]').prop('checked') == true ) {
                barter          = 'yes';
                filter_link     += '&barter=yes';
            }

            history.pushState(
                {
                    'id'        : 'filter_action',
                    'type'      : type,
                    'category'  : category,
                    'brand'     : brand,
                    'price'     : price,
                    'max_price' : max_price,
                    'sort_by'   : sort_by,
                    'barter'    : barter
                },
                null,
                filter_link
            );


            $.ajax({
                url:   '/ajax/get_offers',
                data: {
                    'type'      : type,
                    'category'  : category,
                    'brand'     : brand,
                    'price'     : price,
                    'max_price' : max_price,
                    'sort_by'   : sort_by,
                    'barter'    : barter
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){

                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);

                    $('.ajax__offers_container').html('');
                    $('.ajax__offers_modal_container').html('');
                    $('#ajax__last_loaded_ads').val(0);
                },
                success: function(data){

                    if (data) {

                        if( $('.ajax__offers_container').hasClass('info--all-offers-loaded') ){
                            $('.ajax__offers_container').removeClass('info--all-offers-loaded');
                        }

                        template            = $('#guest__mustache__ads_loop').html(),
                        template_modal      = $('#guest__mustache__ads_loop_modal').html(),
                        output              = Mustache.render(template, data),
                        output_modal        = Mustache.render(template_modal, data);

                        $('.ajax__offers_container').append(output);
                        $('.ajax__offers_modal_container').append(output_modal);

                        data.forEach(function(item, i, data) {
                            $('#ajax__last_loaded_ads').val(item.id);
                        });

                        reinitializeMasonry();

                    } else {
                        if( $('.ajax__offers_container').hasClass('info--all-offers-loaded') ){
                            $('.ajax__offers_container').removeClass('info--all-offers-loaded');
                        }
                        $('.ajax__offers_container').html('<div class="my-partners__last is-no-select">Не найдено объявлений по заданным Вами параметрам</div>');
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut('slow');
                    $('.preloader').delay(350).fadeOut('slow');
                }
            });

        });
    });

    $(window).scroll(function () {

        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

        if (scrollBottom == 0) {
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
                            var template        = $('#guest__mustache__ads_loop').html(),
                                template_modal  = $('#guest__mustache__ads_loop_modal').html();

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

