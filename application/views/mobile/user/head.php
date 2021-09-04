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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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

    <!--    Mobile Styles   -->
    <link href="/assets__old/css/mobile/app.css" rel="stylesheet" />
    <link href="/assets__old/css/mobile/bootstrap.css" rel="stylesheet" />
    <link href="/assets__old/css/mobile/material.css" rel="stylesheet" />

    <link rel="stylesheet" href="/assets__old/css/jquery.fancybox.css" media="screen" />
    <link rel="stylesheet" href="/assets__old/css/jquery.fancybox-thumbs.css" media="screen" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->



    <meta name="format-detection" content="telephone=no">


    <script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>

    <!-- <script src="/assets__old/js/jquery-1.9.1.min.js"></script> -->

    <script src="/assets__old/js/bootstrap.min.js"></script>
    <script src="/assets__old/js/jquery.maskedinput.min.js"></script>
    <script src="/assets__old/js/masonry.pkgd.min.js"></script>
    <script src="/assets__old/js/imagesloaded.pkgd.min.js"></script>
    <script src="/assets__old/js/jquery-ui.min.js"></script>
    <script src="/assets__old/js/jquery.touch.sortable.js"></script> <?php /* Сортировка на мобилках*/ ?>
    <script src="/assets__old/js/jquery.scrollbar.min.js"></script>
    <script src="/assets__old/js/roundslider.min.js"></script>


    <script src="/assets__old/js/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script src="/assets__old/js/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script src="/assets__old/js/jquery.fancybox-media.js?v=1.0.6"></script>
    <script src="/assets__old/js/jquery.fancybox-thumbs.js?v=1.0.7"></script>


    <script src="/assets__old/js/html5Forms.js"></script>

    <script src="/assets__old/js/mustache/mustache.min.js"></script>
    <script src="/assets__old/js/selectize.js-master/dist/js/standalone/selectize.min.js"></script>
    <link href="/assets__old/js/selectize.js-master/dist/css/selectize.css" rel="stylesheet" />
    <link href="/assets__old/css/component.css" rel="stylesheet" />


    <script type="text/javascript" src="/assets__old/js/noty/packaged/jquery.noty.packaged.js"></script>


    <script type="text/javascript" src="/assets__old/js/clipboard/clipboard.min.js"></script>
    <script type="text/javascript" src="/assets__old/js/buzz/buzz.min.js"></script>

    <!--
    <script src="/assets__old/js/js-webshim/minified/polyfiller.js"></script>
    <script>
        webshim.activeLang('en<?php /*echo $this->router->user_lang; */?>');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>
    -->
    <script src="/assets__old/js/sly.min.js"></script>
    <script src="/assets__old/js/horizontal.js"></script>
    <script src="/assets__old/js/global.js"></script>
    <script src="/assets__old/js/app.js"></script>

    <script src="/assets__old/js/socket.io/socket.io.js"></script>
    <script>
        <?php if ( $this->router->user_lang == 'en' ):?>
            var page_lang   = 'en';
        <?php else:?>
            var page_lang   = 'ru';
        <?php endif;?>

        var $ = jQuery.noConflict();
        $(document).ready( function () {
            socket = io.connect('https://exdor.ru');
            socket.emit('channel', 'channel_<?php echo $this->session->user;?>');
        })
    </script>
    <script src="/assets__old/ajax/jquery.autocomplete-min.js"></script>


    <!-- <script src="/assets__old/js/history.js-master/scripts/bundled/html4+html5/jquery.history.js"></script> -->

</head>
