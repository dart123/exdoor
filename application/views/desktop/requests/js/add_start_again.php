<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.07.17
 * Time: 18:36
 */
?>
<script>
    $('.js__request__remove').click( function () {
        var request_id      = $(this).attr('data-request-id');

        $.post('/ajax/request__remove',
            { 'request_id':request_id },
            function(result) {
                var data  = $.parseJSON(result);
                if(data == 'true') {
                    document.location.href = "<?=$this->config->item('base_url');?>/requests/add";
                }
            });
    });
</script>
