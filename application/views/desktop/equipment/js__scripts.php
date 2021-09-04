<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.01.17
 * Time: 22:27
 */
?>

<!--
<script data-path="<?= $this->config->item('base_url');?>/assets/js/pixie" src="/assets/js/pixie/pixie-integrate.js?v2"></script>
-->

<script>

    function uploadImg_equipment(event) {
        event.preventDefault();
        $("#fileElem_equipment").removeClass("active");
        $("#filelist_equipment").removeClass("active");
        $(event.target).closest("form").find("#fileElem_equipment").addClass("active");
        $(event.target).closest("form").find("#filelist_equipment").addClass("active");
        $(event.target).closest("form").find("#fileElem_equipment").click();
        return false;
    }

    function handleFiles_equipment(files) {

        var list        = $("#filelist_equipment.active");
        var fileTypes   = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

        if (!files) {
            alert('Здесь ie9');
        } else {
            for (var i = 0, f; f = files[i]; i++) {

                if( f.size > 7900000) {

                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                        .click();
                    return;

                }

                var reader              = new FileReader(),
                    original_file_name  = files[i].name,
                    extension           = files[i].name.split('.').pop().toLowerCase(),  //file extension from input file
                    isSuccess           = fileTypes.indexOf(extension) > -1;

                if(!isSuccess) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Указаные вами файлы имеют недопустимый формат!')
                        .click();
                    return;
                }

                reader.onload = (function (f) {

                    return function (e) {

                        var image = new Image();
                        image.src = e.target.result;

                        image.onload = function() {

                            if( this.width > 5000 || this.height > 5000) {

                                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                    .attr('data-notifyText',  'Разрешение загружаемого изображения превышает 5000х5000 пикселей.')
                                    .click();
                                return false;

                            } else {

                                var li = $("<li></li>");
                                $(list).prepend(li);
                                $(li).append("<img src='" + e.target.result + "'/>");
                                $(li).append("<a href='#' class='remove' data-image-original-name='" + original_file_name + "'></a>");
                                //$(li).append("<a href='#' class='edit'></a>");

                                var images_count = $('ul#filelist__equipment li').size();
                                $('.js-attachment-count-list > span').text( images_count );
                                if(images_count > 4 ) {
                                    $('.js-attachment-count-list').css({'display': 'block'})
                                }

                                $('.eq__val').trigger('change');

                            }

                        };


                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    }
    /* Добавление рамки на фотографии в окне с дозагрузкой фото */
    $("body").on("click", "#filelist_equipment li", function(event){
        $(this).toggleClass('active');
    });


    /* Удаление фотографии в функционале прикрепления фото */
    $("body").on("click", "a.remove", function (del) {
        del.preventDefault();
        $(this).parent('li').remove();

        if( $('#filelist_equipment > li').length == 0 ){
            $('#fileElem_equipment').val('');
            $('.eq__val').trigger('change');
        }

    });

/*

    var myPixie = Pixie.setOptions({
        replaceOriginal: true,
        onSave: function(data, img) {

            var original_name   = $('.js__image_in_editing').attr('data-image-original-name'),
                equipment_id    = $('#eq__id').val();

            $.ajax({
                url:   '/ajax/save_edit_image',
                data: {
                    'image'         : data,
                    'name'          : original_name,
                    'equipment_id'  : equipment_id
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function(result){
                    if (result) {

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Изображение отредактровано')
                            .attr('data-notifyText',  'Миниатюры обновятся при перезагрузке страницы!')
                            .click();

                        var old_img         = $('.js__image_in_editing').closest('li').find('img'),
                            old_edit        = $('.js__image_in_editing').closest('li').find('.edit'),
                            old_src_orig    = old_edit.attr('data-image-original-url'),
                            old_img_name    = old_edit.attr('data-image-original-name'),
                            thumbnail       = $('img[data-thumbnail="'+old_img_name+'"]'),
                            old_src_small   = old_img.attr('src'),
                            new_src_small   = old_src_small + '?v=' + Math.floor(Date.now() / 1000),
                            new_src_orig    = old_src_orig + '?v=' + Math.floor(Date.now() / 1000);
                        // обновляем get у обложки, если есть конечно
                        if( thumbnail.length ) {
                            thumbnail.attr( 'src' , thumbnail.attr('data-thumbnail-url') + '?v=' + Math.floor(Date.now() / 1000) )
                        };


                        old_img.attr('src', new_src_small );
                        old_edit.attr('data-image-original-url', new_src_orig);

                        $('.js__image_in_editing').removeClass('js__image_in_editing');

                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                }
            });





        },
        onClose: function () {

        }
    });

    myPixie.enableInteractiveMode({
        selector: '.edit_with__pixie-editor'
    });

    $('body').on('click', '.js__image_edit__open_editor', function(e) {
        $(this).addClass('js__image_in_editing');

        myPixie.open({
            url: $(this).attr('data-image-original-url')
        });
    });
    */


    $(document).ready( function () {



        $('#eq__year').mask('9999', {"placeholder": ""});

        $( "#filelist_equipment" ).sortable({
            helper: 'clone',
            appendTo: '.filelist__clone'
        });

        $('.eq__add-btn').fancybox({
            'helpers' : {
                overlay : {
                    //locked: true
                }
            },
            'closeBtn' : false,
            'beforeShow' : function () {
                $('#filelist_equipment').html('');
                $('#add-equipment').find('input[name=action]').val('add_new_item');
                $('#eq__id').val( '' );
                $('#eq__type').val( '' ).change().addClass('is-placeholder');
                $('#eq__brand').val( '' ).change().addClass('is-placeholder');
                $('#eq__motor').val( '' );
                $('#eq__model').val( '' );
                $('#eq__unit').val( '' );
                $('#eq__sn').val( '' );
                $('#eq__year').val( '' );
                $('#add-equipment').find('.modal__title').text('Новая техника');
                $('#add-equipment').find('.add-equipment__submit').val('Добавить в парк');

                $('.eq__val').trigger('change');
            },
            'afterClose' : function() {

            }
        });

        $('input, select').focus( function () {
            if( $(this).hasClass('input__wrong_data') ) {
                $(this).removeClass('input__wrong_data');
            }
        });

        $('.ajax__equipment_add').click( function ( event ) {

            event.preventDefault();
            var id              = $('#eq__id').val(),
                action          = $('input[name="action"]').val(),
                owner           = $('input[name="owner"]').val(),
                appointment     = $('select[name="appointment"]').val(),
                brand           = $('select[name="brand"]').val(),
                model           = $('input[name="model"]').val(),
                serial_number   = $('input[name="serial_number"]').val(),
                engine          = $('input[name="engine"]').val(),
                year            = $('input[name="year"]').val(),
                section         = $('input[name="section"]').val(),
                images          = [],
                existing_images = [],
                filter_brands   = [];

            // Для обноалвения фильтра берем данные
            $('input[name="filter__brand[]"]:checked').each(function() {
                filter_brands.push($(this).val());
            });


            $( "#filelist_equipment > li" ).each(function( index ) {
                if ( !$(this).hasClass('js__existing_image') )
                    images.push( $(this).find('img').attr('src') );
            });




            if( brand == 'none' || appointment == 'none' ) {

                if( brand == 'none' )
                    $('select[name="brand"]').addClass('input__wrong_data');

                if( appointment == 'none' )
                    $('select[name="appointment"]').addClass('input__wrong_data');


                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Заполните пожалуйста обязательные поля!')
                    .click();

            } else {


                if( action == 'add_new_item' )
                {
                    $.ajax({
                        url:   '/ajax/add_equipment',
                        data: {
                            'owner'         : owner,
                            'appointment'   : appointment,
                            'brand'         : brand,
                            'model'         : model,
                            'serial_number' : serial_number,
                            'engine'        : engine,
                            'year'          : year,
                            'section'       : section,
                            'images'        : images,
                            'filter_brands' : filter_brands,
                        },
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function(xhr){
                            $('.preloader').fadeIn();
                            $('.preloader__img').fadeIn();
                        },
                        success: function(result){
                            if (result) {

                                var template            = $('#mustache__equipment_loop').html(),
                                    output              = Mustache.render(template, result.item);

                                $('.ajax__equipment_container').prepend(output);

                                $('.ajax__filter_brands').html( result.filter );
                            }
                        },
                        complete: function( result ){
                            $('.preloader__img').fadeOut();
                            $('.preloader').delay(350).fadeOut('slow');

                            $( "#filelist_equipment" ).html('');
                            $( '#fileElem_equipment' ).val('');

                            reinitializeMasonry();
                            $.fancybox.close();
                        }
                    });

                }
                else if ( action == 'update_item' )
                {
                    $( "#filelist_equipment > li" ).each(function( index ) {
                        if ( $(this).hasClass('js__existing_image') )
                            existing_images.push( $(this).find('img').attr('data-original-src') );
                    });

                    $.ajax({
                        url:   '/ajax/update_equipment',
                        data: {
                            'id'                : id,
                            'owner'             : owner,
                            'appointment'       : appointment,
                            'brand'             : brand,
                            'model'             : model,
                            'serial_number'     : serial_number,
                            'engine'            : engine,
                            'year'              : year,
                            'section'           : section,
                            'images'            : images,
                            'existing_images'   : existing_images,
                            'filter_brands'     : filter_brands,
                        },
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function(xhr){
                            $('.preloader').fadeIn();
                            $('.preloader__img').fadeIn();
                        },
                        success: function(result){
                            if (result) {
                                var template            = $('#mustache__equipment_loop').html(),
                                    output              = Mustache.render(template, result.item);

                                $(".item-equipment-"+id).replaceWith( output );

                                $('.ajax__filter_brands').html( result.filter );
                            }
                        },
                        complete: function( result ){
                            $('.preloader__img').fadeOut();
                            $('.preloader').delay(350).fadeOut('slow');

                            $( "#filelist_equipment" ).html('');
                            $( '#fileElem_equipment' ).val('');
                            reinitializeMasonry();
                            $.fancybox.close();

                            $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                .attr('data-notifyText',  'Единица парка успешно обновлена!')
                                .click();
                        }
                    });

                }







            }






        });






















        $('body').on('click', ".eq__check-none",  function() {
            $(this).addClass('slide-hidden');
            $(this).prev('.eq__check-all').removeClass('slide-hidden');

            $(".ajax__equipment_filter_input").prop('checked', false);

            $('.ajax__filter_hidden_field_trigger').change();
            return false;
        })

        $('body').on('change', '.ajax__equipment_filter_input', function() {
            $('.ajax__equipment_container').html('');
            var filter_link = '',
                brand       = [];

            filter_link += '?filter=true';

            $('input[name="filter__brand[]"]:checked').each(function() {
                filter_link += '&brand[]='+$(this).val();
                brand.push($(this).val());
            });

            history.pushState({
                    'id'        : 'filter_action',
                    'brand'     : brand,
                },
                null,
                filter_link
            );


            $.ajax({
                url:   '/ajax/get_equipment',
                data: {
                    'brand'     : brand,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);
                },
                success: function(result){
                    if (result) {

                        if( $('.ajax__equipment_container').hasClass('info--all-offers-loaded') ){
                            $('.ajax__equipment_container').removeClass('info--all-offers-loaded');
                        }
                        var data                = result,
                            template            = $('#mustache__equipment_loop').html(),
                            output              = Mustache.render(template, data);

                        $('.load-more').hide();
                        $('.ajax__equipment_container').append(output);
                    }
                },
                complete: function( result ){
                    reinitializeMasonry();
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                    $(".eq__val").trigger('change');
                }
            });

        });

        $('body').on( 'click' , '.ajax__edit_equipment', function() {

            var id = $(this).attr('data-equipment-id');

            $.ajax({
                url:   '/ajax/get_equipment_item',
                data: {
                    'id' : id,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){

                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);

                    $('#filelist_equipment').html('');
                    $('#fileElem_equipment').val('');
                },
                success: function(result){
                    if (result) {
                        var data  = result;

                        $('#add-equipment').find('input[name=action]').val('update_item');

                        $('#eq__id').val( data.id );


                        if( data.appointment != '0' )
                            $('#eq__type').val( data.appointment ).change().removeClass('is-placeholder');
                        else
                            $('#eq__type').val( 'none' ).change().addClass('is-placeholder');

                        if( data.brand != '0' )
                            $('#eq__brand').val( data.brand ).change().removeClass('is-placeholder');
                        else
                            $('#eq__brand').val( 'none' ).change().addClass('is-placeholder');

                        $('#eq__motor').val( data.engine );
                        $('#eq__model').val( data.model );

                        $('#eq__unit').val( data.section );
                        $('#eq__sn').val( data.serial_number );
                        $('#eq__year').val( data.year );

                        $('#filelist_equipment').addClass("has-edit");
                        $.each( data.images, function( key, value ) {
                            $('#filelist_equipment').append('<li class="js__existing_image"><img src="/uploads/equipment/'+id+'/small_'+value+'?v=' + Math.floor(Date.now() / 1000) + '" data-original-src="'+value+'"><a href="#" class="remove js-remove_existing_image" data-image-original-name="'+value+'"></a><a class="edit js__image_edit__open_editor" data-image-original-url="/uploads/equipment/'+id+'/lg1000_'+value+'?v=' + Math.floor(Date.now() / 1000) + '" data-image-original-name="'+value+'"></a></li>');
                        });

                    }
                },
                complete: function( result ){
                    $('#add-equipment').find('.modal__title').text('Изменить данные');
                    $('#add-equipment').find('.add-equipment__submit').val('Сохранить');

                    $.fancybox.open({
                        src         : '#add-equipment',
                        closeBtn    : false
                    });

                    $('#add-equipment').imagesLoaded(function(){
                        $('.eq__val').trigger('change');
                    });

                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                }
            });




        });

        $('body').on( 'click' , '.ajax__remove_equipment', function() {

            var id = $(this).attr('data-equipment-id');

            $.post('/ajax/remove_equipment',
                {
                    'action'    : 'remove_item',
                    'id'        : id,
                },
                function(result) {
                    if (result) {
                        $('.item-equipment-'+id+ '> .after_removing_background').show();
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Техника удалена')
                            .attr('data-notifyText',  'Выбранная вами единица парка техники успешно удалена!')
                            .click();
                    }
                });
        });

        $('body').on( 'click' , '.ajax__undo_remove_equipment', function() {

            var id = $(this).attr('data-equipment-id');

            $.post('/ajax/undo_remove_equipment',
                {
                    'action'    : 'undo_remove_item',
                    'id'        : id,
                },
                function(result) {
                    if (result) {
                        $('.item-equipment-'+id+ '> .after_removing_background').hide();
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно отменено')
                            .attr('data-notifyText',  'Выбранная вами единица парка техники успешно восстановлена!')
                            .click();
                    }
                });
        });
    });
</script>
