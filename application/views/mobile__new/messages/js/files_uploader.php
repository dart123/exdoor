<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 18:05
 */

?>

<script>
    function uploadImg_msg(event) {
        event.preventDefault();
        $("#fileElem_msg").removeClass("active");
        $("#filelist_msg").removeClass("active");
        $(event.target).closest("form").find("#fileElem_msg").addClass("active");
        $(event.target).closest("form").find("#filelist_msg").addClass("active");
        $(event.target).closest("form").find("#fileElem_msg").click();
        return false;
    }

    function handleFiles_msg(files) {

        var list        = $("#filelist_msg.active");
        var fileTypes   = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
        if (!files) {
            alert('Здесь ie9');
        } else {


            already_f =  $('#filelist_msg > li').length;
            if ( already_f ) {
                files_left  = 10 - already_f;
            } else
                files_left  = 10;

            if( files.length > files_left ){
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Превышен лимит')
                    .attr('data-notifyText',  'Вы можете прикрепить не более 10 файлов в одному сообщению!')
                    .click();
                return true;
            }

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

                                var images_count = $('ul#filelist_msg li').size();
                                $('.js-attachment-count-list > span').text( images_count );
                                if(images_count > 0 ) {
                                    $('.js-attachment-count-list').css({'display': 'block'})
                                }
                                if( images_count > 4 )
                                    $('ul#filelist_msg').css( {'overflow-y': 'scroll'});
                                else
                                    $('ul#filelist_msg').css( {'overflow-y': 'hidden'});

                            }

                        };





                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    }
    /* Добавление рамки на фотографии в окне с дозагрузкой фото */
    $("body").on("click", "#filelist_msg li", function(event){
        $(this).toggleClass('active');
    });


    /* Удаление фотографии в функционале прикрепления фото */
    $("body").on("click", "a.remove", function (del) {

        del.preventDefault();
        $(this).parent('li').remove();

        if( $('#filelist_msg > li').length == 0 ){
            $('#fileElem_msg').val('');
        }


        if( $('#filelist_msg_modal > li').length == 0 ){
            $('#fileElem_msg_modal').val('');
        }

        images_count    = $('ul#filelist_msg li').size();

        $('.js-attachment-count-list > span').text( images_count );

        if(images_count == 0 ) {
            $('.js-attachment-count-list').css({'display': 'none'})
        }
    });















    function uploadImg_msg_modal(event) {
        event.preventDefault();
        $("#fileElem_msg_modal").removeClass("active");
        $("#filelist_msg_modal").removeClass("active");
        $(event.target).closest("form").find("#fileElem_msg_modal").addClass("active");
        $(event.target).closest("form").find("#filelist_msg_modal").addClass("active");
        $(event.target).closest("form").find("#fileElem_msg_modal").click();
        return false;
    }

    function handleFiles_msg_modal(files) {

        var list = $("#filelist_msg_modal.active");
        if (!files) {
            alert('Здесь ie9');
        } else {


            already_f =  $('#filelist_msg_modal > li').length;
            if ( already_f ) {
                files_left  = 10 - already_f;
            } else
                files_left  = 10;

            if( files.length > files_left ){
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Превышен лимит')
                    .attr('data-notifyText',  'Вы можете прикрепить не более 10 файлов в одному сообщению!')
                    .click();
                return true;
            }


            for (var i = 0, f; f = files[i]; i++) {

                var reader              = new FileReader(),
                    original_file_name  = files[i].name;

                reader.onload = (function (f) {
                    return function (e) {
                        var li = $("<li></li>");
                        $(list).prepend(li);
                        $(li).append("<img src='" + e.target.result + "'/>");
                        $(li).append("<a href='#' class='remove' data-image-original-name='" + original_file_name + "'></a>");
                        //$(li).append("<a href='#' class='edit'></a>");

                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    }
    /* Добавление рамки на фотографии в окне с дозагрузкой фото */
    $("body").on("click", "#filelist_msg_modal li", function(event){
        $(this).toggleClass('active');
    });

    $(document).ready( function () {

        $( "#filelist_msg" ).sortable({
            helper: 'clone',
            appendTo: '.filelist__clone'
        });

        $( "#filelist_msg_modal" ).sortable({
            helper: 'clone',
            appendTo: '.filelist__clone_modal'
        });

    });

</script>
