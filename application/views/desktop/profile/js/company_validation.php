<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.07.17
 * Time: 14:56
 */
?>

<script>
    $(document).ready( function () {

        $('input[name=r_account]').mask('99999999999999999999', {"placeholder": "_"});

        $('input[name="company_sell"], input[name="company_buy"]').change( function () {

            $('.add_company__type__buy_label').removeClass('input__wrong_data');
            $('.add_company__type__sell_label').removeClass('input__wrong_data');

            company_sell    = $('input[name="company_sell"]').prop('checked');
            company_buy     = $('input[name="company_buy"]').prop('checked');

            if( company_sell == false && company_buy == false ) {
                if( $(this).attr('name') == 'company_sell' ) {
                    $('input[name="company_sell"]').prop('checked', true);
                } else if(  $(this).attr('name') == 'company_buy' ) {
                    $('input[name="company_buy"]').prop('checked', true);
                }

                $('.notify-trigger--alert').attr('data-notifyTitle', "Внимание!")
                    .attr('data-notifyText',  "Должен быть выбран как минимум один вариант!")
                    .click();
            }
        });


        $('.selectize-input').click( function () {
            $(this).removeClass('input__wrong_data');
        });

        $('#js-autocomplete-city').keypress( function () {
            $('#js-input-city-hidden').val( 0 );
        });

        $('#form-submit-save').click( function( ) {

            error           = 0;
            focusObject     = false;


            // Для страницы редактирования компании

            if( $('.js__candidat_data_insert ').length > 0) {

                var candidats_arr   = [];

                $.each(  $('.js__candidat_data_insert ') , function( index, value ) {
                    if( !candidats_arr.includes( $(this).data('employer-id') ) ) {
                        candidats_arr.push( $(this).data('employer-id') );
                    }
                });

                candidats_arr.forEach( function (i, index, candidats_arr) {
                    var prof_val    = $('#profession_candidat-' + i).val();
                    var role_val    = $('#role_candidat-' + i).val();

                    if( prof_val.length > 0 && role_val == null ) {
                        $('#role_candidat-' + i).addClass('input__wrong_data');
                        focusObject     = $('#role_candidat-' + i);
                        error++;
                    }

                    if( prof_val.length == 0 && role_val != null ) {
                        $('#profession_candidat-' + i).addClass('input__wrong_data');
                        focusObject     = $('#profession_candidat-' + i);
                        error++;
                    }
                })
            }


            if( $('.ajax__employer_data_update ').length > 0) {

                $.each(  $('.ajax__employer_data_update ') , function( index, value ) {
                    if( $(this).val() == '' ) {
                        $(this).addClass('input__wrong_data');
                        focusObject     = $(this);
                        error++;
                    }
                });
            }


            if ( !$('#js-input-city-hidden').val() || $('#js-input-city-hidden').val() == 0  ) {
                $('#js-autocomplete-city').addClass('input__wrong_data');
                focusObject     = $('#js-autocomplete-city');
                error++;
            }
            /*
            if ( !$('input[name="bank_name"]').val()  ) {
                $('input[name="bank_bik"]').addClass('input__wrong_data');
                focusObject     = $('input[name="bank_bik"]');
                error++;
            }

            if ( !$('input[name="r_account"]').val()  ) {
                $('input[name="r_account"]').addClass('input__wrong_data');
                focusObject     = $('input[name="r_account"]');
                error++;
            }
            */
            if ( !$('input[name="phone"]').val() || $('input[name="phone"]').val() == '' ) {
                $('input[name="phone"]').addClass('input__wrong_data');
                focusObject     = $('input[name="phone"]');
                error++;
            }

            if ( !$('#js__select__brand_tags').val() ) {
                $('.selectize-input').addClass('input__wrong_data');
                focusObject     = $('#js__select__brand_tags-selectized');
                error++;
            }

            if( $('input[name=company_buy]').prop( 'checked' ) == false &&  $('input[name=company_sell]').prop( 'checked' ) == false ) {
                $('.add_company__type__buy_label').addClass('input__wrong_data');
                $('.add_company__type__sell_label').addClass('input__wrong_data');
                focusObject     = $('input[name=company_buy]');
                error++;
            }



            if( error == 0 ){

                $('.fill-com-form').submit();

            } else {

                focusObject.focus();

                $('.notify-trigger--alert').attr('data-notifyTitle', "Внимание!")
                    .attr('data-notifyText',  "Все обязательные поля должны быть заполнены!")
                    .click();
            }


        })
    })
</script>
