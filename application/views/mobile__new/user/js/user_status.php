<?php
/**
 * Created by developer with PhpStorm.
 * Date: 25.08.2018 12:41
 *
 *
 */

?>


<script>
    $('body').on( 'click', '.js__profile-status__text, .profile-status__title', function () {
        $( '.js__profile-status__text__edit_icon' ).hide();

        if( $('.js__profile-status__text').data('status') == 'unset' ) {
            text            = '';
        } else text         = $('.js__profile-status__text').text();


        $('.js__profile-status__text').replaceWith('<input  type="text" class="input__type-text profile-status__changer" value="'+text+'" maxlength="150"></div> ');
        $('.profile-status__changer').focus().select();

        $('.js__profile-status__text__save_icon').show(300);
    });

    $('body').on('mouseover', '.js__profile-status__text', function() {
        $( '.js__profile-status__text__edit_icon' ).fadeIn(300);
    });

    $('body').on('mouseout', '.js__profile-status__text', function() {
        $( '.js__profile-status__text__edit_icon' ).fadeOut(300);
    });

    $('body').on( 'click', '.js__profile-status__text__save_icon', function () {


        $( '.js__profile-status__text__edit_icon' ).hide();
        $( '.js__profile-status__text__save_icon' ).hide();

        var new_status  = $('.profile-status__changer').val();

        $.post('/ajax/user_change_status',
            {
                'status'    : new_status,
                'user'      : <?php echo $page_content["user"]->id;?>
            },
            function(result) {
                var data    = $.parseJSON(result);
                var status   = 'set';

                if( new_status.length == 0 ) {

                    new_status  = '<span class="is-grey-text">укажите статус</span>';
                    status      = 'unset';

                    $('.profile-status__changer').replaceWith('<a href="#" class="js__profile-status__text profile-status__text pointer" data-status="'+status+'" data-user="<?php echo $page_content["user"]->id;?>">'+new_status+'</a>');

                }

                if( data != 'not_changed')  {

                    if (data != 'error' ) {

                        $('.profile-status__changer').replaceWith('<a href="#" class="js__profile-status__text profile-status__text pointer" data-status="'+status+'" data-user="<?php echo $page_content["user"]->id;?>">'+new_status+'</a>');

                        if( status == 'unset' ) {
                            $('.notify-trigger--success').attr('data-notifyTitle', "Статус удален")
                                .attr('data-notifyText',  'Ваш статус успешно удален')
                                .click();
                        }
                        else if (data == 'changed')
                            $('.notify-trigger--success').attr('data-notifyTitle', "Статус обновлен")
                                .attr('data-notifyText',  'Ваш статус успешно обновлен')
                                .click();

                    } else if( data == 'error' ) {

                        $('.notify-trigger--alert').attr('data-notifyTitle', "Произошла ошибка")
                            .attr('data-notifyText',  'Не удалось сохранить новый статус')
                            .click();

                    }

                }
                else {
                    $('.profile-status__changer').replaceWith('<a href="#" class="js__profile-status__text profile-status__text pointer" data-status="'+status+'" data-user="<?php echo $page_content["user"]->id;?>">'+new_status+'</a>');

                }

            }
        );

    });

</script>

