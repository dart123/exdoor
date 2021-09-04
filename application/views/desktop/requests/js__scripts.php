<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 20.02.2017
 * Time: 18:43
 */
?>

<script>

    $(document).ready( function () {
        /*    Добавление партнеров к заявке   */
        $('.js__request__add_partners').click( function () {

            var partners    = [];

            if( $(this).hasClass('js__request__selected_partner') ) {
                $(this).removeClass('js__request__selected_partner');
            }
            else {
                $(this).addClass('js__request__selected_partner')
            }


             $(this).each( function (index) {

                 if( $(this).hasClass('js__request__selected_partner') ) {
                     // добавляем в массив
                 }
             });

            // конвертим в json

            // добавляем в скрытый инпут

        });
    })
</script>
