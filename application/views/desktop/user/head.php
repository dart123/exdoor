<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.08.16
 * Time: 15:48
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width" name="viewport">
    <title><?php echo $meta_data['title'];?> | Exdor.ru</title>
    <meta name="keywords" content="<?php echo $meta_data['keywords'];?>">
    <meta name="description" content="<?php echo $meta_data['description'];?>">


    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#fffefe">

    <link href='https://fonts.googleapis.com/css?family=Arimo:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="/assets/css/desktop.css" rel="stylesheet" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <script src="/assets/js/desktop.js"></script>
    <script>
        <?php if ( $this->router->user_lang == 'en' ):?>
            var page_lang   = 'en';
        <?php else:?>
            var page_lang   = 'ru';
        <?php endif;?>

        $(document).ready( function () {
            socket = io.connect("https://exdor.ru", {
                reconnectionDelay: 1000
            });


            <?php
                $noty_data = array(
                    'user_id'       => '1',
                    'from_id'       => $this->session->user,
                    'from_company'  => 0,
                    'target'        => 'new_message',
                    'title'         => 'Попытка подключения...',
                    'content'       => "Невозможно установить соединение с сервером. Функционал ограничен!",
                    'url'           => '/',
                );
            ?>

            var template            = $('#mustache__notification').html();
            var output              = Mustache.render(template, <?php echo json_encode($noty_data);?> );
            var conncetNotyActive   = false;
            var connectNoty         = "";


            socket.on('connect', function() {

                conncetNotyActive   = false;
                socket.emit('channel', 'channel_<?php echo $this->session->user;?>');

                if( typeof connectNoty === 'object' ) connectNoty.close();

            });

            socket.on('connect_error', function() {

                if( conncetNotyActive == false ) {

                    connectNoty         = noty({
                        text        : 'bottomRight',
                        type        : 'alert',
                        dismissQueue: true,
                        layout      : 'bottomRight',
                        theme       : 'relax',
                        template    : output,
                        timeout     : false,
                        closeWith   : ['button'],
                        animation: {
                            open: {opacity: 'show'},
                            close: {opacity: 'hide'},
                            easing: 'linear',
                            speed:  300 // opening & closing animation speed
                        }

                    });

                    conncetNotyActive   = true;

                }


            });

            socket.on('disconnect', function(){

                connectNoty         = noty({
                    text        : 'bottomRight',
                    type        : 'alert',
                    dismissQueue: true,
                    layout      : 'bottomRight',
                    theme       : 'relax',
                    template    : output,
                    timeout     : false,
                    closeWith   : ['button'],
                    animation: {
                        open: {opacity: 'show'},
                        close: {opacity: 'hide'},
                        easing: 'linear',
                        speed:  300 // opening & closing animation speed
                    }
                });

                conncetNotyActive   = true;

            });

        })
    </script>

    <?php if(  !$this->User_model->is_auth_user()  ):?>
        <script src="/assets/ajax/ajax.js"></script>
    <?php endif;?>
    <!-- <script src="/assets/js/history.js-master/scripts/bundled/html4+html5/jquery.history.js"></script> -->

</head>
