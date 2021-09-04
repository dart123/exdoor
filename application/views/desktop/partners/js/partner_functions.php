<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 21:24
 */
?>

<script>
    $(document).ready( function () {
        $('body').click( function (e) {

            modal   = $('.modal__partner__cancel_request');
            if (!modal.is(e.target) && modal.has(e.target).length === 0 && !modal.hasClass('is-hidden') && $('.js-partner__modal__cancel_request').has(e.target).length === 0) {
                modal.addClass('is-hidden');
            }

            modal_remove    = $('.js-partner__remove__modal');
            if (!modal_remove.is(e.target) && modal_remove.has(e.target).length === 0 && !modal_remove.hasClass('is-hidden') && $('.js-partner__open_modal').has(e.target).length === 0) {
                modal_remove.addClass('is-hidden');
            }

            console.log('click');
        })
    });

</script>
