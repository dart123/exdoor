<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 17:43
 */
?>
<script>

    // Фильтр - Корзина в списке сотрудников в сайдбаре
    $('.employee__name-choosen > a').click(function(event) {
        event.preventDefault();

        user_id     = $(this).data('user');

        $(this).parent().slideUp(200, function () {

            $('.js__requests__modal__employer-' + user_id ).find('.choose-partner').removeClass('is-hidden');
            $('.js__requests__modal__employer-' + user_id ).find('.choosen-partner').addClass('is-hidden');

            $('.requests__col__user_' + user_id ).hide();

            $('#js__filter_input_trigger').trigger('change'); // Отпрвляем запрос и сохраняем фильтр
        });
    });

    //  Фильтр - Выбор сотрудников в модальном окне
    $('.employee__name-choosen__modal > a').click(function(event) {
        event.preventDefault();

        //$('.employee__name-choosen__user_' + $(this).parent().data('user')).slideUp(200);

        $(this).closest( '.my-partners__rcell' ).find( '.choose-partner' ).removeClass('is-hidden');
        $(this).closest( '.my-partners__rcell' ).find( '.choosen-partner' ).addClass('is-hidden');

        //$('.requests__col__user_' + $(this).parent().data('user') ).hide();
    });

    $('.employee__name-choose').click( function (event) {
        event.preventDefault();

        $(this).parent().addClass('is-hidden');
        $(this).closest( '.my-partners__rcell' ).find( '.choosen-partner' ).removeClass('is-hidden');

    });

    $('.js__requests__filter__modal__choose_partners').click( function() {

        $('.requests-partners__slide > .my-partners__row').each(function() {

            var opacity     = 1;

            if( $(this).css('opacity') == 0.5 ) {
                opacity     = 0.5
            }

            user = $(this).find('.employee__name-choose').data('user'); // открываем чуваков с этим id

            if( $(this).find('.choose-partner').hasClass('is-hidden') ) {

                $('.employee__name-choosen__user_' + user ).show();
                $('.requests__col__user_' + user ).fadeTo(300, opacity );

            } else {

                $('.employee__name-choosen__user_' + user ).hide();
                $('.requests__col__user_' + user ).hide();

            }
        });

        $.fancybox.close();
        $('#js__filter_input_trigger').trigger('change');

    });

</script>
