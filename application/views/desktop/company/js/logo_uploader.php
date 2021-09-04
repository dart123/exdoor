<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.17
 * Time: 1:10
 */

?>

<script>
    $(document).ready( function () {


        $('.ajax-upload-avatar-profile').change(function(){

            var input    = $(this);
            var fd       = new FormData;

            fd.append('img', input.prop('files')[0]);

            if( input.prop('files')[0].size > 7900000) {

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                    .click();
                return;

            }

            $.ajax({
                url: '/ajax/company_logo_upload',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function (result) {
                    var data  = $.parseJSON(result),
                        alert;
                    if( data.status == 'success' ){
                        alert = $('.notify-trigger--success');
                    } else  {
                        alert = $('.notify-trigger--alert');
                    }

                    if( data.code == 1 ) {
                        $('.my-pers-profile__photo').css({
                            'backgroundImage'   : 'url(/uploads/companies/'+data.id+'/logo/180_'+data.image+')',
                            'backgroundRepeat'  : 'no-repeat',
                            'backgroundPosition': 'center center',
                            'backgroundColor'   : 'transparent'
                        });
                        $('.helpers-signs__content').html('');

                        $('.js__remove_logo').removeClass('is-hidden');
                    }

                    alert.attr('data-notifyTitle', data.title)
                        .attr('data-notifyText',  data.text)
                        .click();

                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                }
            });

        });



        $('.js__remove_logo').click( function( ) {

            company_id  = $(this).data('company_id');
            action      = $(this).data('action');

            if( action == 'remove_logo' ) {
                $.ajax({
                    url: '/ajax/company_logo_remove',
                    data: {
                        'company_id': company_id,
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function (data) {

                        if( data ) {

                            $('.my-pers-profile__photo').css({'backgroundColor': '#b1eaf1', 'backgroundImage' : 'none'});
                            $('.helpers-signs__content').html('<div class="helpers-signs__icons"><i class="fa fa-user"></i> </div><span>Изменить лого</span>');
                            $('.helpers-signs__content').show();

                            $('.js__remove_logo').addClass('is-hidden');

                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  "Логотип успешно удален!")
                                .click();
                        } else {
                            $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                                .attr('data-notifyText',  "В процессе удаления логотипа произошла ошибка!")
                                .click();
                        }
                    }
                });
            }

        });

    });

</script>
