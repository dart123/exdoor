<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:23
 *
 *      Функции для объявлений
 */

?>

<script>


    function letter_counter_100 ( textarea_object ) {

        var box     = textarea_object.val(),
            count   = 100 - box.length;

        if(box.length <= 100)
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


    function uploadImg_offers(event) {
        event.preventDefault();
        $("#fileElem_offers").removeClass("active");
        $("#filelist_offers").removeClass("active");
        $(event.target).closest("form").find("#fileElem_offers").addClass("active");
        $(event.target).closest("form").find("#filelist_offers").addClass("active");
        $(event.target).closest("form").find("#fileElem_offers").click();
        return false;
    }

    function handleFiles_offers(files) {

        var list = $("#filelist_offers.active");
        var fileTypes = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

        if (!files) {
            alert('Здесь ie9');
        } else {
            for (var i = 0, f; f = files[i]; i++) {

                if( f.size > 7900000) {

                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                        .click();
                    return;

                }

                var reader              = new FileReader(),
                    original_file_name  = files[i].name;

                var extension = files[i].name.split('.').pop().toLowerCase(),  //file extension from input file
                    isSuccess = fileTypes.indexOf(extension) > -1;

                if(!isSuccess) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Указаные вами файлы имеют недопустимый формат!')
                        .click();
                    return;
                }

                reader.onload = (function (f) {
                    return function (e) {



                        var image = new Image();
                        image.src = e.target.result;

                        image.onload = function() {

                            if( this.width > 5000 || this.height > 5000) {

                                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                    .attr('data-notifyText',  'Разрешение загружаемого изображения превышает 5000х5000 пикселей.')
                                    .click();
                                return false;

                            } else {

                                var li = $("<li></li>");
                                $(list).prepend(li);
                                $(li).append("<img src='" + e.target.result + "'/>");
                                $(li).append("<a href='#' class='remove' data-image-original-name='" + original_file_name + "'></a>");
                                //$(li).append("<a href='#' class='edit'></a>");

                                var images_count = $('ul#filelist_offers li').size();
                                $('.js-attachment-count-list > span').text( images_count );
                                if(images_count > 4 ) {
                                    $('.js-attachment-count-list').css({'display': 'block'})
                                }


                            }

                        };

                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    }
    /* Добавление рамки на фотографии в окне с дозагрузкой фото */
    $("body").on("click", "#filelist_offers li", function(event){
        $(this).toggleClass('active');
    });


    /* Удаление фотографии в функционале прикрепления фото */
    $("body").on("click", "a.remove", function (del) {
        del.preventDefault();
        $(this).parent('li').remove();

        if( $('#filelist_offers > li').length == 0 ){
            $('#fileElem_offers').val('');
        }
    });

    $(".limit-100").keyup(function(){
        letter_counter_100( $('#advpost__ta-title') );
        letter_counter_100( $('#advpost__ta-bartertext') );
    });
    $(".limit-400").keyup(function(){
        letter_counter_400( $('#advpost__ta-posttext') );
    });





    $( "#filelist_offers" ).sortable({
        helper: 'clone',
        appendTo: '.filelist__clone_offers'
    });
</script>
