<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.01.17
 * Time: 19:40
 */
?>


<script>


    function letter_counter_100 ( textarea_object ) {

        var box     = textarea_object.val(),
            count   = 100 - box.length;

        if(box.length <= 100)
        {
            textarea_object.next('.textarea-count-label').html(count);
        }
        return false;
    }

    function letter_counter_400 ( textarea_object ) {
        var box     = textarea_object.val(),
            count   = 400 - box.length;

        if(box.length <= 400)
        {
            textarea_object.next('.textarea-count-label').html(count);
        }
        return false;
    }


    function uploadImg_offers(event) {
        event.preventDefault();
        $("#fileElem_offers").removeClass("active");
        $("#filelist_offers").removeClass("active");
        $(event.target).closest("form").find("#fileElem_offers").addClass("active");
        $(event.target).closest("form").find("#filelist_offers").addClass("active");
        $(event.target).closest("form").find("#fileElem_offers").click();
        return false;
    }

    function handleFiles_offers(files) {
        var list = $("#filelist_offers.active");
        if (!files) {
            alert('Здесь ie9');
        } else {
            for (var i = 0, f; f = files[i]; i++) {
                var reader              = new FileReader(),
                    original_file_name  = files[i].name;
                reader.onload = (function (f) {
                    return function (e) {
                        var li = $("<li></li>");
                        $(list).prepend(li);
                        $(li).append("<img src='" + e.target.result + "'/>");
                        $(li).append("<a href='#' class='remove' data-image-original-name='" + original_file_name + "'></a>");
                        var images_count = $('ul#filelist_offers li').size();
                        $('.js-attachment-count-list > span').text( images_count );
                        if(images_count > 4 ) {
                            $('.js-attachment-count-list').css({'display': 'block'})
                        }
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    }

    $("body").on("click", "#filelist_offers li", function(event){
        $(this).toggleClass('active');
    });

    $(document).ready(function () {


        $(".limit-100").keyup(function(){
            letter_counter_100( $('#advpost__ta-title') );
        });
        $(".limit-400").keyup(function(){
            letter_counter_400( $('#advpost__ta-posttext') );
        });


        $('input[name="price"]').mask('9?99999999', {"placeholder": ""});
        $('input[name="max_price"]').mask('9?99999999', {"placeholder": ""});


        $('input[name="filter__price"]').mask('9?99999999', {"placeholder": ""});
        $('input[name="filter__max_price"]').mask('9?99999999', {"placeholder": ""});

        $( "#filelist_offers" ).sortable({
            helper: 'clone',
            appendTo: '.filelist__clone'
        });


        $("#filelist_offers").sortable({
            helper      : 'clone',
            appendTo    : '.filelist__clone_offers'
        });

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
                $('input[name="price"]').val( '' );
                $('input[name="max_price"]').val( '' );

                $(".range-block").hide();
                $(".show-range").closest(".advpost__new-input").show();

                $('#input__barter').attr( 'checked', false ).change();
                $('#advpost__ta-posttext').val( '' );

                $('#add-advpost').find('.modal__title').text('Новое объявление');
                $('#add-advpost').find('.add-equipment__submit').val('Опубликовать');
            }

        });

        $('input, select').focus( function () {
            if( $(this).hasClass('input__wrong_data') ) {
                $(this).removeClass('input__wrong_data');
            }
        });

        $('.ajax__offer_add').click( function ( event ) {
            event.preventDefault();

            var action          = $('#ajax-input-action').val(),
                offer_id        = $('#ajax-input-edit_id').val(),
                author_id       = $('#ajax-input-author_id').val(),
                type            = $('input[name="type"]:checked').val(),
                category        = $('select[name="category"]').val(),
                brand           = $('select[name="brand"]').val(),
                title           = $('textarea[name="title"]').val(),
                keywords        = $('textarea[name="keywords"]').val(),
                content         = $('textarea[name="content"]').val(),
                price           = $('input[name="price"]').val(),
                max_price       = $('input[name="max_price"]').val(),
                barter          = false,
                images          = [],
                existing_images = [];

            if ( $('input[name="barter"]').is(':checked') ) {
                barter      = 1;
            }

            $( "#filelist_offers > li" ).each(function( index ) {
                if ( !$(this).hasClass('js__existing_image') )
                    images.push( $(this).find('img').attr('src') );
            });


            <?php   /*    Проверяем на заполненность    */      ;?>

            if( category == 'none' || brand == 'none' || title.length == 0 ) {

                if( category == 'none' )
                    $('select[name="category"]').addClass('input__wrong_data');

                if( brand == 'none' )
                    $('select[name="brand"]').addClass('input__wrong_data');

                if( title.length == 0  )
                    $('textarea[name="title"]').addClass('input__wrong_data');

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
                            'barter'    : barter
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

                                if( !result.is_first_offer )
                                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                        .attr('data-notifyText',  'Ваше объявление успешно добавлено!')
                                        .click();

                                reinitializeMasonry();
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
                            'barter'            : barter
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
                                var data            = result,
                                    template        = $('#mustache__ads_loop_full_width').html(),
                                    modal_template  = $('#mustache__ads_loop_modal').html(),
                                    output          = Mustache.render(template, data),
                                    modal_output    = Mustache.render(modal_template, data);

                                $(".item-offer-"+data.id).replaceWith( output );
                                $("#adv-post"+data.id).replaceWith( modal_output );

                                $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                    .attr('data-notifyText',  'Ваше объявление успешно изменено!')
                                    .click();

                                reinitializeMasonry();
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

        $("body").on("click", '.ajax__edit_offer', function () {
            var id  = $(this).attr('data-offer-id');
            $.fancybox.close();

            $.ajax({
                url:   '/ajax/get_offer_item',
                data: {
                    'id' : id,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);
                },
                success: function(result){

                    var data  = result;

                    $('.input__wrong_data').removeClass('input__wrong_data');

                    $('#filelist_offers').html('');

                    $('#ajax-input-action').val('edit');
                    $('#ajax-input-edit_id').val(id);

                    if(data.type == 'sell')
                        $('input[value=sell]').attr('checked', 'checked');
                    else if(data.type == 'buy')
                        $('input[value=buy]').attr('checked', 'checked');
                    else if(data.type == 'service')
                        $('input[value=service]').attr('checked', 'checked');

                    if(data.barter)
                        $('input[name=barter]').attr('checked', 'checked');
                    else
                        $('input[name=barter]').attr('checked', false);

                    $('select[name=category]').removeClass('is-placeholder').val( data.category ).change();
                    $('select[name=brand]').removeClass('is-placeholder').val( data.brand ).change();

                    $('textarea[name=title]').val(data.title);
                    $('textarea[name=keywords]').val(data.keywords);
                    $('input[name=price]').val(data.price);


                    if ( data.max_price != ""){
                        $(".show-range").closest(".advpost__new-input").hide();
                        $(".range-block").css("display", "inline-block");

                        $('input[name=max_price]').val(data.max_price);

                    }
                    else {
                        $(".range-block").hide();
                        $(".show-range").closest(".advpost__new-input").show();

                        $('input[name=max_price]').val( "" );

                    }

                    if(data.content)
                        $('textarea[name=content]').val(data.content);
                    else
                        $('textarea[name=content]').val('');

                    $.each( data.images, function( key, value ) {
                        $('#filelist_offers').append('<li class="js__existing_image"><img src="/uploads/offers/'+id+'/small_'+value+'" data-original-src="'+value+'"><a href="#" class="remove js-remove_existing_image" data-image-original-name="images.jpeg"></a></li>');
                    });

                    $('#add-advpost').find('.modal__title').text('Изменить объявление');
                    $('#add-advpost').find('.ajax__offer_add').val('Сохранить');

                },
                complete: function( result ){
                    $('.preloader__img').fadeOut('slow');
                    $('.preloader').delay(350).fadeOut('slow');

                    $.fancybox.open({
                        src         : '#add-advpost',
                        closeBtn    : false,
                    });

                }
            });



        });

        $("body").on("click", '.ajax__remove_offer', function () {
            var id  = $(this).attr('data-offer-id');
            $.post('/ajax/remove_offer',
                { 'id': id },
                function(result) {
                    if (result) {
                        $.fancybox.close();
                        $('.item-offer-'+id+ '> .after_removing_background').show();
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Ваше объявление успешно удалено!')
                            .click();
                    } else {

                    }
                });
        });

        $('body').on( 'click' , '.ajax__undo_remove_offer', function() {

            var id = $(this).attr('data-offer-id');

            $.post('/ajax/undo_remove_offer',
                {
                    'action'    : 'undo_remove_item',
                    'id'        : id,
                },
                function(result) {
                    if (result) {
                        $('.item-offer-'+id+ '> .after_removing_background').hide();
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно отменено')
                            .attr('data-notifyText',  'Выбранное вами объявление успешно восстановлено!')
                            .click();
                    }
                });
        });

        $("body").on("click", ".ajax__pinned_offer", function () {
            var link_object     = $(this),
                offer_id        = $(this).attr('data-id'),
                is_pinned       = $(this).attr('data-pinned');

            $.post('/ajax/pin_offer',
                {
                    'id'        : offer_id,
                    'is_pinned' : is_pinned
                },
                function(result) {
                    if (result) {
                        var data  = $.parseJSON(result);
                        if( data.is_pinned == true )
                        {
                            link_object.attr('data-pinned', 'true');

                            $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                .attr('data-notifyText',  'Ваше объявление успешно закреплено!')
                                .click();
                        }
                        else
                        {
                            link_object.attr('data-pinned', 'false');
                            $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                .attr('data-notifyText',  'Ваше объявление успешно откреплено!')
                                .click();
                        }
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Внимание, произошла ошибка!')
                            .click();
                    }
                });
        });

    });
</script>
