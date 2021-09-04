<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:21
 */
?>
<script>

    $('body').on( 'click', '.feedback__postlike', function(event) {

        var news_id     = $(this).attr('data-news-id'),
            user_id     = $(this).attr('data-user-id'),
            like        = $('.feedback__postlike[data-news-id="'+ news_id +'"]'),
            fa_icon     = $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.fa'),
            liked       = parseInt( like.find('.postlike__num').data( 'is-liked') ),
            likes_count = parseInt( like.find('.postlike__num').data( 'likes-count') );

        if( like.find('.fa').hasClass('fa-heart') ) {
            fa_icon.removeClass('fa-heart').addClass('fa-heart-o');
            if( liked == 1)
                like.find('.postlike__num').text(likes_count - 1).css('color' , '#999');
            else
                like.find('.postlike__num').text(likes_count).css('color' , '#999');
        } else {
            fa_icon.removeClass('fa-heart-o').addClass('fa-heart');
            if( liked == 1)
                like.find('.postlike__num').text(likes_count).css('color' , '#02abc0');
            else
                like.find('.postlike__num').text(likes_count +1 ).css('color' , '#02abc0');
        }



        $.post('/ajax/news_likes',
            { 'news_id': news_id, 'author_id': user_id },
            function(result) {
                data    = JSON.parse( result );
                /*
                if( data.action == 'removed') {

                    $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                    $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.postlike__num').text(data.likes).css('color' , '#999');

                } else if (data.action == 'added') {

                    $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                    $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.postlike__num').text(data.likes).css('color' , '#02abc0');

                }*/
            }
        );
    });

</script>
