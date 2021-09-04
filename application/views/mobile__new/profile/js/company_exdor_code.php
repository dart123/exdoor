<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.07.17
 * Time: 12:29
 */
?>

<script>
    /*      Ввод пароля для подтверждения компании    */

    $('.js__exdor_code__trigger').click( function () {
        $.fancybox.open({
            helpers     : {
                overlay : {
                    locked: true
                }
            },
            closeBtn    : false,
            src        : '#enter_exdor_code--modal',
            afterShow   :   function() {
                $( '.js__exdor_code_input').first().focus();

            },
        });
    });


    $('.js__exdor_code_input').mask('9', {"placeholder": ""});
    $('.js__exdor_code_input').keyup( function () {

        $('.exdor_code__wrong').fadeOut();
        $('.exdor_code__success').fadeOut();

        if( $(this).val().length ) {
            var next_element    = $(this).next( '.js__exdor_code_input' ),
                code            = '';

            if( next_element.length ) {
                next_element.focus();
            }

            $( '.js__exdor_code_input' ).each( function( index ) {
                code += $( this ).val();
            });

            if( code.length == 5 ) {
                $.ajax({
                    url:   '/ajax/profile__company__approvment',
                    data: {
                        'code'      : code
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(result){
                        if( result == 'wrong' ){
                            $('.exdor_code__wrong').fadeIn();
                        } else if( result == 'success' ) {
                            $('.js__exdor_code_input').fadeOut(500);
                            $('.exdor_code__success').fadeIn();
                            setInterval('document.location.href = <?=$this->config->item('base_url');?>"/company"', 1000);
                        }

                    },
                    complete: function( result ){
                        $( '.js__exdor_code_input' ).each( function( index ) {
                            $( this ).val('');
                            if(index == 0)
                                $(this).focus();
                        });
                    }
                });
            }
        }
    });
</script>
