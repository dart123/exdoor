<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:13
 */
?>

<script>
    function uploadImg_news(event) {
        event.preventDefault();
        $("#fileElem_news").removeClass("active");
        $("#filelist_news").removeClass("active");
        $(event.target).closest("form").find("#fileElem_news").addClass("active");
        $(event.target).closest("form").find("#filelist_news").addClass("active");
        $(event.target).closest("form").find("#fileElem_news").click();
        return false;
    }


    function handleFiles_news(files) {

        var list = $("#filelist_news.active");
        var fileTypes = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

        if (!files) {
            alert('Здесь ie9');
        } else {
            for (var i = 0, f; f = files[i]; i++) {

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
                        var li = $("<li></li>");
                        $(list).prepend(li);
                        $(li).append("<img src='" + e.target.result + "'/>");
                        $(li).append("<a href='#' class='remove' data-image-original-name='" + original_file_name + "'></a>");
                        //$(li).append("<a href='#' class='edit'></a>");

                        var images_count = $('ul#filelist_news li').size();
                        $('.js-attachment-count-list > span').text( images_count );
                        if(images_count > 4 ) {
                            $('.js-attachment-count-list').css({'display': 'block'})
                        }

                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    }
    /* Добавление рамки на фотографии в окне с дозагрузкой фото */
    $("body").on("click", "#filelist_news li", function(event){
        $(this).toggleClass('active');
    });


    /* Удаление фотографии в функционале прикрепления фото */
    $("body").on("click", "a.remove", function (del) {
        del.preventDefault();
        $(this).parent('li').remove();

        if( $('#filelist_news > li').length == 0 ){
            $('#fileElem_news').val('');
        }

    });

    $(document).ready( function () {
        $( "#filelist_news" ).sortable({
            helper: 'clone',
            appendTo: '.filelist__clone_news'
        });
    });



</script>
