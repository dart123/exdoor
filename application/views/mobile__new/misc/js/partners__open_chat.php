<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.17
 * Time: 14:35
 *
 *      Переход в диалог с партнером или создание нового диалога
 */
?>

<script>
    $('body').on('click', '.js-partner__open_chat', function( e ){
        e.preventDefault();

        var user_id         = $(this).attr('data-user-id');
        var partner_id      = $(this).attr('data-partner-id');
        var offer_id        = $(this).attr('data-offer-id');

        $.post('/ajax/partners__open_chat',
            { 'user_id':user_id, 'partner_id':partner_id, 'offer_id': offer_id },
            function(result) {
                data  = $.parseJSON(result);
                if (data) {
                    document.location.href = data;
                }
            });
    });
</script>


