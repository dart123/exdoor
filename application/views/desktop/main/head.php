<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.05.16
 * Time: 15:46
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
        <!--
        <link href="/assets/css/material.css" rel="stylesheet"  />
        <link href="/assets/css/roundslider.min.css" rel="stylesheet" />

        <link href="/assets/css/changes.css" rel="stylesheet" />

        <link rel="stylesheet" href="/assets/css/jquery.fancybox.css" media="screen" />
        <link rel="stylesheet" href="/assets/css/jquery.fancybox-thumbs.css" media="screen" />
        -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <![endif]-->






        <script>
            <?php if ( $this->router->user_lang == 'en' ):?>
                var page_lang   = 'en';
            <?php else:?>
                var page_lang   = 'ru';
            <?php endif;?>
        </script>
        <!--
        <script src="/assets/js/js-webshim/minified/polyfiller.js"></script>


        <script>
            webshim.activeLang('<?php echo $this->router->user_lang;?>');
            webshims.polyfill('forms');
            webshims.cfg.no$Switch = true;
        </script>
        -->




        <script src="/assets/js/desktop.js"></script>
        <?php if($is_home_page):?>
        <!--
            <link href="/assets/css/component.css" rel="stylesheet" />
            <script src="/assets/js/modernizr.custom.js"></script>
            <script src="/assets/js/classie.js"></script>
            <script src="/assets/js/modalEffects.js"></script>
-->
            <script>
                $(document).ready(function(){
                    /* Запускаем и скрываем видео на главной */
                    $('.header__exdor--play').click(function() {
                        <?php if($video_source == 'vimeo'):?>
                            $('.md-content').show().html('<iframe src="https://player.vimeo.com/video/<?php echo $video_id;?>?autoplay=1&color=eb4f1e&title=0&byline=0&portrait=0" width="800" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
                        <?php elseif($video_source == 'youtube'):?>
                            $('.md-content').show().html('<iframe width="800" height="450" src="https://www.youtube.com/embed/<?php echo $video_id;?>?rel=0&controls=0&showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
                        <?php endif;?>
                        setTimeout(function() {
                            $('.md-modal').addClass('md-show').fadeIn('slow');
                        }, 300);
                    });
                })
            </script>
        <?php endif;?>
    </head>