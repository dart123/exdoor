<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 15:50
 */
?>



<body <?php if(isset($dialog_page) && $dialog_page === true):?>class="dialog-page"<?php else:?>class="page-content-form__wrap"<?php endif;?>>
    <header>
        <div class="header__bar">
            <div class="container">
                <div class="header__logo--wrap">
                    <a href="/" class="header__logo">
                        <img src="/assets/img/header__logo.png" alt="">
                    </a>
                </div>
                <!-- Поиск
                <form action="search" class="widget__search--wrap is-fade" method="get" id="">
                    <input type="search" class="widget__search is-rounded" autocomplete="off" placeholder="Поиск по партнёрам и компаниям"/>

                    <input type="submit" class="widget__submit" value="" title="Начать поиск">
                    <span class="search--active-cls" style="display: none"><i class="fas fa-times"></i></span>
                </form>
                -->

                <div class="header__user-panel">
                    <form action="/auth" method="POST" class="js-header-auth user-auth__form" style="margin-top: 10px !important;">

                        <?php if( $this->session->userdata('unblock') ):?>
                            <input type="hidden" id="login_unblock_time" value="<?php echo $this->session->userdata('unblock');?>">
                            <input type="hidden" id="login_block_time"   value="<?php echo time();?>">
                        <?php endif;?>


                        <input type="hidden" name="action" value="auth-reg">
                        <div class="user-city__wrap">
                            <select class="user-city" id="selected-head"required name="phone-code">
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
    </header>
