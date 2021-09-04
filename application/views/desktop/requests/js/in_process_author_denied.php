<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:35
 */
?>
<script>
    $('body').on('click', '.js__request__author_denied', function () {
        request_id      = $(this).data('request-id');
        page_reload     = $(this).data('page-reload');

        $.post('/ajax/request__author_denied',
            { 'request_id':request_id },
            function(result) {
                var data  = $.parseJSON(result);
                if(data == 'true') {

                    if(page_reload == 'yes')
                        document.location.href = "<?=$this->config->item('base_url');?>/requests/";
                    else {
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Исполнено')
                            .attr('data-notifyText',  'Указаная заявка отменена!')
                            .click();
                    }
                }
            });
        $.fancybox.close();
    });

    $('body').on('click', '.js__requests_list__author_denied', function () {
        request_id      = $(this).data('request-id');
        page_reload     = $(this).data('page-reload');

        $('.js__request__author_denied').data('request-id', request_id);
        $('.js__request__author_denied').data('page-reload', page_reload);

        $.fancybox.open({
            src         : '#req__cancel__author',
            closeBtn    : false
        })
    });

</script>
