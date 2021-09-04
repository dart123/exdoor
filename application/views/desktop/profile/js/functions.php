<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.07.17
 * Time: 12:32
 */
?>

<script>
    function letter_counter_50 ( textarea_object ) {
        var box     = textarea_object.val(),
            count   = 50 - box.length;

        if(box.length <= 50)
        {
            textarea_object.next('.textarea-count-label').html(count);
        }
        return false;
    }

    function letter_counter_400 ( textarea_object ) {
        var box     = textarea_object.val(),
            count   = 400 - box.length;

        if(box.length <= 400)
        {
            textarea_object.next('.textarea-count-label').html(count);
        }
        return false;
    }

    function letter_counter_sms ( textarea_object ) {
        var box     = textarea_object.val(),
            count   = 67 - box.length;

        if(box.length <= 67)
        {
            textarea_object.next('.textarea-count-label').html(count);
        }
        return false;
    }

    var num = 0;

    function showPreviewImage_click(e) {

        $('#choose-portrait-img__place').find('img').remove();

        var $input = $(this);
        var inputFiles = this.files;
        if(inputFiles == undefined || inputFiles.length == 0) return;

        for (var i = 0; i<inputFiles.length; i++) {




            var id = 'id'+ ++num;

            var inputFile = inputFiles[i];

            if( inputFile.size > 7900000) {

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                    .click();
                return;

            }

            var img = $('<img/>', {'class': 'img-responsive'});
            img.appendTo($('#choose-portrait-img__place'));
            var reader = new FileReader();

            reader.onload = (function (img1) {

                    return function(event) {

                        img1.attr("src", event.target.result);

                        img1.onload = function() {

                            if( this.width > 5000 || this.height > 5000) {

                                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                    .attr('data-notifyText',  'Разрешение загружаемого изображения превышает 5000х5000 пикселей.')
                                    .click();
                                return false;

                            } else {

                                $('.my-pers-profile__photo').css({
                                    'backgroundImage'   : '#b1eaf1',
                                    'backgroundRepeat'  : 'no-repeat',
                                    'backgroundPosition': 'center center',
                                    'backgroundColor'   : 'transparent'
                                });

                                $('.helpers-signs__content').html('');

                                $('.js__remove_logo').removeClass('is-hidden');

                            }
                        }

                    };
                }
            )(img);

            reader.onerror = function(event) {
                alert("I AM ERROR: " + event.target.error.code);
            };

            reader.readAsDataURL(inputFile);}
    }




    $('.js__remove_logo').click( function( ) {

        $('.my-pers-profile__photo > label').find('img').remove();
        $('input[name=logo]').val('');

        $('.my-pers-profile__photo').css({'backgroundColor': '#b1eaf1', 'backgroundImage' : 'none'});
        $('.helpers-signs__content').html('<div class="helpers-signs__icons"><i class="fa fa-user"></i> </div><span>Добавить логотип</span>');
        $('.helpers-signs__content').show();

        $('.js__remove_logo').addClass('is-hidden');


    });



    $('#js__select__brand_tags').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: false,
        onChange: function () {
            $('.selectize-input').removeClass('input__wrong_data');
        }
    });
</script>
