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
        $.fancybox.close();
        $('#js__filter_input_trigger').trigger('change');
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
