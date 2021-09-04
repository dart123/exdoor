<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.07.16
 * Time: 23:40
 */

?>

<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>

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
                    <li><a class="active is-fade">Анкета</a></li>
                    <li><a href="/profile/company" class="is-fade">Моя компания</a></li>
                    <li><a href="/profile/security" class="is-fade">Безопасность</a></li>
                    <li><a href="/profile/plan" class="is-fade">Тарифный план</a></li>
                </ul>
            </div>
            <div class="page-content-form__left">
                <!--  Блок Анкета  -->
                <div class="is-mtop-20">
                    <!--  Блок c формой анкеты  -->
                    <div class="my-pers-profile__block is-rounded is-box-shadow">
                        <form action="" class="my-pers-profile__form profile__save_form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                            <input type="hidden" name="action" value="update_user_info">
                            <!-- Личная информация -->
                            <b class="my-pers-profile__form--title-sm">Личная информация</b>

                            <label for="" class="my-pers-profile__line-label "><span>Имя</span>
                                <input name="name" type="text" class="my-pers-profile__input" id="" placeholder="Владимир" value="<?php if($user->name) echo $user->name;?>" required>
                            </label>
                            <!--  -->
                            <label for="" class="my-pers-profile__line-label "><span>Фамилия</span>
                                <input name="last_name" type="text" class="my-pers-profile__input" id="" placeholder="Володин" value="<?php if($user->last_name) echo $user->last_name;?>" required>
                            </label>
                            <!--  -->
                            <label for="" class="my-pers-profile__line-label "><span>Отчество</span>
                                <input name="second_name" type="text" class="my-pers-profile__input" id="" placeholder="Владмимирович" value="<?php if($user->second_name) echo $user->second_name;?>">
                            </label>
                            <!--  -->

                            <label for="" class="my-company-profile__line-label my-company-profile__chk"><span>Направление деятельности</span>
                                <div class="my-pers-profile__input">
                                    <div>
                                        <input type="checkbox" class="show__checkbox" id="com-type-1" name="direction_sell" value="sell" <?php echo( $user->direction == 'sell' || $user->direction == 'all' ) ? 'checked' : '';?>>
                                        <label class="show__label-c" for="com-type-1">Продавец</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" class="show__checkbox" id="com-type-2" name="direction_buy" value="buy" <?php echo( $user->direction == 'buy' || $user->direction == 'all' ) ? 'checked' : '';?>>
                                        <label class="show__label-c" for="com-type-2">Покупатель</label>
                                    </div>
                                </div>
                            </label>

                            <div class="my-company-profile__line-label is-mtop-10">
                                <span>Производители<br>реализуемой техники</span>

                                <div class="my-company-profile__input check-group__block">

                                    <select id="js__select__brand_tags" name="brand[]" multiple class="demo-default" placeholder="Выберите производителей" required>
                                        <?php foreach($brands as $brand):?>
                                            <?php if( $brand->id != 0 ): /* Не указан */?>
                                                <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"  <?php echo ( array_key_exists($brand->id, $user_brands) )? 'selected' :'';?>><?php echo $brand->value;?></option>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </select>

                                </div>
                                <div style="clear: both"></div>
                            </div>

                            <?php /*

                            <label for="" class="my-pers-profile__line-label "><span>Должность</span>
                                <select name="profession_id" class="select-box <?php if($user->profession == ''):?>is-placeholder<?php endif;?>">
                                    <option value="0" selected>Выберите из списка</option>
                                    <?php foreach($professions as $profession):?>
                                        <option value="<?php echo $profession->id;?>" <?php if($user->profession == $profession->id):?>selected<?php endif;?>>
                                            <?php echo $profession->value;?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </label>-->
                            <!--  -->
                            */ ?>

                            <input id="js-input-city-hidden" type="hidden" name="city" value="<?php echo $user->city_id;?>">

                            <label for="" class="my-pers-profile__line-label "><span>Населенный пункт</span>
                                <input name="t_city" type="text" class="my-pers-profile__input" id="js-autocomplete-city__profile" placeholder="Москва" value="<?php echo $user->city;?>" required>
                            </label>


                            <!-- Контактная информация -->
                            <b class="my-pers-profile__form--title-sm">Контактные данные</b>

                            <label for="" class="my-pers-profile__line-label profile-show-in-contact"><span>Телефон</span>
                                <div class="my-pers-profile__input">
                                    <input name="contact_phone" type="tel" class="my-pers-profile__input-sm phone-mask-with-code" id="" value="<?php if($user->contact_phone) echo $user->contact_phone;?>" placeholder="Ваш номер">

                                    <div class="my-pers-profile__show">
                                        <input name="show_phone" type="checkbox" class="show__checkbox" id="show-in-contact" value="1" <?php if($user->show_phone == 1):?>checked<?php endif;?>>
                                        <label class="show__label-c" for="show-in-contact">Показывать в контактах</label>
                                    </div>
                                </div>

                            </label>
                            <!--  -->
                            <label for="" class="my-pers-profile__line-label "><span>E-mail</span>
                                <input name="email" type="email" class="my-pers-profile__input" id="" value="<?php if($user->email) echo $user->email;?>" placeholder="myname@domain.ru">
                            </label>
                            <!--  -->
                                <span class="my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                    <input type="button" class="my-pers-profile__submit is-rounded profile__save_button" value="Сохранить">
                                </span>
                            <input type="file" name="avatar" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" class="ajax-upload-avatar-profile" id="choose-portrait-img">
                        </form>
                    </div>
                    <!-- -->
                </div>
            </div>

            <div class="page-content-form__right">
                <!-- Блок с загрузкой фото -->

                <div class="my-pers-profile__photo is-mtop-20 is-rounded" <?php if ($user->avatar):?> style="background: url('/uploads/users/<?php echo $user->id;?>/avatar/180x180_<?php echo $user->avatar;?>') no-repeat center center"<?php endif;?>>
                    <div class="my-pers-profile__space"></div>


                    <label for="choose-portrait-img" class="is-blue-link my-pers-profile__helpers helpers-signs pointer">
                        <div class="helpers-signs__content">
                            <?php if (!$user->avatar):?>
                                <div class="helpers-signs__icons">
                                    <i class="fa fa-user"></i>
                                </div>
                                <span>Изменить аватар</span>
                            <?php endif;?>
                        </div>
                    </label>


                    <div class="is-mtop-20">
                        <a class="is-or-link pointer js__remove_avatar <?php if( !$user->avatar ):?>is-hidden<?php endif;?>" data-action="remove_avatar" data-user_id="<?php echo $this->session->user;?>"><span>Удалить аватар</span></a>
                    </div>



                </div>
            </div>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->
    </div>
</main>




<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
$this->load->view('desktop/profile/js/functions');
$this->load->view('desktop/profile/js/profile_validation');
$this->load->view('desktop/profile/js__scripts');
?>
