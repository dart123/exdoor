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
    <?php $this->load->view('mobile/profile/submenu', array("active" => "plan"));?>

    <div class="page-content-form__left">
        <!--  Блок тарифа  -->

        <!--  Левый блок с информацией о тарифе  -->
        <div class="solution-about__block" style="padding: 10px;">

            <div style="float: right" class="text-right">

                <p style="font-weight: bold; font-size: 1.5em"><?php echo $page_content["user"]->balance;?> <small><i class="fa fa-rub"></i></small> </p>

                <p class="is-mtop-5">
                    <a href="#plans__invoice" class="fancybox is-blue-link">
                        <i class="fa fa-money"></i>
                        <span>Пополнить</span>
                    </a>
                </p>
                <p class="is-mtop-5">
                    <a href="#plans__tarif__payment_history" class="fancybox is-blue-link">
                        <i class="fa fa-history"></i>
                        <span>Платежи</span>
                    </a>
                </p>
            </div>
            <div class="solution-about__name">
                <b>
                    <?php
                    switch ( $page_content["user"]->tarif ) {
                        case "free";
                            echo "На пробу";
                            break;
                        case "premium_user":
                            echo "Премиум &mdash; Пользователь";
                            break;
                        case "premium_company":
                            echo "Премиум &mdash; Компания";
                            break;
                    }
                    ?>

                </b></div>
                <div class="solution-about__price"><?php if( $page_content["user"]->tarif == 'free'):?>бесплатно<?php endif;?> <span class="is-grey-text">(осталось <?php echo $page_content["user"]->tarif_days_left;?> дн.)</span> </div>
                <p class="is-mtop-5">
                    <a href="#plans__tarif__<?php echo $page_content["user"]->tarif;?>" class="fancybox solution-about__more is-blue-link"><span>информация о тарифе</span></a>
                </p>





            <div class="solution-descr__block is-mtop-30">
                <div class="solution-descr__title"><b>Подберите тариф</b></div>
                <div class="solution-descr__choose is-mtop-20">
                    <div class="solution-descr__name">
                        <b>Премиум &mdash; Пользователь</b>
                        <p class="is-mtop-5">
                            <a href="#plans__tarif__premium_user" class="fancybox solution-about__more is-blue-link"><span>информация о тарифе</span></a>
                        </p>
                    </div>
                    <div class="solution-descr__price">
                        <div class="is-mtop-5">
                            <input type="radio" class="radio" name="premium_user" id="solution-premium_fiz-01"  value="mounthly">
                            <label class="radio__label" for="solution-premium_fiz-01">1 000 <i class="fa fa-rub"></i> / мес</label>
                        </div>

                        <div class="is-mtop-5">
                            <span class="solution-best">
                                <input type="radio" class="radio" name="premium_user" id="solution-premium_fiz-02" checked  value="yearly">
                                <label class="radio__label" for="solution-premium_fiz-02">10 000 <i class="fa fa-rub"></i> / год</label>
                            </span>
                            <span class="solution-info">дешевле на 2 000 <i class="fa fa-rub"></i></span>
                        </div>
                    </div>

                    <?php if ( $page_content["user"]->tarif != "premium_user" ):?>
                        <div class="solution__change is-mtop-10 text-right">
                            <a href="#" class="or-btn btn btn-info ripple-effect btn-block       js__change_tarif__modal" data-type="user">Сменить тариф</a>
                        </div>
                    <?php else:?>
                        <div class="solution__change is-mtop-10 text-right">
                            <span class="or-btn btn btn-info btn-block disabled">Это ваш тариф</span>
                        </div>
                    <?php endif;?>
                </div>



                <div class="solution-descr__choose is-mtop-20">
                    <div class="solution-descr__name">
                        <b>Премиум &mdash; Компания</b>
                        <p class="is-mtop-5">
                            <a href="#plans__tarif__premium_company" class="fancybox solution-about__more is-blue-link"><span>информация о тарифе</span></a>
                        </p>
                    </div>
                    <div class="solution-descr__price">
                        <div class="is-mtop-5">
                            <input type="radio" class="radio" name="premium_company" id="solution-premium_company-01" value="mounthly">
                            <label class="radio__label" for="solution-premium_company-01">2 000 <i class="fa fa-rub"></i> / мес</label>
                        </div>
                        <div class="is-mtop-5">
                            <span class="solution-best">
                                <input type="radio" class="radio" name="premium_company" id="solution-premium_company-02" checked value="yearly">
                                <label class="radio__label" for="solution-premium_company-02">20 000 <i class="fa fa-rub"></i> / год</label>
                            </span>
                            <span class="solution-info">дешевле на 4 000 <i class="fa fa-rub"></i> </span>
                        </div>
                    </div>

                    <?php if ( $page_content["user"]->tarif != "premium_company" ):?>
                        <div class="solution__change is-mtop-10 text-right">
                            <a href="#" class="or-btn btn btn-info ripple-effect btn-block       js__change_tarif__modal" data-type="company">Сменить тариф</a>
                        </div>
                    <?php else:?>
                        <div class="solution__change is-mtop-10 text-right">
                            <span class="or-btn btn btn-info btn-block disabled">Это ваш тариф</span>
                        </div>
                    <?php endif;?>
                </div>
            </div>

        </div>


        <!-- -->

    </div>











    <!--  Подверждение  -->
    <div id="change_plan" class="modal  modal--middle">
        <div class="modal__head modal__head--blue">
            <div class="modal__title">Сменить тариф?</div>
        </div>

        <div class="modal-body" style="background: #fff;">

            <p>После того, как Вы подтвердите действие, мы мгновенно переведем Вас на новый тариф и спишем с баланса указаную стоимость.</p>
            <div class="confirm__block center is-mtop-20">
                <a href="#" data-type="" data-period=""  class="btn bl-btn is-rounded     js__change_plan">
                    <i class="fa fa-check"></i>
                    <span>Да</span>
                </a>

                <a href="#" class="btn-inline    confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                    <i class="fa fa-times"></i>
                    <span>Нет</span>
                </a>
            </div>

        </div>
    </div>
    <!-- end Подверждение -->


</div>


<?php
    $this->load->view('mobile/profile/modal__plans__invoice');
    $this->load->view('mobile/profile/modal__plans__check_download');
    $this->load->view('mobile/profile/modal__plans__payment_history');

    $this->load->view('mobile/profile/modal__plans__tarif__free');
    $this->load->view('mobile/profile/modal__plans__tarif__premium_user');
    $this->load->view('mobile/profile/modal__plans__tarif__premium_company');

    $this->load->view('mobile/profile/js/profile_tarif');