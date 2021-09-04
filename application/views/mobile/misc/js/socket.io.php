<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.04.2018
 * Time: 14:31
 */
?>


<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.08.17
 * Time: 10:54
 */
?>
<script>

    function timerTyping_start() {
        timerTyping = setInterval(function() {
            $('#js__opponent_typing').fadeIn(500).delay(500).fadeOut(500);
        }, 1500);
    }

    function timerTyping_stop() {
        clearInterval(timerTyping);
    }

    $(document).ready( function () {

        socket.on('notification', function (result) {

            var data    = JSON.parse(result);

            <?php if( array_key_exists("notifications__no_messages", $page_content)  && $page_content["notifications__no_messages"] == true ):?>
            if( data.tg == 'new_message' )
                return;
            <?php endif;?>

            <?php if(  array_key_exists("chatroom", $page_content) ):?>
            if( data.tg == 'new_message' && data.from_id == "<?php echo $page_content["opponent"]->id;?>" )
                return;
            <?php endif;?>


            if( data.url == "<?php echo '/'.uri_string();?>" )
                return;


            if( $('#mustache__notification').length <= 0  )
                return;


            var template    = $('#mustache__notification').html(),
                output      = Mustache.render(template, [data]);

            if( typeof data.id !== 'undefined' ) {

                noty({
                    text        : 'bottomLeft',
                    type        : 'alert',
                    dismissQueue: true,
                    maxVisible  : 2,
                    timeout     : false,
                    layout      : 'bottomLeft',
                    theme       : 'relax_mobile',
                    template    : output,
                    closeWith   : ['button'],
                    animation   : {
                        open: {opacity: 'show'},
                        close: {opacity: 'hide'},
                        easing: 'linear',
                        speed:  300 // opening & closing animation speed
                    }

                });

            } else {

                noty({
                    text        : 'bottomLeft',
                    type        : 'alert',
                    dismissQueue: true,
                    maxVisible  : 2,
                    timeout     : 3000,
                    layout      : 'bottomLeft',
                    theme       : 'relax_mobile',
                    template    : output,
                    closeWith   : ['button'],
                    animation   : {
                        open: {opacity: 'show'},
                        close: {opacity: 'hide'},
                        easing: 'linear',
                        speed:  300 // opening & closing animation speed
                    }
                });
            }


            var sound = new buzz.sound("/assets__old/sounds/just-like-magic-3", {
                formats: [ "ogg", "mp3" ],
                preload: true,
                autoplay: true,
                loop: false,
            });

        });


        <?php if( array_key_exists("chatroom", $page_content)):?>
            socket.on('message', function (result) {

                var data    = JSON.parse(result);

                if( data.chatroom_id != <?php echo $page_content["chatroom"];?>) {
                    return;
                }
                $('#ajax-input-last_message_id').val(data.id);
                $('#ajax-last_loaded_message').val(data.id);    // Для подгрузки старых во время скролла

                if( $('#mustache__new_message_item').length <= 0 || $('#mustache__notification').length <= 0 )
                    return;


                if( data.is_author == true )
                    var template        = $('#mustache__new_message_item').html();
                else
                    var template        = $('#mustache__message_item').html();


                var template_notify = $('#mustache__notification').html(),
                    output          = Mustache.render(template, data),
                    output_notify   = Mustache.render(template_notify, data);

                $('.ajax-messages-list').append(output);
                $("html, body").animate({scrollTop: $(document).height()}, 100);

                if (data.is_author == false) {
                    $('#bottom-notifications').html('').append(output_notify).fadeIn(500);

                    $.post('/ajax/read_messages',
                        { 'chatroom': data.chatroom_id },
                        function(result) {
                            if (result) {

                            }
                        }
                    );
                }

            });

            socket.on('message__edit', function (result) {

                var data    = JSON.parse(result);

                if( $('#mustache__new_message_item').length <= 0 )
                    return;

                var template    = $('#mustache__new_message_item').html(),
                    output      = Mustache.render(template, data);

                $('.message-id-'+data.id).replaceWith(output);
                $("html, body").animate({ scrollTop: $(document).height() }, 100);

            });
        /*
                    socket.on('informer__message_typing', function (result) {

                        var data        = JSON.parse(result);
                        var timerTyping;

                        if ( data.chatroom_id == < ?php echo $page_content["chatroom"];?> ) {

                    if( data.action == 'start' ){
                        timerTyping_start();
                    }
                    console.log(data.action);

                    if( data.action == 'stop' ){
                        timerTyping_stop();
                    }

                }

            });
*/
        socket.on('informer__dialog_read', function (result) {

            var data    = JSON.parse(result);

            if ( data.chatroom_id == <?php echo $page_content["chatroom"];?> ) {
                $('.message__unread > .conversation__action > .ajax-edit-message').remove();
                $('.message__unread').removeClass('message__unread');
            }

        });
        <?php endif;?>


        <?php if( array_key_exists("notifications__no_messages", $page_content)  && $page_content["notifications__no_messages"] == true ):?>
            socket.on('informer__message_typing', function (result) {

                var data            = JSON.parse(result);
                var dialog_item     = $('.js__dialog_'+ data.chatroom_id);
                var old_text        = dialog_item.find('.my-dialogs__text');
                var typing_text     = dialog_item.find('.my-dialogs__text__typing');


                if ( dialog_item.length > 0 ) {
                    old_text.addClass('is-hidden');
                    typing_text.removeClass('is-hidden');

                    var timerTyping = setInterval(function() {
                        typing_text.fadeIn(500).delay(500).fadeOut(500);
                    }, 1500);

                    setTimeout(function() {
                        clearInterval(timerTyping);
                        typing_text.addClass('is-hidden');
                        old_text.removeClass('is-hidden');
                    }, 5000);

                }

            });
        <?php endif;?>
        socket.on('message__dialog_update', function (result) {

            if( $('.js__dialogs_page__dialogs_list').length > 0 ) {
                <?php /* Мы на странице списка диалогов и  обновляем только список */;?>

                var data = JSON.parse(result);

                if( $('#mustache__dialog_item').length <= 0 )
                    return;

                var template    = $('#mustache__dialog_item').html(),
                    output      = Mustache.render(template, data);

                if ($('.js__dialog_' + data.chatroom_id).length > 0) {
                    $('.js__dialog_' + data.chatroom_id).remove();
                }
                $('.js__dialogs_page__dialogs_list').prepend(output);

            }
        });

        /*              MENU            */

        socket.on('informer__message', function (result) {

            var data    = JSON.parse(result);

            $('#js-left-sidebar-menu__messages > .msg-counter').remove();

            if( data.unread_dialogs != 0 ) {
                $('#js-left-sidebar-menu__messages').append(''+
                    '<span class="msg-counter">'+
                    '<span class="msg-counter__item">'+data.unread_dialogs+'</span>'+
                    '</span>'
                );
                $("#messages_topbar_informer").addClass("has-msg");
                $("#messages_topbar_informer").find("span").html( data.unread_dialogs );
            } else {
                $("#messages_topbar_informer").removeClass("has-msg");
                $("#messages_topbar_informer").find("span").html("");
            }

        });









        /*              PARTNERS            */



        socket.on('informer__partner', function (result) {

            var data    = JSON.parse(result);

            if( data.result_out > 0 )
                $('#js-top-menu__partners__outbox').text('Исходящие заявки (' + data.result_out +')');
            else
                $('#js-top-menu__partners__outbox').text('Исходящие заявки');

            if( data.result_in > 0 ) {
                $('#js-left-sidebar-menu__partners').append('' +
                    '<span class="msg-counter">' +
                    '<span class="msg-counter__item">' + data.result_in + '</span>' +
                    '</span>'
                );
                $('#js-top-menu__partners__inbox').text('Входящие заявки (' + data.result_in +')');
                $('#js-left-sidebar-menu__partners').attr('href', '/partners/inbox' );
            }
            else {
                $('#js-left-sidebar-menu__partners').find('.msg-counter').remove();
                $('#js-top-menu__partners__inbox').text('Входящие заявки');
            }

        });



        socket.on('informer__partner__new_partner', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__partner__loop').length <= 0 )
                return;

            var template    = $('#mustache__partner__loop').html(),
                output      = Mustache.render(template, data);
            $('.ajax__partners__partners__list').prepend(output);

        });


        socket.on('informer__partner__new_partner__undo', function (result) {

            var data    = JSON.parse(result);

            if( $('.ajax__partners__partners__list').length != 0 )
                $('.js__list__partner[data-partner-id='+ data +']').remove();

        });



        socket.on('informer__partner__new_inbox_request', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__partner__loop__request_inbox').length <= 0 )
                return;

            var template    = $('#mustache__partner__loop__request_inbox').html(),
                output      = Mustache.render(template, data);

            $('.ajax__partners__inbox__requests').prepend(output);

        });


        socket.on('informer__partner__new_inbox_request__undo', function (result) {

            var data    = JSON.parse(result);

            if( $('.ajax__partners__inbox__requests').length != 0 )
                $('.js__list__partner[data-partner-id='+ data +']').remove();

        });



        socket.on('informer__partner__cancel_request', function (result) {

            var data    = JSON.parse(result);

            if( $('.ajax__partners__inbox__requests').length != 0 )
                $('.js__list__partner[data-partner-id='+ data +']').remove();

        });

        socket.on('informer__partner__cancel_request__undo', function (result) {

            var data    = JSON.parse(result);

            var template    = $('#mustache__partner__loop__request_inbox').html(),
                output      = Mustache.render(template, data);
            $('.ajax__partners__inbox__requests').prepend(output);

        });

        socket.on('informer__news_edit', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__news_loop__news_only').length > 0 ) {

                if ( $('#mustache__news_loop__news_only').length <= 0 )
                    return;

                var template        = $('#mustache__news_loop__news_only').html(),
                    output          = Mustache.render(template, data);

                $(".item-news-"+data.id+ " > .news-advpost__block > .news-post__wrapper").replaceWith( output );
                reinitializeMasonry();
            }

        });


        socket.on('informer__news_comments', function (result) {

            var data    = JSON.parse(result);

            if ( $('#mustache__news_comments').length <= 0 )
                return;

            var template    = $('#mustache__news_comments').html(),
                output      = Mustache.render(template, data);
            $('.news_'+data.news_id+'_replys').append(output);
            if( data.total_news_comments >= 1 ){
                $('.feedback__comments[data-news-id="'+data.news_id+'"]').find('.fa').removeClass('fa-comment-o').addClass('fa-comment');
            } else {
                $('.feedback__comments[data-news-id="'+data.news_id+'"]').find('.fa').removeClass('fa-comment').addClass('fa-comment-o');
            }
            $('.feedback__comments[data-news-id="'+data.news_id+'"]').find('span').text( data.total_news_comments + ' ' + data.total_news_comments__text);

            $("html, body").animate({ scrollTop: $(document).height() }, "slow");


        });


        socket.on('informer__news_comments__edit', function (result) {

            var data    = JSON.parse(result);

            if ( $('#mustache__news_comments').length <= 0 )
                return;

            var template    = $('#mustache__news_comments').html(),
                output      = Mustache.render(template, data);
            $( '.news__comment-'+data.comment_id ).replaceWith(output);

        });


        socket.on('informer__news_comments__remove', function (result) {

            var data    = JSON.parse(result);

            $( '.news__comment-'+data ).fadeOut(300);

        });

        socket.on('informer__news_comments__remove_undo', function (result) {

            var data    = JSON.parse(result);

            $( '.news__comment-'+data ).fadeIn(300);

        });

        socket.on('informer__news_likes', function (result) {

            var data    = JSON.parse(result);

            $('.feedback__postlike[data-news-id="'+data.news_id+'"]').find('.postlike__num').text(data.likes);

        });

        socket.on('new_news', function (result) {

            var data    = JSON.parse(result);

            if( data.is_first_news && "<?php echo $page_content["menu"]['selected'];?>" == "main" ) {

                document.location.href = "//exdor.ru/news/";

            } else {
                if( $('#mustache__news_loop').length <= 0 || $('#mustache__news_loop_modal').length <= 0 )
                    return;

                var template        = $('#mustache__news_loop').html(),
                    //  template_modal  = $('#mustache__news_loop_modal').html(),
                    output          = Mustache.render(template, data);
                    // output_modal    = Mustache.render(template_modal, data);
                $('.ajax__news_container').prepend([output]);
                // $('.ajax__news_modal_container').prepend([output_modal]);
                reinitializeMasonry();

                <?php
                /*  Удаляем блок с информацией о том,
                    что в компании нет новостей
                */
                ?>
                if($('.js--company__no_news_message').length > 0 ) {
                    $('h2.section-title').text('Новости');
                    $('.js--company__no_news_message').remove();
                }
            }
        });

        socket.on('new_ads', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__ads_loop').length <= 0 || $('#mustache__ads_loop_modal').length <= 0 || $('#mustache__ads_loop_full_width').length <= 0 )
                return;

            if( ( data.is_first_offer && "<?php echo $page_content["menu"]['selected'];?>" == "main" ) || data.type != "<?php echo isset($ads_type)? $ads_type : "none" ;?>" ) {

                switch (data.type){
                    case "buy":
                        window.location.href = "//exdor.ru/offers/buy?add=success";
                        break;
                    case "service":
                        window.location.href = "//exdor.ru/offers/service?add=success";
                        break;
                    case "sell":
                        window.location.href = "//exdor.ru/offers?add=success";
                        break;
                }

            } else {
                var template            = $('#mustache__ads_loop').html(),
                    template_modal      = $('#mustache__ads_loop_modal').html(),
                    template_full_width = $('#mustache__ads_loop_full_width').html(),
                    output              = Mustache.render(template, data),
                    output_modal        = Mustache.render(template_modal, data),
                    output_full_width   = Mustache.render(template_full_width, data);
                $('.ajax__offers_container').prepend([output]);
                $('.ajax__offers_modal_container').prepend([output_modal]);
                $('.ajax__offers_full_width_container').prepend([output_full_width]);
                reinitializeMasonry();
            }
        });



        socket.on('new_employer', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__company__new_employer').length > 0 ) {
                var template        = $('#mustache__company__new_employer').html();
                var output          = Mustache.render(template, data);

                $('.ajax__employers_list').prepend([output]);

            }

            if( $('#mustache_template__new_employer__edit_page').length > 0 ) {
                var template_pedit  = $('#mustache_template__new_employer__edit_page').html();
                var output_pedit    = Mustache.render(template_pedit, data);

                $('.ajax__employers_list__page_edit').prepend([output_pedit]);
            }

        });

        socket.on('informer__employer_leave_company', function(result) {
            var data    = JSON.parse(result);
            if( $('.ajax__employers_list__page_edit').length != 0 )
                $('.js__list__partner[data-partner-id='+ data +']').remove();

            if( $('.ajax__employers_list').length != 0 ){
                $('.coworkers-list__item[data-partner-id='+ data +']').remove();
            }
        });


        socket.on('employers_count', function (result) {

            var data    = JSON.parse(result);
            $('.ajax__employers_list__counter').html( '(' + data + ')');
        });

        socket.on('informer__request', function (result) {

            var data    = JSON.parse(result);

            if( data.total > 0 ) {
                if( $('#js-left-sidebar-menu__requests').find('span.msg-counter').length == 1 ) {
                    $('#js-left-sidebar-menu__requests .msg-counter__item').html( data.total );
                } else {
                    $('#js-left-sidebar-menu__requests').append('' +
                        '<span class="msg-counter">' +
                        '<span class="msg-counter__item">' + data.total + '</span>' +
                        '</span>'
                    );
                }
            } else if( data.total == 0 ){
                $('#js-left-sidebar-menu__requests .msg-counter').remove( );
            }

            //  для списка
            if( $("#js-top-menu__requests__inbox").hasClass('active') && data.new == true ) {
                var current_val = parseInt(  $("#js__user-<?php echo $this->session->user;?>__requests_found").text()  );
                $("#js__user-<?php echo $this->session->user;?>__requests_found").text( current_val + 1 );
            }

            if( data.inbox > 0 ) {
                $('#js-top-menu__requests__inbox').html('Входящие <span>(' + data.inbox + ')</span>');
            } else if( data.inbox == 0 ) {
                $('#js-top-menu__requests__inbox').html('Входящие');
            }
            if( data.outbox > 0 ) {
                $('#js-top-menu__requests__outbox').html('Исходящие <span>(' + data.outbox + ')</span>');
            } else if( data.outbox == 0 ) {
                $('#js-top-menu__requests__outbox').html('Исходящие');
            }
        });


        socket.on('requests__list__new', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__request_loop__block').length <= 0 )
                return;

            var template        = $('#mustache__request_loop__block').html(),
                output          = Mustache.render(template, data.request);
            $('.ajax__request_list__'+ data.user+'__' + data.type ).hide();
            $('.ajax__request_list__'+ data.user+'__' + data.type ).prepend([output]);
            $('.ajax__request_list__'+ data.user+'__' + data.type ).fadeIn(300);

        });


        socket.on('requests__list__update', function (result) {

            var data    = JSON.parse(result);

            if( $('#mustache__request_loop__block').length <= 0 )
                return;
            var template        = $('#mustache__request_loop__block').html(),
                output          = Mustache.render(template, data.request);

            if ( $('.ajax__request-item_list__'+ data.user+'__' + data.request_id ).length > 0 ) {

                $('.ajax__request-item_list__'+ data.user+'__' + data.request_id ).remove();
                $('.ajax__request_list__'+ data.user+'__' + data.type ).hide();
                $('.ajax__request_list__'+ data.user+'__' + data.type ).prepend([output]);
                $('.ajax__request_list__'+ data.user+'__' + data.type ).fadeIn(300);


                // Поднимаем любые заявки, по которым у нас есть обновления
                // $('.ajax__request-item_list__'+ data.user+'__' + data.request_id ).replaceWith(output);

            }
        });


        socket.on('informer__company_employers__count', function (result) {

            var data    = JSON.parse(result);

            $('#js-left-sidebar-menu__employers').append(''+
                '<span class="msg-counter">'+
                '<span class="msg-counter__item">'+data+'</span>'+
                '</span>'
            );

        });

        socket.on('informer__company_new__employer_modal', function ( result ) {

            var data    = JSON.parse(result);

            if( $('#mustache__company__new_employer__modal').length <= 0 )
                return;

            var template        = $('#mustache__company__new_employer__modal').html(),
                output          = Mustache.render(template, data);

            $('.js__new_employer__on_company_page').prepend([output]);

        })

    });
</script>

