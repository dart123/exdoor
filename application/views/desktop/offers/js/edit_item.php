<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:22
 */

?>

<script>
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
                    $('input[value=sell]').prop('checked', true);
                else if(data.type == 'buy')
                    $('input[value=buy]').prop('checked', true);
                else if(data.type == 'service')
                    $('input[value=service]').prop('checked', true);

                if(data.barter) {
                    $('input[name=barter]').prop('checked', true);
                    $('.js__barter_avalible').show();
                    $('textarea[name=barter_text]').val(data.barter_text);
                }
                else {
                    $('input[name=barter]').prop('checked', false);
                    $('.js__barter_avalible').fadeOut();
                    $('textarea[name=barter_text]').val('');
                }


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
</script>
