<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.04.2018
 * Time: 20:10
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
    <?php $this->load->view('mobile/profile/submenu', array("active" => "main"));?>


    <section class="page-content-form left-400">
        <div class="page-content-form__left">
            <!--  Блок Анкета  -->

                <!--  Блок c формой анкеты  -->
                <div class="my-pers-profile__block">
                    <form autocomplete="off" action="" class="my-pers-profile__form profile__save_form" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                        <input type="hidden" name="action" value="update_user_info">
                        <!-- Личная информация -->
                        <b class="my-pers-profile__form--title-sm">Личная информация</b>

                        <div style="position:absolute; top: 20px; right: 10px;" >
                            <a href="#" class="btn btn-info2 is-rounded      js__change_avatar__trigger" >
                                <span>Изменить аватар</span> <i class="fa fa-user"></i>
                            </a>
                        </div>
                        <input style="opacity: 0" type="file" name="avatar" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" class="ajax-upload-avatar-profile" id="choose-portrait-img">

                        <script>
                            $(document).ready( function () {
                                $(".js__change_avatar__trigger").click( function (e) {
                                    e.preventDefault();
                                    $("#choose-portrait-img").trigger("click");
                                })
                            })
                        </script>

                        <label for="" class="my-pers-profile__line-label "><span>Имя</span>
                            <input name="name" type="text" class="input__type-text my-pers-profile__input" id="" placeholder="Владимир" value="<?php if($page_content["user"]->name) echo $page_content["user"]->name;?>" required>
                        </label>
                        <!--  -->
                        <label for="" class="my-pers-profile__line-label "><span>Фамилия</span>
                            <input name="last_name" type="text" class="input__type-text my-pers-profile__input" id="" placeholder="Володин" value="<?php if($page_content["user"]->last_name) echo $page_content["user"]->last_name;?>" required>
                        </label>
                        <!--  -->
                        <label for="" class="my-pers-profile__line-label "><span>Отчество</span>
                            <input name="second_name" type="text" class="input__type-text my-pers-profile__input" id="" placeholder="Владмимирович" value="<?php if($page_content["user"]->second_name) echo $page_content["user"]->second_name;?>">
                        </label>
                        <!--  -->

                        <label for="" class="my-company-profile__line-label my-company-profile__chk"><span>Направление <span class="m-hide">деятельности</span> </span>
                            <div class="my-pers-profile__input profile-form__checkbox_container">
                                <div>
                                    <input type="checkbox" class="show__checkbox" id="com-type-1" name="direction_sell" value="sell" <?php echo( $page_content["user"]->direction == 'sell' || $page_content["user"]->direction == 'all' ) ? 'checked' : '';?>>
                                    <label class="show__label-c" for="com-type-1">Продавец</label>
                                </div>
                                <div>
                                    <input type="checkbox" class="show__checkbox" id="com-type-2" name="direction_buy" value="buy" <?php echo( $page_content["user"]->direction == 'buy' || $page_content["user"]->direction == 'all' ) ? 'checked' : '';?>>
                                    <label class="show__label-c" for="com-type-2">Покупатель</label>
                                </div>
                            </div>
                        </label>

                        <div class="my-company-profile__line-label is-mtop-10">
                            <span>Производители</span>

                            <div class="my-company-profile__input check-group__block">

                                <select id="js__select__brand_tags" data-class="select" name="brand[]" multiple class="demo-default" placeholder="Выберите производителей" required>
                                    <?php foreach($page_content["brands"] as $brand):?>
                                        <?php if( $brand->id != 0 ): /* Не указан */?>
                                            <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"  <?php echo ( array_key_exists($brand->id, $page_content["user_brands"]) )? 'selected' :'';?>><?php echo $brand->value;?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>

                            </div>
                            <div style="clear: both"></div>
                        </div>

<?php /*
                            <label for="" class="my-pers-profile__line-label "><span>Должность</span>
                                <select name="profession_id" class="select select-box <?php if($page_content["user"]->profession == ''):?>is-placeholder<?php endif;?>">
                                    <option value="0" selected>Выберите из списка</option>
                                    <?php foreach($page_content["professions"] as $profession):?>
                                        <option value="<?php echo $profession->id;?>" <?php if($page_content["user"]->profession == $profession->id):?>selected<?php endif;?>>
                                            <?php echo $profession->value;?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </label>

*/?>

                        <input id="js-input-city-hidden" type="hidden" name="city" value="<?php echo $page_content["user"]->city_id;?>">

                        <label for="" class="my-pers-profile__line-label "><span>Город</span>
                            <input name="t_city" type="text" class="input__type-text my-pers-profile__input" id="js-autocomplete-city__profile" placeholder="Москва" value="<?php echo $page_content["user"]->city;?>" required>
                        </label>


                        <!-- Контактная информация -->
                        <b class="my-pers-profile__form--title-sm">Контактные данные</b>

                        <label for="" class="my-pers-profile__line-label profile-show-in-contact"><span>Телефон</span>
                            <div class="my-pers-profile__input">
                                <input name="contact_phone" type="tel" class="input__type-text my-pers-profile__input-sm phone-mask-with-code" id="" value="<?php if($page_content["user"]->contact_phone) echo $page_content["user"]->contact_phone;?>" placeholder="Ваш номер">

                                <div class="my-pers-profile__show profile-form__checkbox_container">
                                    <input name="show_phone" type="checkbox" class="show__checkbox" id="show-in-contact" value="1" <?php if($page_content["user"]->show_phone == 1):?>checked<?php endif;?>>
                                    <label class="show__label-c" for="show-in-contact">Показывать в контактах</label>
                                </div>
                            </div>

                        </label>
                        <div class="clear"></div>
                        <!--  -->
                        <label for="" class="my-pers-profile__line-label "><span>E-mail</span>
                            <input name="email" type="email" class="input__type-text my-pers-profile__input" id="" value="<?php if($page_content["user"]->email) echo $page_content["user"]->email;?>" placeholder="myname@domain.ru">
                        </label>
                        <!--  -->
                        <div class="text-right">
                            <span class="my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                <input type="button" class="button__default my-pers-profile__submit is-rounded profile__save_button" value="Сохранить">
                            </span>
                        </div>



                    </form>
                </div>
                <!-- -->

        </div>


        <!-- Кнопка Подгружаю еще -->
    </section>








</div>



<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
$this->load->view('mobile/profile/js/functions');
$this->load->view('mobile/profile/js/profile_validation');
$this->load->view('mobile/profile/js__scripts');
