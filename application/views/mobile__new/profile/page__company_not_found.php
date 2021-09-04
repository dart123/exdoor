<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.08.16
 * Time: 22:47
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
        <section class="page-content-form wide left-200">

            <?php $this->load->view('mobile/profile/submenu', array("active" => "company"));?>


                <div class="profile-company__container">
                    <?php if($page_content["company"]['short_name'] != '' && $page_content["company"]['inn'] != ''):?>
                        <p class="bold">По указанному ИНН <b><?php echo $page_content["company"]['inn'];?></b> найдена компания. Однако ее руководитель не зарегистрирован в Exdor</p>
                        <p class="is-mtop-10">Только руководитель организации может подтвердить факт того, что Вы являетесь сотрудником этой организации и можете общаться с партнерами от имени компании. До момента его регистрации Вы можете использовать партнерскую сеть Exdor как частное лицо.</p>

                        <p class="bold is-grey-text"><span>Извините за неудобства!</span></p>


                        <div class="profile-company__company_info   is-box-shadow is-rounded">

                            <div class="profile-company__company_info__logo">
                                <a href="#" class="company__image is-rounded">
                                    <i class="fa fa-home"></i>
                                </a>
                            </div>

                            <div class="profile-company__company_info__description">

                                <p class="bold">
                                    <?php echo $page_content["company"]['short_name'];?>
                                </p>
                                <p class="is-grey-text is-mtop-5"><span>Нет информации</span></p>

                            </div>
                        </div>


                        <div class="profile-company__company_owner">
                            Руководитель организации
                        </div>

                        <div class="profile-company__reminder   is-box-shadow is-rounded">
                            <div class="profile-company__reminder__container">
                                <a href="#send-mail" class="is-blue-link fancybox ">
                                    <i class="fa fa-envelope i-left-15"></i>
                                    <span>Пригласить руководителя</span>
                                </a>
                            </div>


                        </div>





                        <div class="profile-company__change_inn">
                            <a href="/profile/company?change_inn=true" class="is-or-link"><span>Изменить ИНН</span></a>
                        </div>


                        <div class="profile-company__bug-report">
                            <a href="#report" class="is-blue-link fancybox"><span>Нашли ошибку? Сообщите нам об этом</span></a>
                        </div>


                    <?php else:?>
                        <p class="bold is-mtop-30">По указанному ИНН компания не найдена</p>
                    <?php endif;?>
                </div>


        </section>
        <!-- Кнопка Наверх -->

        <?php
            $this->load->view('mobile/profile/modal__company__invite_director');
            $this->load->view('mobile/misc/modal__bug_report');
        ?>
    </div>


<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>


<?php
    $this->load->view('mobile/profile/js/functions');
    $this->load->view('mobile/profile/js__scripts');
    $this->load->view('mobile/profile/js/company_invite_director');
    $this->load->view('mobile/misc/js/bug_report');