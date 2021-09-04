<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:37
 */
?>

<script>
    $('.js__show_full_comment').click( function () {
        $('.req-addressee__comment').css({
            'textOverflow' : 'auto',
            'overflow' : 'auto',
            'whiteSpace' : 'normal'
        });
        $(this).hide();
    });
</script>
