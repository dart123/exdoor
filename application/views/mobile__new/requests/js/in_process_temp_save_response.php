<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.08.17
 * Time: 10:27
 */
?>

<script>
    $(document).ready( function () {
        $('body').on('change', '.js__temp_save_response', function () {

            request_id     = <?php echo $page_content["request_data"]->id;?>;

            if( $(this).is('[data-position-id]') )
                position_id    = $(this).data('position-id');
            else
                position_id    = false;


            if( $(this).data('input-name') == 'in_stock' ) {
                p_field       = 'in_stock';
                p_value       = 1
            }
            else if( $(this).data('input-name') == 'not_in_stock' ) {
                p_field       = 'not_in_stock';
                p_value       = 0
            }
            else if( $(this).data('input-name') == 'shipping' ) {
                p_field       = 'shipping';
                p_value       = $(this).val();
            }
            else if( $(this).data('input-name') == 'currency' ) {
                p_field       = 'currency';
                p_value       = $(this).val();
            }
            else if( $(this).data('input-name') == 'price' ) {
                p_field       = 'price';
                p_value       = $(this).val();
            }
            else if( $(this).data('input-name') == 'actual' ) {
                p_field       = 'actual';
                p_value       = $(this).val();
            }
            else if( $(this).data('input-name') == 'comment' ) {
                p_field       = 'comment';
                p_value       = $(this).val();
            }

            $.ajax({
                url:   '/ajax/request__save_temp_data',
                data: {
                    request_id          : request_id,
                    position_id         : position_id,
                    value               : p_value,
                    field               : p_field
                },
                type: 'POST',
                dataType: 'json',
            });
        })
    })
</script>
