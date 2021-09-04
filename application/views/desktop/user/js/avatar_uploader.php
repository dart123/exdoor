<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 20:19
 */

?>

<script>
    $('body').on('change', '.ajax-upload-avatar', function(){

        var input    = $(this);
        var fd       = new FormData;

        fd.append('img', input.prop('files')[0]);

        if( input.prop('files')[0].size > 7900000) {

            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                .click();
            return;

        }

        $.ajax({
            url: '/ajax/avatar_upload',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function(xhr){
                $('.ajax__offers_full_width_container').fadeOut();

                $('.preloader').fadeIn();
                $('.preloader__img').fadeIn();
            },
            success: function (data) {

                var alert;

                if( data.status == 'success' ){

                    alert = $('.notify-trigger--success');

                    var html_new_avatar         = '<div class="user-portrait__img user-portrait__img__editable"><img src="/uploads/users/'+data.id+'/avatar/180x180_'+data.image+'" style="width: 100%; height: auto;"><div class="user-portrait__img__edit"><i class="fas fa-pen"></i></div></div>';
                    var html_avatar_label       = $('.js__avatar_label');
                    var html_avatar_helpers     = $('.helpers-signs__content');

                    html_avatar_helpers.remove();
                    html_avatar_label.html( html_new_avatar );

                    $('.ajax__offers_full_width_container').html('');

                    $.ajax({
                        url: '/ajax/load_user_content__pinned_offers',
                        data: {
                            'user_id'   : <?php echo $this->session->user;?>,
                        },
                        dataType: 'json',
                        type: 'POST',
                        beforeSend: function () {

                        },
                        success: function (data) {
                            if (data) {
                                template_a          = $('#mustache__ads_loop_full_width').html();
                                template_a_modal    = $('#mustache__ads_loop_modal').html();

                                data.forEach(function(item, i, data) {

                                    output          = Mustache.render(template_a, item);
                                    output_modal    = Mustache.render(template_a_modal, item);

                                    $('.ajax__offers_full_width_container').append([output]);
                                    $('.ajax__offers_modal_container').append([output_modal]);

                                    $('#ajax__last_loaded_offers').val(item.id);

                                });

                                if( data.length == 0) {
                                    $('.load-more').hide();
                                }

                                reinitializeMasonry();

                            }
                        },
                        complete: function () {

                        }
                    });


                    $.ajax({
                        url: '/ajax/load_user_content',
                        data: {
                            'user_id'           : <?php echo $this->session->user;?>,
                            'last_loaded_news'  : 0,
                            'last_loaded_offers': 0,
                            'limit'             : 10
                        },
                        dataType: 'json',
                        type: 'POST',
                        beforeSend: function () {

                        },
                        success: function (data) {
                            if (data) {
                                template_n          = $('#mustache__news_loop').html();
                                template_n_modal    = $('#mustache__news_loop_modal').html();
                                template_a          = $('#mustache__ads_loop_full_width').html();
                                template_a_modal    = $('#mustache__ads_loop_modal').html();

                                data.forEach(function(item, i, data) {
                                    if( item.post_type == 'news' )
                                    {
                                        output          = Mustache.render(template_n, item);
                                        output_modal    = Mustache.render(template_n_modal, item);

                                        $('.ajax__news_container').append([output]);
                                        $('.ajax__news_modal_container').append([output_modal]);

                                        $('#ajax__last_loaded_news').val(item.id);

                                    }
                                    else if( item.post_type == 'offers' )
                                    {
                                        output          = Mustache.render(template_a, item);
                                        output_modal    = Mustache.render(template_a_modal, item);

                                        $('.ajax__offers_full_width_container').append([output]);
                                        $('.ajax__offers_modal_container').append([output_modal]);

                                        $('#ajax__last_loaded_offers').val(item.id);

                                    }
                                });

                                if( data.length == 0) {
                                    $('.load-more').hide();
                                }

                                reinitializeMasonry();


                                text  = $(".change-title").find('.filter-title').text();
                                text1 = $(".change-title").find('.filter-title').attr("data-textF");
                                text2 = $(".change-title").find('.filter-title').attr("data-textS");
                                text3 = $(".change-title").find('.filter-title').attr("data-textT");

                                if (text == text1) {
                                    $('.news-advpost').fadeIn(300);
                                    $('.advpost').fadeIn(300);
                                } else if (text == text2) {
                                    $('.news-advpost').fadeOut(300);
                                    $('.advpost').fadeIn(300);
                                } else if (text == text3) {
                                    $('.news-advpost').fadeIn(300);
                                    $('.advpost').fadeOut(300);
                                }

                            }
                        },
                        complete: function () {

                        }
                    });




                } else  {
                    alert = $('.notify-trigger--alert');
                }

                alert.attr('data-notifyTitle', data.title)
                    .attr('data-notifyText',  data.text)
                    .click();
            },
            complete: function( result ){

                $('.ajax__offers_full_width_container').fadeIn(300);

                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
            }
        });

    });
</script>
