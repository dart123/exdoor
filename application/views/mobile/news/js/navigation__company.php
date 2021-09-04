<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.17
 * Time: 2:05
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

            history.pushState( null, null, '/company/id<?php echo $page_content["company"]->id;?>');
        }
    });

    $('body').on( 'click', '.fancybox__adv-news', function () {
        var id = $(this).attr('data-id');
        if( id != undefined)
            history.pushState( { 'id' : id }, null, '/company/id<?php echo $page_content["company"]->id;?>/news-'+id);
    });
</script>
