<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 18:14
 */
?>


<script>

    $(window).load( function () {
        $('.conversation__table').animate(
            {
                'opacity': 1
            }, 700
        );


        <?php   /* Стабилизируем отступы  */    ;?>

        convHeight      = $("#conversation__res").height();

        console.log( $("#conversation__res").height() );
        convHeightTotal = convHeight - 40;

        $("#conversation__res").parent().find(".conversation__table").css('margin-bottom' , convHeightTotal);


        window.scrollTo(0,document.body.scrollHeight);

        var chatroom    = <?php if ( isset($chatroom) )  echo $chatroom; else echo '0';?>;
        $.post('/ajax/read_messages',
            { 'chatroom': chatroom },
            function(result) {
                if (result) {
                    //$('.conversation__row').removeClass('message__unread');
                }
            }
        );

        $('#ajax-input-message').focus();

    });

    $(window).scroll(function () {

        window__full_height     = $(document).scrollTop() +  window.innerHeight;

        if( ( $(document).height() - window__full_height  ) == 0 ) {
            var chatroom    = <?php if ( isset($chatroom) )  echo $chatroom; else echo '0';?>;

            $.post('/ajax/read_messages',
                { 'chatroom': chatroom },
                function(result) {
                    if (result) {
                        //$('.conversation__row').removeClass('message__unread');
                    }
                }
            );



        }

        if( $(window).scrollTop() == 0 ) {

            if( !$('.conversation__table').hasClass('info--all-messages-loaded') ) {

                var chatroom                = $('#ajax-input-chatroom').val();
                var last_loaded_message     = $('#ajax-last_loaded_message').val();

                var tempOldDocHeight           = $(document).height();

                $.ajax({
                    url: '/ajax/load_messages',
                    data: {
                        chatroom: chatroom,
                        last_loaded_message: last_loaded_message
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function (xhr) {

                        var q = $('.preloader').queue();
                        if( !q.length )
                        {
                            $('.preloader').fadeIn();
                            $('.preloader__img').fadeIn();
                            $('body').delay(350).css({'overflow': 'hidden'});
                        }
                    },
                    success: function (data) {

                        previous_height = 0;

                        if (data) {

                            template    = $('#mustache__message_item').html();
                            output      = Mustache.render(template, data);

                            $('.ajax-messages-list').prepend(output);

                            data.forEach(function (item, i, data) {
                                console.log(item);
                                if (parseInt( item.id ) < parseInt($('#ajax-last_loaded_message').val())) {
                                    $('#ajax-last_loaded_message').val(item.id);
                                    previous_height += $('.message-id-' + item.id).outerHeight();
                                }
                            });

                            $('body').scrollTop(previous_height);

                            <?php   /* Стабилизируем отступы  */    ;?>
                            var convHeight      = $("#conversation__res").height();
                            var convHeightTotal = convHeight - 40;

                            $("#conversation__res").parent().find(".conversation__table").css('margin-bottom' , convHeightTotal);




                        } else {
                            if (!$('.conversation__table').hasClass('info--all-messages-loaded')) {
                                $('.notify-trigger--alert').attr('data-notifyTitle', "Это все сообщения")
                                    .attr('data-notifyText', 'Вы достигли самого начала переписки')
                                    .click();
                                $('.conversation__table').addClass('info--all-messages-loaded')
                            }

                        }
                    },
                    complete: function (result) {

                        var tempNewDocHeight    = $(document).height();
                        $(window).scrollTop( tempNewDocHeight - tempOldDocHeight );

                        $('.preloader__img').fadeOut();
                        $('.preloader').delay(350).fadeOut('slow');
                        $('body').delay(350).css({'overflow': 'visible'});
                    }
                });

            }


        }
    });

</script>
