<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.07.17
 * Time: 12:26
 */
?>

<script>

    $(document).ready( function () {
        $('.js-bic-select-success').hide();
    });

    $("#dadata_input_field__bik").suggestions({
        serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
        token: "e42baa031f283e1377b9a5cbc3c421547f8dc33f",
        type: "BANK",
        count: 15,
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            $(this).val( suggestion.data.bic );
            $('.input-company-koor').val( suggestion.data.correspondent_account );
            $('.input-company-bank-name').val( suggestion.value );
            $('.js-bic-select-success').show();
        },
        onSelectNothing: function(){
            $('.input-company-koor').val('');
            $('.input-company-bank-name').val( '' );
            $('.js-bic-select-success').hide();
        },
        onSearchStart: function(){
            $('.input-company-koor').val('');
            $('.input-company-bank-name').val( '' );
            $('.js-bic-select-success').hide();
        }
    });


    $('#js-autocomplete-city').autocomplete({

        serviceUrl:'/ajax/get_city',
        minChars:2,
        noCache: false,
        onSearchStart:
            function () {
                $('#js-input-city-hidden').val( '' );
            },
        onSelect:
            function(suggestion){
                $('#js-input-city-hidden').val( suggestion.data.city_id );
                $(this).removeClass('input__wrong_data');
            },
        onSearchError:
            function() {
                $('#js-input-city-hidden').val( '' );
                $(this).addClass('input__wrong_data');
            },
        onInvalidateSelection:
            function () {
                $('#js-input-city-hidden').val( '' );
                $(this).addClass('input__wrong_data');
            },
        formatResult:
            function(suggestion, currentValue){
                return (suggestion.data.name+', '+ suggestion.data.region + ', ' +suggestion.data.country);
            }
    });

    $(document).ready( function () {
        $('#input-f-address').hide();
        $('#input-p-address').hide();

        $('.js-f_address-the-same').change( function() {
            if( $(this).prop('checked') == true ){
                var address = $('#input-u-address').val();
                $('#input-f-address').val( address ).hide();
            } else {
                $('#input-f-address').show().val('').focus();
            }
        });
        $('.js-p_address-the-same').change( function() {
            if( $(this).prop('checked') == true ){
                var address = $('#input-u-address').val();
                $('#input-p-address').val( address ).hide();
            } else {
                $('#input-p-address').show().val('').focus();
            }
        });
    });


</script>
