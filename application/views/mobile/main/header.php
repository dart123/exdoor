<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.04.2018
 * Time: 23:25
 */

?>

<body class="<?php if ( uri_string() && uri_string() != 'en' ):?>page__home<?php else:?>page__unauth<?php endif;?>">

<?php $this->load->view('mobile/misc/preloader');?>
    <aside class="sidebar">
        <header class="header__widget header-widget">
            <div class="header-widget__not-user not-user">
                <?php /*<img src="/assets__old/img/header__company--logo.png" class="not-user__logo"> */?>
                <a href="<?php echo $this->lang->line('url_lang_prefix');?>/" class="not-user__btns">
                    <span class="js-login-pass"><?php echo $this->lang->line('login');?></span> / <span class="js-confirm-pass"><?php echo $this->lang->line('registration');?></span>
                </a>
            </div>
        </header>

        <?php $this->load->view('mobile/main/menu', $page_footer);?>

    </aside>
    <div class="sidebar-cover"></div>

    <?php if ( uri_string() && uri_string() != 'en' ):?>

        <header class="header">
            <div class="container">
                <!-- блоки, видимые на мобильном -->
                <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>
                <div class="header__page-title t-hide"><?php if(array_key_exists("content", $page_content) && array_key_exists("title", $page_content["content"])) echo $page_content["content"]["title"];?></div>
                <div class="header__icons t-hide">
                    <?php /*
                    <div class="header__open-search js-search"><i class="fa fa-search" aria-hidden="true"></i></div>

                    <!-- есть 2 сообщения -->
                    <a href="index-msg.html" class="header__open-msg has-msg">
                        <span>2</span>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </a>
                    <!-- нет сообщений -->
                    <!--<a href="index-msg.html" class="header__open-msg">
                            <span></span>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </a> -->
                    */ ?>

                </div>

                <!-- блоки, видимые на планшете -->
                <a href="<?php echo $this->lang->line('url_lang_prefix');?>/">
                    <img src="/assets__old/img/header__company--logo.png" class="header__logo m-hide">
                </a>
                <div class="header__line m-hide">
                    <div class="header-widget__exchange-value">
                        <span class="">$ — <span class="exchange-value__dollar"><?php echo $page_header['usd'];?></span></span>
                        <span class="">€ — <span class="exchange-value__euro"><?php echo $page_header['eur'];?></span></span>
                    </div>
                    <a href="#header__converter" class="widget__convert    header-widget__convert">
                        <div class="header-widget__convert-icon">
                            <div><i class="fa fa-eur"></i><i class="fa fa-gbp"></i></div>
                            <div><i class="fa fa-usd"></i><i class="fa fa-rub"></i></div>
                        </div>
                    </a>
                    <a href="#header__calc"  class="widget__calc  header-widget__calc">
                        <i class="fa fa-calculator"></i>
                    </a>
                </div>

            </div>
        </header>

    <?php endif;?>
