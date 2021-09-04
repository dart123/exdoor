<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-30
 * Time: 16:48
 */

?>

<script>
    $('.js__show_full_about').click( function (e) {
        e.preventDefault();
        $('.js__company_about_full').css({
            'textOverflow'  : 'auto',
            'overflow'      : 'auto',
            'whiteSpace'    : 'normal'
        });
        $(this).hide();
    });
</script>
