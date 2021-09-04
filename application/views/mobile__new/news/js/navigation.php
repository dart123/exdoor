<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:14
 */

?>

<script>
    window.addEventListener('popstate', function(e) {
        // $.fancybox.close();
        if( (history.state != null) && ('id' in history.state) && (history.state.id != undefined)) {
            var id          = history.state.id;
            $.fancybox.open('#news-post'+id);
        } else {
            $.fancybox.close();
        }
    });

    $('.fancybox__adv-news').fancybox({
        helpers     : {
            overlay : {
                locked: true
            }
        },
        afterClose  : function () {
            history.pushState( null, null, '/news/');
        }
    });

    $('body').on( 'click', '.fancybox__adv-news', function () {
        var id = $(this).attr('data-id');
        if( id != undefined)
            history.pushState( { 'id' : id }, null, '/news/'+id);
    });
</script>
