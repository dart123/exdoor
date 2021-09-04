<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:22
 */

$template_modal = 'mustache__ads_loop_modal';

if( isset($page) )
    switch ($page) {
        case 'offers':
            $template       = 'mustache__ads_loop';
            break;
        case 'main':
            $template       = 'mustache__ads_loop_full_width';
            break;
    }
?>



<script>


    $('.advpost__add-btn').fancybox({
        'helpers' : {
            overlay : {
                locked: true
            }
        },
        'closeBtn' : false,
        'beforeShow' : function () {

            $('.input__wrong_data').removeClass('input__wrong_data');

            $('#filelist_offers').html('');
            $('#ajax-input-action').val('add');

            $('#advpost__theme-name').val( '' ).change().addClass('is-placeholder');
            $('#advpos__brand').val( '' ).change().addClass('is-placeholder');
            $('#advpost__ta-title').val( '' );
            $('#advpost__ta-keywords').val( '' );
            $('input[name="offers__price"]').val( '' );
            $('input[name="offers__max_price"]').val( '' );

            $(".range-block").hide();
            $(".show-range").closest(".advpost__new-input").show();


            $('#input__barter').prop('checked', false).change();
            $('textarea[name=offers__barter_text]').val('');
            $('#advpost__ta-posttext').val( '' );

            letter_counter_100( $('#advpost__ta-title') );
            letter_counter_100( $('#advpost__ta-bartertext') );
            letter_counter_400( $('#advpost__ta-posttext') );


            $('#add-advpost').find('.modal__title').text('Новое объявление');
            $('#add-advpost').find('.add-equipment__submit').val('Опубликовать');
        }

    });


    /*

     Добавление объявления

     */
    $('input, select').focus( function () {
        if( $(this).hasClass('input__wrong_data') ) {
            $(this).removeClass('input__wrong_data');
        }
    });

    $('#input__barter').change( function () {
        if( $(this).prop('checked') == true ) {
            $('.js__barter_avalible').show();
            $('textarea[name=offers__barter_text]').focus();
        }
        else {
            $('.js__barter_avalible').hide();
        }

    });


    $('.ajax__offer_add').click( function ( event ) {
        event.preventDefault();

        var action          = $('#ajax-input-action').val(),
            offer_id        = $('#ajax-input-edit_id').val(),
            author_id       = $('#ajax-input-author_id').val(),
            type            = $('input[name="offers__type"]:checked').val(),
            category        = $('select[name="offers__category"]').val(),
            brand           = $('select[name="offers__brand"]').val(),
            title           = $('textarea[name="offers__title"]').val(),
            keywords        = $('textarea[name="offers__keywords"]').val(),
            content         = $('textarea[name="offers__content"]').val(),
            price           = $('input[name="offers__price"]').val(),
            max_price       = $('input[name="offers__max_price"]').val(),
            barter          = false,
            barter_text     = $('textarea[name="offers__barter_text"]').val(),
            images          = [],
            existing_images = [];

        if ( $('input[name="offers__barter"]').is(':checked') ) {
            barter      = 1;
        }

        $( "#filelist_offers > li" ).each(function( index ) {
            if ( !$(this).hasClass('js__existing_image') )
                images.push( $(this).find('img').attr('src') );
        });

        <?php   /*    Проверяем на заполненность    */      ;?>

        if( category == 'none' || title.length == 0 ) {

            if( category == 'none' )
                $('select[name="offers__category"]').addClass('input__wrong_data');


            if( brand == 'none' )
                $('select[name="offers__brand"]').addClass('input__wrong_data');


            if( title.length == 0  )
                $('textarea[name="offers__title"]').addClass('input__wrong_data');

            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                .attr('data-notifyText',  'Заполните пожалуйста обязательные поля!')
                .click();

        } else {


            if( action == 'add' )
            {

                $.ajax({
                    url:   '/ajax/add_offer',
                    data: {
                        'author_id' : author_id,
                        'type'      : type,
                        'category'  : category,
                        'brand'     : brand,
                        'title'     : title,
                        'keywords'  : keywords,
                        'content'   : content,
                        'price'     : price,
                        'max_price' : max_price,
                        'images'    : images,
                        'barter'    : barter,
                        'barter_text': barter_text
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function(xhr){
                        $('.preloader').fadeIn(0);
                        $('.preloader__img').fadeIn(0);
                    },
                    success: function(result){
                        if (result) {
                            $.fancybox.close();
                            <?php if( $page == 'offers' ):?>
                                <?php /*
                                if( result.type != "<?php echo $offers_type;?>" || result.is_first_offer){
                                    switch (result.type){
                                        case "buy":
                                            window.location.href = "<?=$this->config->item('base_url');?>/offers/buy?add=success";
                                            break;
                                        case "service":
                                            window.location.href = "<?=$this->config->item('base_url');?>/offers/service?add=success";
                                            break;
                                        case "sell":
                                            window.location.href = "<?=$this->config->item('base_url');?>/offers?add=success";
                                            break;
                                    }
                                } else
                                {
                                */ ?>
                                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                        .attr('data-notifyText',  'Ваше объявление успешно добавлено!')
                                        .click();
                                <?php
                                //};
                                ?>

                            <?php elseif( $page == 'main' ):?>

                                if( !result.is_first_offer ) {
                                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                        .attr('data-notifyText',  'Ваше объявление успешно добавлено!')
                                        .click();

                                    reinitializeMasonry();
                                }
                                 else {

                                }

                            <?php endif;?>

                        } else {
                            alert('error');
                        }
                    },
                    complete: function( result ){
                        $('.preloader__img').fadeOut('slow');
                        $('.preloader').delay(350).fadeOut('slow');

                    }
                });


            }
            else if( action == 'edit' )
            {
                $( "#filelist_offers > li" ).each(function( index ) {
                    if ( $(this).hasClass('js__existing_image') )
                        existing_images.push( $(this).find('img').attr('data-original-src') );
                });




                $.ajax({
                    url:   '/ajax/edit_offer',
                    data: {
                        'offer_id'          : offer_id,
                        'author_id'         : author_id,
                        'type'              : type,
                        'category'          : category,
                        'brand'             : brand,
                        'title'             : title,
                        'keywords'          : keywords,
                        'content'           : content,
                        'price'             : price,
                        'max_price'         : max_price,
                        'post_images'       : images,
                        'existing_images'   : existing_images,
                        'barter'            : barter,
                        'barter_text'       : barter_text
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function(xhr){
                        $('.preloader').fadeIn(0);
                        $('.preloader__img').fadeIn(0);
                    },
                    success: function(data){
                        if (data) {
                            $.fancybox.close();
                            template            = $('#<?php echo $template;?>').html();
                            template_modal      = $('#<?php echo $template_modal;?>').html();
                            output              = Mustache.render(template, data);
                            output_modal        = Mustache.render(template_modal, data);

                            $(".item-offer-"+data.id).replaceWith( output );
                            $("#adv-post"+data.id).replaceWith( output_modal );

                            <?php if( $page == 'offers' ):?>

                            if( data.type != "<?php echo $offers_type;?>"){
                                switch (data.type){
                                    case "buy":
                                        window.location.href = "<?=$this->config->item('base_url');?>/offers/buy?edit=success";
                                        break;
                                    case "service":
                                        window.location.href = "<?=$this->config->item('base_url');?>/offers/service?edit=success";
                                        break;
                                    case "sell":
                                        window.location.href = "<?=$this->config->item('base_url');?>/offers?edit=success";
                                        break;
                                }
                            } else {
                                $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                    .attr('data-notifyText',  'Ваше объявление успешно изменено!')
                                    .click();
                            }

                            <?php elseif( $page == 'main' ):?>
                                $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                    .attr('data-notifyText',  'Ваше объявление успешно изменено!')
                                    .click();
                            <?php endif;?>

                            reinitializeMasonry();
                        } else {
                            alert('error');
                        }
                    },
                    complete: function( result ){
                        $('.preloader__img').fadeOut('slow');
                        $('.preloader').delay(350).fadeOut('slow');

                    }
                });

            }

        }
    });
</script>
