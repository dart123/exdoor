<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:32
 */
?>
<script>
    $('.js__request_add_positions').click( function () {

        var details         = 0,
            cat_nums        = 0;

        $('input[name="detail[]"]').each( function (index) {
            if( $(this).val() != '' )
                details++;
        });
        $('input[name="catalog_num[]"]').each( function (index) {
            if( $(this).val() != '' )
                cat_nums++;
        });

        if( details == 0 && cat_nums == 0 ) {
            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                .attr('data-notifyText',  'Вы должны добавить хотя бы одну позицию!')
                .click();
        } else {
            $('.request__add_form').submit();
        }

    });
</script>
