<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:22
 *
 *      Получаем объявление для редактирования
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
            success: function(data){

                console.log( data );
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
                    $('input[name=offers__barter]').prop('checked', true);
                    $('.js__barter_avalible').show();
                    $('textarea[name=offers__barter_text]').val(data.barter_text);
                }
                else {
                    $('input[name=offers__barter]').prop('checked', false);
                    $('.js__barter_avalible').fadeOut();
                    $('textarea[name=offers__barter_text]').val('');
                }


                $('select[name=offers__category]').removeClass('is-placeholder').val( data.category ).change();
                $('select[name=offers__brand]').removeClass('is-placeholder').val( data.brand ).change();

                $('textarea[name=offers__title]').val(data.title);
                $('textarea[name=offers__keywords]').val(data.keywords);
                $('input[name=offers__price]').val(data.price);


                if ( data.max_price != ""){
                    $(".show-range").closest(".advpost__new-input").hide();
                    $(".range-block").css("display", "inline-block");

                    $('input[name=offers__max_price]').val(data.max_price);

                }
                else {
                    $(".range-block").hide();
                    $(".show-range").closest(".advpost__new-input").show();

                    $('input[name=offers__max_price]').val( "" );

                }

                if(data.content)
                    $('textarea[name=offers__content]').val(data.content);
                else
                    $('textarea[name=offers__content]').val('');

                $.each( data.images, function( key, value ) {
                    $('#filelist_offers').append('<li class="js__existing_image"><img src="/uploads/offers/'+id+'/small_'+value+'" data-original-src="'+value+'"><a href="#" class="remove js-remove_existing_image" data-image-original-name="images.jpeg"></a></li>');
                });

                $('#add-advpost').find('.modal__title').text('Изменить объявление');
                $('#add-advpost').find('.ajax__offer_add').val('Сохранить');

                letter_counter_100( $('#advpost__ta-title') );
                letter_counter_100( $('#advpost__ta-bartertext') );
                letter_counter_400( $('#advpost__ta-posttext') );

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

