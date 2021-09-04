<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:30
 */
?>

<script data-path="/assets/js/pixie" src="/assets/js/pixie/pixie-integrate.js?v2"></script>
<script>

    var myPixie = Pixie.setOptions({
        replaceOriginal: true,
        onSave: function(data, img) {

            original_name   = $('.js__image_in_editing').attr('data-image-original-name');
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
                            thumbnail.attr( 'src' , thumbnail.attr('data-thumbnail-url') + '?v=' + Math.floor(Date.now() / 1000) );
                        }

                        $('img[data-original-src="'+old_img_name+'"]').attr('src', new_src_small );

                        //


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
            url: $(this).attr('data-image-original-url') + '?v=' + Math.floor(Date.now() / 1000)
        });
    });

</script>
