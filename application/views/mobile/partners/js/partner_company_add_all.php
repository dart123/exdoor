<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.01.2018
 * Time: 10:42
 */
?>

<script>
    $(document).ready( function () {
        $('.js--company--add-all-partners').click( function () {
            var company_id  = $(this).data('company-id');

            $.post('/ajax/partners__company_add_all',
                { 'company_id' : company_id },
                function(result) {
                    var data  = $.parseJSON(result);
                    if (data) {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  'Заявки отправлены ('+data+')')
                            .click();

                        $('.relationship__none').addClass('is-hidden');
                        $('.relationship__get_request').removeClass('is-hidden');
                        $('.modal__partner__cancel_request').removeClass('is-hidden');
                        $('#ajax-input-message').focus();

                        console.log(data);
                    }
                    else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Внимание!")
                            .attr('data-notifyText',  'Не отправлено ни одной завяки')
                            .click();
                    }
                });
        })
    })
</script>
