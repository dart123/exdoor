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
    //
    // Для мобильной версии

    //


    $('body').on("click", ".ajax__filter_offers__submit", function() {

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

                    var template            = $('#mustache__ads_loop').html(),
                        output              = Mustache.render(template, data);

                    $('.ajax__offers_container').append(output);

                    data.forEach(function(item, i, data) {
                        $('#ajax__last_loaded_ads').val(item.id);
                    });

                    if( data.length <= 9 ) {
                        $('.ajax__offers_container').addClass('info--all-offers-loaded');
                    }


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

                $.fancybox.close();
            }
        });

    });





    $('body').on("click", ".ajax__filter_offers__submit-categories", function() {

        filter_link = '';
        type        = $('input[name="filter__type"]').val();
        category    = [];

        filter_link += '?filter=true';
        filter_link += '&type='+type;

        $('input[name="filter_light_category[]"]:checked').each(function() {
            filter_link += '&cat[]='+$(this).val();
            category.push($(this).val());
        });

        history.pushState(
            {
                'id'        : 'filter_action',
                'type'      : type,
                'category'  : category
            },
            null,
            filter_link
        );


        $.ajax({
            url:   '/ajax/get_offers',
            data: {
                'type'      : type,
                'category'  : category
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

                    var template            = $('#mustache__ads_loop').html(),
                        output              = Mustache.render(template, data);

                    $('.ajax__offers_container').append(output);

                    data.forEach(function(item, i, data) {
                        $('#ajax__last_loaded_ads').val(item.id);
                    });

                    if( data.length <= 9 ) {
                        $('.ajax__offers_container').addClass('info--all-offers-loaded');
                    }

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

                $.fancybox.close();
            }
        });

    });
</script>
