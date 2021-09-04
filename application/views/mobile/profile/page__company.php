<?php
/**
 * Created by developer with PhpStorm.
 * Date: 08.09.2018 19:35
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

            <?php $this->load->view('mobile/profile/submenu', array("active" => "company"));?>
            <!--  Блок Анкета  -->



            <div class="profile-company__container">
                <p class="bold is-mtop-30">Ваш профиль не связан ни с одной компанией</p>
                <p class="is-mtop-10">Чтобы изменить это, укажите ИНН вашей организации</p>









                <form action="/profile/add_company" id="profile__company__form__add_company    is-mtop-30" method="POST">

                    <input type="hidden" name="action" value="add_company_step_1">

                    <input id="input-company-fullname" name="full_name" type="hidden">
                    <input id="input-company-shortname" name="short_name" type="hidden">
                    <input id="input-company-inn" name="inn" type="hidden">
                    <input id="input-company-kpp" name="kpp" type="hidden">
                    <input id="input-company-ogrn" name="ogrn" type="hidden">
                    <input id="input-company-address" name="address" type="hidden">
                    <input id="input-company-manager" name="manager" type="hidden">
                    <input id="input-company-manager-post" name="manager_post" type="hidden">
                    <input id="input-company-type" name="company_type" type="hidden">

                    <input name="user_id" type="hidden" value="<?php echo $page_content["user"]->id;?>">

                    <div class="profile-company__inn-input">
                        <input type="text" class="input__type-text my-company-profile__input" id="dadata_input_field__inn" placeholder="ИНН организации">
                    </div>






                    <div class="profile-company__role-input">

                        <div>
                            <input type="radio" class="radio" name="my-company-role" id="im-employee" value="worker" checked>
                            <label class="radio__label" for="im-employee">Я &mdash; сотрудник</label>
                        </div>

                        <div class="is-mtop-5">
                            <input type="radio" class="radio" name="my-company-role" id="im-director" value="manager">
                            <label class="radio__label" for="im-director">Я &mdash; руководитель</label>
                        </div>


                    </div>

                    <div class="clear"></div>

                    <div class="block__footer text-center is-mtop-30">
                        <button type="submit" class="button__default my-company-profile__submit btn-primary2 btn ripple-effect   is-mtop-30" disabled>Продолжить</button>
                    </div>
                </form>




            </div>





        </div>








<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
$this->load->view('mobile/profile/js/functions');
$this->load->view('mobile/profile/js__scripts');
