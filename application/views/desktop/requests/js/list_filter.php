<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 17:41
 */

?>

<script>


    $(document).ready( function () {

        $('input[name="filter__date_from"]').mask('99.99.9999', {"placeholder": ""});
        $('input[name="filter__date_to"]').mask('99.99.9999', {"placeholder": ""});

    });

    // Сбрасываение фильтров для каждого элемента

    $(".request__check-none").click( function() {

        $(this).addClass('slide-hidden');

        if( $(this).hasClass('js__requests__filter__reset_status') ) {
            $(this).prev('.advpost__check-all').removeClass('slide-hidden');
            $("." + $(this).attr('rel') ).prop('checked', false);
        } else if( $(this).hasClass('js__requests__filter__reset_equipment') ) {

            $(".new-msg__modal .requests-info__block").each( function (index) {
                var equipment_id = $(this).data('equipment-id');
                $(this).removeClass('req-active');
            });

        } else if( $(this).hasClass('js__requests__filter__reset_date') ) {

            $('#filter__datepicker__from').val('');
            $('#filter__datepicker__to').val('');

        } else if( $(this).hasClass('js__requests__filter__reset_employers') ) {

            $('.employee__name-choosen').each( function () {
                if( $(this).css('display') != 'none' ) {
                    $(this).css('display', 'none');
                    user_id     = $(this).find('a').data('user');

                    $('.js__requests__modal__employer-' + user_id ).find('.choose-partner').removeClass('is-hidden');
                    $('.js__requests__modal__employer-' + user_id ).find('.choosen-partner').addClass('is-hidden');

                    $('.requests__col__user_' + user_id ).hide();
                }
            });


        }

        $('#js__filter_input_trigger').change();
    });




    $(".request__reset-btn").click(function() {

        $('.request__check-none').addClass('slide-hidden');
        $('.request__check-all').removeClass('slide-hidden');

        $('.request__checkbox').prop('checked', false);

        $('input[name="filter__date_from"]').val('');
        $('input[name="filter__date_to"]').val('');
        // Сбрасываем фильтр по парку техники

        $(".new-msg__modal .requests-info__block").each( function (index) {
            var equipment_id = $(this).data('equipment-id');
            $(this).removeClass('req-active');
        });

        $('#js__filter_input_trigger').change();
    });



    $('.ajax__requests_filter_input').change( function() {

        var status              = [],
            employers           = [],
            equipment           = [],
            employers__to_show  = [],
            date_from           = $('input[name="filter__date_from"]').val(),
            date_to             = $('input[name="filter__date_to"]').val(),
            type                = "<?php if( isset($sub_menu) && array_key_exists('selected', $sub_menu) ) echo $sub_menu['selected'];?>",
            sort                = $('select[name="filter__sort"]').val();


        $('input[name="filter__status[]"]:checked').each(function() {
            status.push($(this).val());
        });

        if( status.length > 0 ){
            $('.js__requests__filter__reset_status').removeClass('slide-hidden');
        } else if( status.length == 0 ) {
            $('.js__requests__filter__reset_status').addClass('slide-hidden');
        }


        $('input[name="filter__employers[]"]').each(function() {
            employers.push($(this).val());
        });


        $('.employee__name-choosen').each( function () {
            if( $(this).css('display') != 'none' ) {
                employers__to_show.push ( $(this).find('a').data('user') );
            }
        });

        if( employers__to_show.length > 0 ) {
            $('.js__requests__filter__reset_employers').removeClass('slide-hidden');
        } else {
            $('.js__requests__filter__reset_employers').addClass('slide-hidden');
        }

        if( !date_from && !date_to ) {
            $('.js__requests__filter__reset_date').addClass('slide-hidden');
        } else {
            $('.js__requests__filter__reset_date').removeClass('slide-hidden');
        }


        $(".new-msg__modal .requests-info__block").each( function (index) {
            equipment_id = $(this).data('equipment-id');

            if( $(this).hasClass('req-active') ) {
                $('.js__requests__filter__equipment_list[data-equipment-id='+equipment_id+']').removeClass('slide-hidden');
                equipment.push( $(this).data('equipment-id') );
            } else {
                $('.js__requests__filter__equipment_list[data-equipment-id='+equipment_id+']').addClass('slide-hidden');
            }
        });

        if( equipment.length > 0 ) {
            $('.js__requests__filter__reset_equipment').removeClass('slide-hidden');
        } else if( equipment.length == 0 ) {
            $('.js__requests__filter__reset_equipment').addClass('slide-hidden');
        }




        $.ajax({
            url:   '/ajax/get_requests',
            data: {
                'type'                  : type,
                'status'                : status,
                'equipment'             : equipment,
                'sort'                  : sort,
                'employers'             : employers,
                'employers__to_show'    : employers__to_show,
                'date_from'             : date_from,
                'date_to'               : date_to
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){

                $('.preloader').fadeIn(0);
                $('.preloader__img').fadeIn(0);
                $('.ajax__requests_container .request__item').remove();

            },
            success: function(data){

                if (data) {

                    var template    = $('#mustache__request_loop__block').html();

                    data.forEach(function(item, i, data) {

                        if( item.requests.length ) {
                            var pre_data    = item.requests.slice(0, 5),
                                post_data   = item.requests.slice(5);

                            $('.ajax__requests_container__user_'+item.user).append( Mustache.render(template, pre_data) );
                            $('.ajax__requests_container__user_'+item.user+'_hidden').append( Mustache.render(template, post_data) );


                            if( post_data.length > 0 ) {
                                $('.js__hide_all_requests_' + item.user ).addClass('slide-hidden');
                                $('.js__show_all_requests_' + item.user ).removeClass('slide-hidden');
                                $('.ajax__requests_container_'+item.user+'_user__show-more').css('display', 'block');

                                $('.new-req-items__' + item.user ).remove();

                                $('.ajax__requests_container__user_'+item.user).append( $('<div class="new-req-items new-req-items__' + item.user +'"></div>') );
                            }

                            else {
                                $('.js__hide_all_requests_' + item.user ).addClass('slide-hidden');
                                $('.js__show_all_requests_' + item.user ).addClass('slide-hidden');
                                $('.ajax__requests_container_'+item.user+'_user__show-more').css('display', 'none');
                            }


                            $('#js__user-'+ item.user +'__requests_found').text( item.requests.length );
                        }




                        else {
                            $('.js__hide_all_requests_' + item.user ).addClass('slide-hidden');
                            $('.js__show_all_requests_' + item.user ).addClass('slide-hidden');

                            $('.ajax__requests_container_'+item.user+'_user__show-more').css('display', 'none');
                            $('#js__user-'+ item.user +'__requests_found').text( 0 );
                        }

                    });

                } else {

                    $('.ajax__requests_container').html('<div class="my-partners__last is-no-select">Не найдено объявлений по заданным Вами параметрам</div>');
                }
            },

            error   : function( ) {
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'В процессе запроса возникла ошибка, попробуйте еще раз!')
                    .click();
            },
            complete: function( result ){
                $('.preloader__img').fadeOut('slow');
                $('.preloader').delay(350).fadeOut('slow');
            }
        });

    });
</script>
