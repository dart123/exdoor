<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:27
 *
 *      Фильтрация объявлений
 */

?>

<script>

    /*Страница Объявления - клик на тематику в отдельном объявлении автоматически выделяет чекбокс этой темы в фильтре сайдбара */
    $('body').on('click', '.advpost__footer-l a', function() {

        if( !$(this).hasClass('js__real-link') ) {
            event.preventDefault(event);
            catName = $(this).find('span').text();

            $('#adv-group-01 input:checkbox:enabled').prop('checked', false);
            $("label:contains(" + catName + ")").prev().prop('checked', true).change( );
        }

    });



    $('.ajax__adv_filter_input').change( function() {

        filter_link = '';
        type        = $('input[name="filter__type"]').val();
        category    = [];
        brand       = [];
        price       = $('input[name="filter__price"]').val();
        max_price   = $('input[name="filter__max_price"]').val();
        barter      = 'no';

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

                    template            = $('#mustache__ads_loop').html(),
                        template_modal      = $('#mustache__ads_loop_modal').html(),
                        output              = Mustache.render(template, data);
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
</script>
