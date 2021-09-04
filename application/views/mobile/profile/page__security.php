<?php
/**
 * Created by developer with PhpStorm.
 * Date: 08.09.2018 19:02
 *
 *
 */

?>



<body>

<?php $this->load->view('mobile/misc/preloader');?>
<aside class="sidebar">
    <?php
    $this->load->view('mobile/user/page__header', $page_content['menu']);
    $this->load->view('mobile/user/menu_user', $page_content['menu']);
    ?>
</aside>
<div class="sidebar-cover"></div>

<header class="header">
    <div class="container">
        <!-- блоки, видимые на мобильном -->
        <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>
        <div class="header__page-title t-hide">Профиль</div>
        <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
    </div>
</header>

<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>

<div class="content">

    <!-- Контент -->
    <?php $this->load->view('mobile/profile/submenu', array("active" => "security"));?>


    <div class="page-content-form__left">
        <!--  Блок Анкета  -->

            <!--  Блок c формой анкеты  -->
            <div class="security__block">
                <form action="" class="security__form" method="post">
                    <input type="hidden" name="action" value="update_user_info">
                    <!-- Личная информация -->
                    <b class="security__form--title-sm">Настройка приватности</b>

                    <!--  -->
                    <label for="" class="security__line-label"><span>Моя страница</span>
                        <select name='security_page' id="" class="select select-box <?php if($page_content["user"]->security_page == ''):?>is-placeholder<?php endif;?>">
                            <option value="partners" <?php if($page_content["user"]->security_page == 'partners'):?>selected<?php endif;?>>Видна только партнерам</option>
                            <option value="all" <?php if($page_content["user"]->security_page == 'all'):?>selected<?php endif;?>>Видна всем</option>
                            <option value="me" <?php if($page_content["user"]->security_page == 'me'):?>selected<?php endif;?>>Видна только мне</option>
                        </select>
                    </label>
                    <!--  -->
                    <label for="" class="security__line-label"><span>Мои контакты</span>
                        <select name="security_contacts" id="" class="select select-box <?php if($page_content["user"]->security_contacts == ''):?>is-placeholder<?php endif;?>">
                            <option value="partners" <?php if($page_content["user"]->security_contacts == 'partners'):?>selected<?php endif;?>>Видны только партнерам</option>
                            <option value="all" <?php if($page_content["user"]->security_contacts == 'all'):?>selected<?php endif;?>>Видны всем</option>
                            <option value="me" <?php if($page_content["user"]->security_contacts == 'me'):?>selected<?php endif;?>>Видны только мне</option>
                        </select>
                    </label>
                    <!--  -->
                    <label for="" class="security__line-label"><span>Мои партнеры</span>
                        <select name="security_partners" id="" class="select select-box <?php if($page_content["user"]->security_partners == ''):?>is-placeholder<?php endif;?>">
                            <option value="all" <?php if($page_content["user"]->security_partners == 'all'):?>selected<?php endif;?>>Видны всем</option>
                            <option value="me" <?php if($page_content["user"]->security_partners == 'me'):?>selected<?php endif;?>>Видны только мне</option>
                        </select>
                    </label>

                    <!-- Контактная информация -->
                    <b class="security__form--title-sm">Данные аккаунта</b>

                    <label class="security__line-label"><span>Логин</span>
                        <div class="security__input profile-form__padding_container">
                            <div class="phone-in-use"><?php echo $this->phone->phone($page_content["user"]->phone);?></div>
                            <input type="tel" class="input__type-text security__input-sm phone-mask-with-code is-hidden" id="" placeholder="Укажите номер телефона" value="<?php echo $page_content["user"]->phone;?>">

                            <a href="" class="is-or-link profile__change_login"><span>Изменить</span></a>
                        </div>
                    </label>
                    <!--  -->
                    <?php /*
                            <label for="" class="security__line-label"><span>Email</span>
                                <input type="email" class="my-pers-profile__input" id="" value="<?php if($user->email) echo $user->email;?>" placeholder="По нему мы сможем восстановить Ваш доступ">
                            </label>
                            <!--  -->
                            */ ?>

                    <div class="clear"></div>
                    <div class="text-right">
                        <span class="my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="button" class="my-pers-profile__submit is-rounded profile__save_button__security button__default" value="Сохранить">
                        </span>
                    </div>

                </form>
            </div>
            <!-- -->

    </div>

</div>


<?php

    $this->load->view('mobile/profile/js/profile_secutiry_save');

    $this->load->view('mobile/profile/modal__change_login');
    $this->load->view('mobile/profile/mustache_template__change_login__place_code');
    $this->load->view('mobile/profile/mustache_template__change_login__new_phone');
    $this->load->view('mobile/profile/mustache_template__change_login__check_pass');
    $this->load->view('mobile/profile/js/profile_change_login');
