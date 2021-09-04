<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.02.17
 * Time: 23:28
 */
?>



<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>


<script>
    // Редактирование компании


    var num = 0;
    function showPreviewImage_click(e) {

        var $input = $(this);
        var inputFiles = this.files;

        if(inputFiles != undefined && inputFiles.length > 0)
        {

            $('.helpers-signs__content').hide();
            $('.my-pers-profile__photo').addClass('my-pers-profile__photo__no_background');
            $('#choose-portrait-img__place').find('img').remove();


            for (var i = 0; i<inputFiles.length; i++) {
                var id = 'id'+ ++num;

                var inputFile = inputFiles[i];
                var img = $('<img/>', {'class': 'img-responsive'});
                img.appendTo($('#choose-portrait-img__place'));
                var reader = new FileReader();

                reader.onload = (function (img1)
                    {
                        return function(event) {
                            img1.attr("src", event.target.result);
                        };
                    }
                )(img);

                reader.onerror = function(event) {
                    alert("I AM ERROR: " + event.target.error.code);
                };

                reader.readAsDataURL(inputFile);
            }
        }

    }


    $('#js__select__brand_tags').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: false,
        onChange: function () {
            $('.selectize-input').removeClass('input__wrong_data');
        }
    });








    $(document).ready(function () {

        $('input[name=r_account]').mask('99999999999999999999', {"placeholder": "_"});


        $('.is-placeholder').change( function () {
            $(this).removeClass('is-placeholder');
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
                    $('#js-input-city-hidden').val( 0 );
                    $(this).removeClass('input__wrong_data');
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



        $('body').on( 'click', '.js-employer--change_data', function () {
            var user_id     = $(this).attr('data-employer-id'),
                edit_block  = $('.js__employer__control__block__'+user_id);

            if( edit_block.css('display') == 'none')
                edit_block.slideDown();
            else
                edit_block.slideUp();
        });



        /*
        $('.ajax__employer_data_update').change( function () {
            var employer_id     = $(this).data('employer-id'),
                type            = $(this).data('action'),
                data            = $(this).val();
            $.ajax({
                url:   '/ajax/update_employer_status',
                data: {
                    employer_id:    employer_id,
                    type:           type,
                    data:           data
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){

                },
                success: function(result){
                    if (result) {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Успешно")
                            .attr('data-notifyText',  'Данные успешно изменены')
                            .click();

                        if( type == 'profession')
                            $('.ajax__company_edit__employer_profession__' + employer_id ).text(data);
                    }
                },
                complete: function( result ){

                }
            });
        });

        */



    })
</script>
