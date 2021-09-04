<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.16
 * Time: 0:44
 */
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if ($is_home_page):?>
    <body class="main-page">
        <!-- Preloader -->
        <div id="preloader">
            <img src="/assets/img/preload.gif" alt="" id="preloader__img">
        </div>
        <!-- Video modal window -->
        <div class="md-modal md-effect-16" id="modal-16">
            <div class="md-content">
            </div>
        </div>

        <div class="video-cover">
            <header>
<?php else:?>
    <body class="guest-view unauth-view">
        <div class="preloader">
            <img src="/assets/img/preload.gif" alt="" class="preloader__img">
        </div>
        <header class="info-page__header">
<?php endif;?>

            <!-- Header bar -->
            <div class="header__topbar">
                <div class="container">
                    <div class="header__company">
                        <a href="<?php echo $this->lang->line('url_lang_prefix');?>/">
                            <img src="/assets/img/header__company--logo.png" alt="">
                            <div><?php echo $this->lang->line('title_line_1');?><br/><?php echo $this->lang->line('title_line_2');?></div>
                        </a>
                    </div>
                    <div class="header__user-panel">
                        <form action="/auth" method="POST" class="js-header-auth user-auth__form">

                            <?php if( $this->session->userdata('unblock') ):?>
                                <input type="hidden" id="login_unblock_time" value="<?php echo $this->session->userdata('unblock');?>">
                                <input type="hidden" id="login_block_time"   value="<?php echo time();?>">
                            <?php endif;?>


                            <input type="hidden" name="action" value="auth-reg">
                            <div class="user-city__wrap">
                                <select class="user-city" id="selected-head" required name="phone-code">
                                    <option value="+994">+994 (<?php echo $this->lang->line('country_AZ');?>)</option>
                                    <option value="+374">+374 (<?php echo $this->lang->line('country_AR');?>)</option>
                                    <option value="+375">+375 (<?php echo $this->lang->line('country_BY');?>)</option>
                                    <option value="+7">+7 (<?php echo $this->lang->line('country_KZ');?>)</option>
                                    <option value="+996">+996 (<?php echo $this->lang->line('country_KR');?>)</option>
                                    <option value="+373">+373 (<?php echo $this->lang->line('country_ML');?>)</option>
                                    <option selected value="+7">+7 (<?php echo $this->lang->line('country_RU');?>)</option>
                                    <option value="+992">+992 (<?php echo $this->lang->line('country_TJ');?>)</option>
                                    <option value="+993">+993 (<?php echo $this->lang->line('country_TR');?>)</option>
                                    <option value="+998">+998 (<?php echo $this->lang->line('country_UZ');?>)</option>
                                    <option value="+380">+380 (<?php echo $this->lang->line('country_UA');?>)</option>
                                </select>
                                <select id="tmp-select">
                                    <option id="tmp-option"></option>
                                </select>
                            </div>
                            <input type="tel" id="selected-head-number" name="phone-number" class="user-phone-num" placeholder="<?php echo $this->lang->line('phone_number');?>" inputmode="numeric" required="true">

                            <span class="is-over-submit btn ripple-effect btn-default is-rounded">
                                <input type="submit" class="user-reg-submit btn btn-default is-rounded    js-ajax__auth" id="" value="<?php echo $this->lang->line('login');?> / <?php echo $this->lang->line('registration');?>">
                            </span>
                            <a href="#modal__auth" class="modal__auth fancybox" style="display: none"></a>
                        </form>
                    </div>
                </div>
            </div>
            <?php if($is_home_page):?>
                <!-- Header -->
                <div class="header__main">
                    <div class="container">
                        <ul class="header__project-about">
                            <?php $this->load->view('desktop/misc/guest__html__menu', $menu);?>
                        </ul>
                        <div class="header__exdor">
                            <div class="row">
                                <h1><img src="/assets/img/header__exdor.png" alt="<?php echo $this->lang->line('title_line_1');?> <?php echo $this->lang->line('title_line_2');?>" title="<?php echo $this->lang->line('title_line_1');?> <?php echo $this->lang->line('title_line_2');?>"></h1>
                                <div class="header__exdor--show">
                                    <a href="#" class="header__exdor--play md-trigger is-fade" data-modal="modal-16"><i class="fa fa-play"></i></a>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="exdor-presentation is-fade"><?php echo $this->lang->line('service_presentation');?></a>
                        </div>
                        <div class="header__promo-space">
                            <img src="/assets/img/promo-space__bg.png" class="promo-space__bg" alt="">
                            <div class="promo-space__cover">
                                <img src="/assets/img/promo-space__logo.png" alt="">
                                <div><?php echo $this->lang->line('ads');?></div>
                            </div>
                            <a href="#" class="promo-space__more or-btn btn btn-info ripple-effect"><?php echo $this->lang->line('detail');?></a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        </header>

        <div class="preloader">
            <img src="/assets/img/preload.gif" alt="" class="preloader__img">
        </div>