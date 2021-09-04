<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.07.16
 * Time: 20:18
 */
?>
<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <!-- Контент -->
        <section class="page-content-form left-400">
            <div class="sub-menu is-mright-200">
                <ul class="sub-menu__list">
                    <li><a href="/profile" class="is-fade">Анкета</a></li>
                    <li><a href="/profile/company" class="is-fade">Моя компания</a></li>
                    <li><a class="active is-fade">Безопасность</a></li>
                    <li><a href="/profile/plan" class="is-fade">Тарифный план</a></li>
                </ul>
            </div>

            <div class="page-content-form__left">
                <!--  Блок Анкета  -->
                <div class="is-mtop-20">
                    <!--  Блок c формой анкеты  -->
                    <div class="security__block is-rounded is-box-shadow">
                        <form action="" class="security__form" method="post">
                            <input type="hidden" name="action" value="update_user_info">
                            <!-- Личная информация -->
                            <b class="security__form--title-sm">Настройка приватности</b>

                            <!--  -->
                            <label for="" class="security__line-label"><span>Моя страница</span>
                                <select name='security_page' id="" class="select-box <?php if($user->security_page == ''):?>is-placeholder<?php endif;?>">
                                    <option value="partners" <?php if($user->security_page == 'partners'):?>selected<?php endif;?>>Видна только партнерам</option>
                                    <option value="all" <?php if($user->security_page == 'all'):?>selected<?php endif;?>>Видна всем</option>
                                    <option value="me" <?php if($user->security_page == 'me'):?>selected<?php endif;?>>Видна только мне</option>
                                </select>
                            </label>
                            <!--  -->
                            <label for="" class="security__line-label"><span>Мои контакты</span>
                                <select name="security_contacts" id="" class="select-box <?php if($user->security_contacts == ''):?>is-placeholder<?php endif;?>">
                                    <option value="partners" <?php if($user->security_contacts == 'partners'):?>selected<?php endif;?>>Видны только партнерам</option>
                                    <option value="all" <?php if($user->security_contacts == 'all'):?>selected<?php endif;?>>Видны всем</option>
                                    <option value="me" <?php if($user->security_contacts == 'me'):?>selected<?php endif;?>>Видны только мне</option>
                                </select>
                            </label>
                            <!--  -->
                            <label for="" class="security__line-label"><span>Мои партнеры</span>
                                <select name="security_partners" id="" class="select-box <?php if($user->security_partners == ''):?>is-placeholder<?php endif;?>">
                                    <option value="all" <?php if($user->security_partners == 'all'):?>selected<?php endif;?>>Видны всем</option>
                                    <option value="me" <?php if($user->security_partners == 'me'):?>selected<?php endif;?>>Видны только мне</option>
                                </select>
                            </label>

                            <!-- Контактная информация -->
                            <b class="security__form--title-sm">Данные аккаунта</b>

                            <label class="security__line-label"><span>Телефон (логин)</span>
                                <div class="security__input">
                                    <div class="phone-in-use"><?php echo $this->phone->phone($user->phone);?></div>
                                    <input type="tel" class="security__input-sm phone-mask-with-code is-hidden" id="" placeholder="Укажите номер телефона" value="<?php echo $user->phone;?>">

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
                            <span class="my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                <input type="button" class="my-pers-profile__submit is-rounded profile__save_button__security" value="Сохранить">
                            </span>
                        </form>
                    </div>
                    <!-- -->
                </div>
            </div>

            <div class="page-content-form__right">
                <!-- Блок уведомлением -->
                <div class="security__photo is-mtop-20 material-block-show is-rounded">
                    <div class="security__helpers">
                        <div class="helpers-signs__content">
                            <i class="fa fa-shield"></i>

                            <span>Здесь Вы можете управлять настройками приватоности, а так же изменить номер телефона для доступа к сети exdor.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->
    </div>
</main>


<?php

    $this->load->view('desktop/profile/js/profile_secutiry_save');

    $this->load->view('desktop/profile/modal__change_login');
    $this->load->view('desktop/profile/mustache_template__change_login__place_code');
    $this->load->view('desktop/profile/mustache_template__change_login__new_phone');
    $this->load->view('desktop/profile/mustache_template__change_login__check_pass');
    $this->load->view('desktop/profile/js/profile_change_login');
