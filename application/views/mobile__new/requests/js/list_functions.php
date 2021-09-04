<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.17
 * Time: 22:30
 */
?>

<script>

    $(document).ready( function() {
        $('body').on('click', '.js__requests__context_menu', function() {
            url     = $(this).data('href');
            document.location.href      = url;
        })
    })

</script>
