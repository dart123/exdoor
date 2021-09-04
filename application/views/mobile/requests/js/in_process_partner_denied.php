<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:35
 */
?>
<script>
    $('.js__request__partner_denied').click( function () {
        request_id      = $(this).data('request-id');
        page_reload     = $(this).data('page-reload');


        $.post('/ajax/request__partner_denied',
            { 'request_id':request_id },
            function(result) {
                var data  = $.parseJSON(result);
                if(data == 'true') {

                    if(page_reload == 'yes')
                        document.location.href = 'https://exdor.ru/requests/inbox';
                    else {
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Исполнено')
                            .attr('data-notifyText',  'Указаная заявка отклонена!')
                            .click();

                    }
                }
            });

        $.fancybox.close();
    });


    $('body').on('click', '.js__requests_list__partner_denied', function () {
        request_id      = $(this).data('request-id');
        page_reload     = $(this).data('page-reload');

        $('.js__request__partner_denied').data('request-id', request_id);
        $('.js__request__partner_denied').data('page-reload', page_reload);

        $.fancybox.open({
            'href'      : '#req__cancel__executor',
            'closeBtn'  : false
        })
    });


</script>
