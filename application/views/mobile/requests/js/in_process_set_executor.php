<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:34
 */
?>

<script>
    $('.feedback__choose-executant').click( function () {

        var name        = $(this).data('executor'),
            id          = $(this).data('executor-id');

        $('#js__executor_id').val( id );
        $('#js__executor_name').text( name );
        $.fancybox({
            'href'      : '#confirm',
            closeBtn    : false,
        });
    });
</script>
