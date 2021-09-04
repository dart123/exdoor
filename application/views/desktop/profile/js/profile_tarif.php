<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.08.17
 * Time: 18:13
 */
?>

<script>
    $(document).ready( function () {

        $(".tarif__payment_type").click(function(event){
            if($('#invoice_com').is(':checked')) {
                $('.invoice__fiz_line').fadeIn(300);
                $('.invoice__com_line').fadeOut(0);
            } else {
                $('.invoice__fiz_line').fadeOut(0);
                $('.invoice__com_line').fadeIn(300);
            }
        });

        $(".js__profile-plan__fast-price-link").click( function (e) {
            e.preventDefault();

            var type    = $(this).data("type"),
                value   = $(this).data("value");

            if( type == "fiz" ) {
                $("#invoice__price_fiz").val( value );
            } else if( type == "com") {
                $("#invoice__price_com").val( value );
            }

        });






        $(".js__change_tarif__modal").click( function (e) {
            e.preventDefault();
            var type    = $(this).data("type");

            if( type == "user" ){
                var period  = $("input[name=premium_user]:checked").val();
            } else if( type == "company" ) {
                var period  = $("input[name=premium_company]:checked").val();
            }

            $.ajax({
                url:   '/ajax/change_plan__check',
                data: {
                    type: type,
                    period: period,
                },
                type: 'POST',
                dataType: 'json',

                success: function(result){
                    if (result == "not_enouth_money") {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  'На вашем счете недостаточно средств')
                            .click();
                    } else if (result == "error") {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  'Попробуйте повторить операцию позднее')
                            .click();
                    } else if (result == "ok") {

                        $(".js__change_plan").data("type", type).data("period", period);

                        $.fancybox.open({
                            src        : '#change_plan',
                            closeBtn    :  false,
                        });
                    }
                }
            });
        });




        $(".js__change_plan").click( function () {

            var type    = $(this).data("type"),
                period  = $(this).data("period");

            $.ajax({
                url:   '/ajax/change_plan',
                data: {
                    type: type,
                    period: period,
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){

                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();

                },
                success: function(result){
                    if (result == "ok") {
                        location.reload();
                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  'Попробуйте повторить операцию позднее')
                            .click();
                    }
                },
                complete: function( result ){

                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                }
            });
        });

    });

</script>
