<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-04
 * Time: 14:56
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


    <div class="content">

        <!-- Контент -->
        <section class="page-content-form wide left-200">

            <?php $this->load->view('mobile/profile/submenu', array("active" => "company"));?>


            <div class="page-content-form__left   profile-company__container">
                <!--  Блок Результаты поиска компании  -->
                <div class="my-company-search is-mtop-20">

                    <div class="my-company-search__title--high">
                        <p class="bold">
                            Руководитель <a href="/company/id<?php echo $page_content["company"]->id;?>" target="_blank" class="is-blue-link"><span><?php echo $page_content["company"]->short_name;?></span></a> еще не подтвердил, что Вы являетесь сотрудником компании
                        </p>
                        <p class="is-mtop-5">При личной встрече подскажите шефу, что добавить Вас можно в разделе "Моя компания" через список сотрудников ;-)</p>
                    </div>


                    <div class="is-mtop-20">

                        <div class="profile-company__company_info   is-box-shadow is-rounded">

                            <div class="profile-company__company_info__logo">
                                <?php if($page_content["company"]->logo):?>
                                    <a href="/company/id<?php echo $page_content["company"]->id;?>" class="company__image is-rounded">
                                        <img src="/uploads/companies/<?php echo $page_content["company"]->id;?>/logo/180_<?php echo $page_content["company"]->logo;?>" alt="">
                                    </a>
                                <?php else:?>
                                    <a href="/company/id<?php echo $page_content["company"]->id;?>" class="company__image is-rounded">
                                        <i class="fa fa-home"></i>
                                    </a>
                                <?php endif;?>
                            </div>

                            <div class="profile-company__company_info__title">
                                <?php echo $page_content["company"]->short_name;?>

                                <?php
                                $type   = false;
                                $city   = false;
                                if( $page_content["company"]->type ):
                                    switch( $page_content["company"]->type ) {
                                        case "sell":
                                            $type   = "Продающая компания";
                                            break;
                                        case "buy":
                                            $type   = "Покупающая компания";
                                            break;
                                        case "all":
                                            $type   = "Покупающая и продающая компания";
                                            break;
                                    }
                                endif;
                                if( $page_content["company"]->city_name ):
                                    $city   = $page_content["company"]->city_name;
                                endif;?>

                                <?php if( $type ):?>
                                    <p class="is-grey-text">
                                        <span><?php echo $type;?></span>
                                    </p>
                                <?php endif;?>
                                <?php if( $city ):?>
                                    <p class="is-grey-text">
                                        <span><?php echo $city;?></span>
                                    </p>
                                <?php endif;?>
                            </div>

                            <div class="profile-company__company_info__description">

                                <?php if( $page_content["company"]->rating ):?>
                                    <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $page_content["company"]->rating;?>"></div>
                                <?php endif;?>

                                <?php echo $page_content["company"]->count_employers." ".$page_content["company"]->count_employers_text;?>

                            </div>
                        </div>


                        <div class="profile-company__company_owner">
                            Руководитель организации
                        </div>

                        <div class="profile-company__reminder   is-box-shadow is-rounded">
                            <div class="profile-company__reminder__container">
                                <a href="#" class="is-blue-link send-remind">
                                    <i class="fa fa-bell i-left-15"></i>
                                    <span>Напомнить о заявке</span>
                                </a>
                                <span href="#" class="is-grey-text is-long-row is-hidden">
                                <i class="fa fa-clock i-left-15"></i>
                                <span>Напоминание отправлено</span>
                            </span>
                            </div>


                        </div>

                        <div class="profile-company__change_inn">
                            <a href="/profile/company?change_inn=true" class="is-or-link"><span>Изменить ИНН</span></a>
                        </div>


                        <div class="profile-company__bug-report">
                            <a href="#report" class="is-blue-link fancybox"><span>Нашли ошибку? Сообщите нам об этом</span></a>
                        </div>

                    </div>

                </div>
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

    </div>


<?php
    $this->load->view('mobile/misc/modal__bug_report');
    $this->load->view('mobile/misc/js/bug_report');
    $this->load->view('mobile/profile/js/company_join');