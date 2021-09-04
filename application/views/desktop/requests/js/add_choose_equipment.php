<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:29
 */

?>

<script>

    $(document).ready( function () {

        $('input, select').focus( function () {
            if( $(this).hasClass('input__wrong_data') ) {
                $(this).removeClass('input__wrong_data');
            }
        });



        $('#eq__year').mask('9999', {"placeholder": ""});


        $('.js__request_add_form_submit').click( function (e) {
            e.preventDefault();

            var required_field  = true;

            if( $('#eq__brand').val() == '' ) {
                $('#eq__brand').addClass('input__wrong_data');
                required_field = false;
            }

            if( $('#eq__type').val() == '' ) {
                $('#eq__type').addClass('input__wrong_data');
                required_field = false;
            }

            if( !required_field ) {
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Заполните обязательные поля!')
                    .click();

                return;
            }
            else {
                $('.request__add_form').submit();
            }


        });

        $(".new-msg__modal .js__equipment__new_request").click(function () {

            $('.preloader').fadeIn();
            $('.preloader__img').fadeIn();

            equipment_id = $(this).data('equipment_id');

            document.location.href = "<?=$this->config->item('base_url');?>/requests/add/?action=create_request_from_park&equipment_id="+equipment_id;
        });
    })


</script>
