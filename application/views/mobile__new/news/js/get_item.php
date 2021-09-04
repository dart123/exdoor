<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:15
 */
?>

<script>
    $("body").on("click", '.ajax__news_edit', function () {
        var news_id  = $(this).attr('data-id');
        $.fancybox.close();

        $( "#filelist_news" ).html('');

        $.post('/ajax/get_news_item',
            { 'news_id':news_id },
            function(result) {
                if (result) {
                    $.fancybox.close();
                    var data  = $.parseJSON(result);

                    $('#add-news').find('.modal__title').text('Изменить новость');
                    $('#ajax__input__news_id').val( news_id );
                    $("#ajax__input__action").val( 'edit_news' );
                    $('#add-news').find(".add-news__submit").val("Изменить");

                    $('#ajax__input__news_content').val( data.content_html ).change();

                    $.each( data.images, function( key, value ) {
                        $('#filelist_news').append('<li class="js__existing_image"><img src="/uploads/news/'+news_id+'/small_'+value+'" data-original-src="'+value+'"><a href="#" class="remove js-remove_existing_image" data-image-original-name="images.jpeg"></a></li>');
                    });
                    $.fancybox.open({
                        src        : '#add-news',
                        closeBtn    :  false,
                        beforeShow: function(){
                            $("body").css({'overflow-y':'hidden', 'position': 'fixed'});
                        },
                        afterClose: function(){
                            $("body").css({'overflow-y':'visible', 'position': 'relative'});
                        }
                    });
                }
            }
        );

        $("#ajax__input__news_content").val(
            $("#js__news_list__news_" + news_id ).find(".news-advpost__text > p").text()
        );

    });
</script>
