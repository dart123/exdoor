<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 17:43
 */
?>
<script>

    /* Эффект выбора техники в модальном окне */
    $(".new-msg__modal .js__equipment__modal-filter").click(function () {
        $(this).toggleClass('req-active');
        //$(this).parent().find('.req-choose__btn').removeClass('is-hidden');
    });

    $('.js__request_filter__add_equipment').click( function () {

        $(".js__equipment__modal-filter").each( function () {

            var eq_id   = $(this).data("equipment-id");

            if( $(this).hasClass("req-active") ){
                $(".js__requests__filter__equipment_list[data-equipment-id="+ eq_id +"]").removeClass("slide-hidden");
            }
            else {
                $(".js__requests__filter__equipment_list[data-equipment-id="+ eq_id +"]").addClass("slide-hidden");
            }

        });



        $.fancybox.close();

        $.fancybox.open({
            'href'      : '#sorting-requests',
            'closeBtn'  : false
        });

    });


    /* Страница Заявки - Удаление выбранного сотрудника или типа техники из фильтра сайдбара */
    $('.advpost__tech-choosen > a').click(function(event) {
        event.preventDefault();
        //$(this).parent().slideUp(200).addClass('is-hidden').;

        var equipment_id    = $(this).parent().data('equipment-id');

        $('.requests-info__block[data-equipment-id='+ equipment_id +']').removeClass('req-active');
        $(this).parent().addClass('slide-hidden');

        $('#js__filter_input_trigger').trigger('change');
    });

</script>
