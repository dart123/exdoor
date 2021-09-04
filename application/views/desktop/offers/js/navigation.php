<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:30
 *
 *      Использование history.js
 */
?>

<script>

    window.addEventListener('popstate', function(e) {
        // $.fancybox.close();
        if( (history.state != null) && ('id' in history.state) && (history.state.id != undefined)) {
            id          = history.state.id;

            //fancy_link  = $(".fancybox__adv-news[href='#adv-post"+ id +"']");
            //fancy_link.removeAttr('data-id').fancybox().trigger('click').attr('data-id', id);

            $.fancybox.open('#adv-post'+id);
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
            history.pushState( null, null, '/offers/<?php echo $offers_type;?>/');
        }
    });

    $('body').on( 'click', '.fancybox__adv-news', function () {
        var id = $(this).attr('data-id');
        if( id != undefined) {

            history.pushState( { 'id' : id }, null, '/offers/<?php echo $offers_type;?>/'+id);

            $.ajax({
                url:   '/ajax/offers__view',
                data: {
                    'offer_id'      : id,
                },
                type: 'POST',
                dataType: 'json',
            });
        }

    });
</script>
