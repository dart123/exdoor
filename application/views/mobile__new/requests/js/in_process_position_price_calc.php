<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.07.17
 * Time: 10:58
 */
?>

<script>

    count_full_price    = function() {
        full_usd_price      = 0;
        full_rub_price      = 0;
        final_result        = '';

        $('.total_price__position').each( function() {
            if( $(this).data('currency') == 'RUB' ) {

                full_rub_price  += $(this).data('value');

            } else if(  $(this).data('currency') == 'USD'  ) {

                full_usd_price  += $(this).data('value');

            }
        });

        if ( full_usd_price && full_rub_price ) {

            final_result    =  full_rub_price + ' <i class="fa fa-rub"></i> и ' + full_usd_price + ' <i class="fa fa-usd"></i>';

        } else if ( full_rub_price ) {

            final_result    =  full_rub_price + ' <i class="fa fa-rub"></i>';

        } else if ( full_usd_price ) {

            final_result    =  full_usd_price + ' <i class="fa fa-usd"></i>';

        }

        $('.js__full_price').html( final_result );
    }

    $(document).ready( function() {

        //  Вызывает ошибку на устройствах под управлением Android
        //  $('.js__one_item_price__position').mask('9?999999999', {'placeholder': ''});

        $('.js__currency__position').change( function () {

            position_id         = $(this).data('position-id');

            $('.js__one_item_price__position[data-position-id="'+ position_id+'"]').trigger('keyup');

        });

        $('.js__one_item_price__position').keyup( function () {

            position_id         = $(this).data('position-id');

            obj__amount         = $('.js__amount__position_' + position_id);
            obj__total_price    = $('.js__total_price__position_' + position_id );

            if( $(this).val() ) {

                price               = parseInt( $(this).val() );
                amount              = parseInt( obj__amount.data('amount') );

                total_price         = price * amount;

                currency            = $('.select__currency__' + position_id ).val();

                if( currency == 'RUB' )
                    currency_html   = '<i class="fa fa-rub"></i>';
                else
                    currency_html   = '<i class="fa fa-usd"></i>';

                obj__total_price.data('value', total_price);
                obj__total_price.data('currency', currency);
                obj__total_price.html(total_price + ' ' + currency_html);

                $('.js__request_position__total_price__position_' + position_id).show();
            }

            else {

                obj__total_price.data('value', 0);
                obj__total_price.data('currency', '');

                $('.js__request_position__total_price__position_' + position_id).hide();

            }

            count_full_price();

        });


        $('.js__one_item_price__position').trigger('keyup');


    })
</script>
