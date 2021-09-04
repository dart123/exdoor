<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 17:42
 */
?>
<script>

    $(document).ready( function( ) {

        $('.fancybox__rating_modal').fancybox({
            helpers     : {
                overlay : {
                    locked: false
                }
            },
            closeBtn : false,
            afterClose  : function () {
                $('.js__set-partners-rating').removeClass('is-blue-text');
                $('.js-rating').removeClass('fa-star').addClass('fa-star-o');
            }
        });


        $('.js__form__request_status__checkbox').change( function (e) {
            e.preventDefault();
            if( $(this).attr('id') == 'req-status-03' ) {
                $.fancybox.open([ {
                    href : '#req__rating',
                    closeBtn: false
                } ] );
                $(this).prop('checked', false);
            } else {

                $('.preloader').fadeIn(0);
                $('.preloader__img').fadeIn(0);
                $('.ajax__requests_container .request__item').remove();

                $('#js__form__request_status').submit();
            }
        });

        $('.js__req__confirm__request_done').click( function () {
            $('#req-status-03').prop('checked', true);
            $('#js__form__request_status').submit();
        });





        $('.js-rating').hover(
            function() {
                if( !$('.js__set-partners-rating').hasClass('is-blue-text') ) {
                    switch( $( this ).attr('id') ) {
                        case 'icon_rating_05':
                            $('#icon_rating_05').removeClass('fa-star-o').addClass('fa-star');
                        case 'icon_rating_04':
                            $('#icon_rating_04').removeClass('fa-star-o').addClass('fa-star');
                        case 'icon_rating_03':
                            $('#icon_rating_03').removeClass('fa-star-o').addClass('fa-star');
                        case 'icon_rating_02':
                            $('#icon_rating_02').removeClass('fa-star-o').addClass('fa-star');
                        case 'icon_rating_01':
                            $('#icon_rating_01').removeClass('fa-star-o').addClass('fa-star');
                    }
                }

            }, function() {
                if( !$('.js__set-partners-rating').hasClass('is-blue-text') )
                    $('.js-rating').removeClass('fa-star').addClass('fa-star-o');
            }
        );

        $('.js-rating').click( function () {
            $('.js-rating').removeClass('fa-star').addClass('fa-star-o');
            var rating = 0;
            switch( $( this ).attr('id') ) {
                case 'icon_rating_05':
                    $('#icon_rating_05').removeClass('fa-star-o').addClass('fa-star');
                    rating++;
                case 'icon_rating_04':
                    $('#icon_rating_04').removeClass('fa-star-o').addClass('fa-star');
                    rating++;
                case 'icon_rating_03':
                    $('#icon_rating_03').removeClass('fa-star-o').addClass('fa-star');
                    rating++;
                case 'icon_rating_02':
                    $('#icon_rating_02').removeClass('fa-star-o').addClass('fa-star');
                    rating++;
                case 'icon_rating_01':
                    $('#icon_rating_01').removeClass('fa-star-o').addClass('fa-star');
                    rating++;
            }
            $('#js__rating_input').val( rating );

            $('.js__set-partners-rating').addClass('is-blue-text');
            $('.js-rating').addClass('js__rating-done');

        });

        $('.ajax__set-rating').click( function() {

            var rating = parseInt( $('#js__rating_input').val() );

            if( !rating || rating < 0 ) {
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Вы должны оценить работу партнера!')
                    .click();
            } else {

                $.ajax({
                    url:   '/ajax/request__set_rating',
                    data: {
                        'request_id'    : $('#js__request_id').val(),
                        'rating'        : rating,
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function(xhr){

                    },
                    success: function(data){
                        if (data) {
                            document.location.href = 'https://exdor.ru/requests/<?php echo $page_content["request_data"]->id;?>';
                        } else {
                            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                .attr('data-notifyText',  'Возникла ошибка при постановке оценки! Попробуйте позже')
                                .click();
                        }

                    },
                    complete: function( result ){

                    }
                });

            }

        })


    });


</script>
