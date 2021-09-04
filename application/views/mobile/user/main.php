<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.04.2018
 * Time: 18:24
 */
?>


<header class="header">
    <div class="container">
        <!-- блоки, видимые на мобильном -->
        <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>
        <div class="header__page-title t-hide">Моя страница</div>
        <div class="header__icons t-hide">
            <div class="header__open-search js-search"><i class="fa fa-search" aria-hidden="true"></i></div>

            <!-- есть 2 сообщения -->
            <a href="index-msg.html" class="header__open-msg has-msg">
                <span>2</span>
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
            </a>
            <!-- нет сообщений -->
            <a href="index-msg.html" class="header__open-msg">
                    <span></span>
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                </a>
        </div>

        <!-- блоки, видимые на планшете -->
        <img src="/assets__old/img/header__company--logo.png" class="header__logo m-hide">
        <div class="header__line m-hide">
            <div class="header-widget__exchange-value">
                <span class="">$ — <span class="exchange-value__dollar"><?php echo $page_header['usd'];?></span></span>
                <span class="">€ — <span class="exchange-value__euro"><?php echo $page_header['eur'];?></span></span>
            </div>
            <a href="" class="widget__convert    header-widget__convert">
                <div class="header-widget__convert-icon">
                    <div><i class="fa fa-eur"></i><i class="fa fa-gbp"></i></div>
                    <div><i class="fa fa-usd"></i><i class="fa fa-rub"></i></div>
                </div>
            </a>
            <a href="" class="header-widget__calc">
                <i class="fa fa-calculator"></i>
            </a>
        </div>

    </div>
</header>

<div class="content">

    <section class="profile">
        <div class="profile__info profile-info">

            <!-- если профиль пустой -->
            <div class="container" style="display: none;">
                <div class="flex-row">
                    <div class="profile-info__img-container">
                        <div class="profile-info__img is-rounded" style="">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="profile-info__data-container pr-data-container">
                        <div class="pr-data-container__empty-name">+7 999-999-99-00</div>
                        <div class="pr-data-container__empty-title is-or-text">Сделайте рабочее пространство эффективным, дополнив информацию о себе</div>
                        <div class="pr-data-container__empty-descr is-grey-text">Ваш профиль — это не просто анкета, но и визитная карточка, открывающая широкие возможности по расширению партнерской сети.</div>
                    </div>
                </div>
                <div class="profile-info__activity pr-activity pr-activity--empty">
                    <div class="pr-activity__status pr-status flex-row">
                        <div class="pr-status__title is-grey-text">Статус</div>
                        <div class="pr-status__name">
                            <span>Готов к сотрудничеству</span>
                        </div>
                        <a href="" class="pr-status__link is-or-text">Изменить</a>
                    </div>
                </div>
            </div>
            <!-- end если профиль пустой -->

            <!-- если профиль заполнен -->
            <div class="container">
                <div class="profile-info__main-container flex-row">
                    <div class="profile-info__img-container">
                        <div class="profile-info__img is-rounded has-avatar" style="background: url('img/content/user-portrait.jpg');">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="profile-info__data-container pr-data-container">
                        <div class="pr-data-container__name">Дмитрий Анатольевич Медведев</div>
                        <div class="pr-data-container__title">Председатель</div>
                        <a href="" class="pr-data-container__descr is-blue-text">Правительство Российской Федерации</a>
                    </div>
                    <a href="" class="profile-info__edit"><i class="fa fa-pencil is-grey-text"></i></a>
                </div>
                <div class="profile-info__activity pr-activity">
                    <div class="pr-activity__contacts pr-contacts flex-row">
                        <div class="pr-contacts__title is-grey-text">Контакты</div>
                        <div>
                            <a href="mailto:" class="pr-contacts__email">mail@medvedev.ru</a>
                            <a href="tel:" class="pr-contacts__phone is-blue-text">+7 (999) 999-99-99</a>
                            <span class="pr-contacts__city">Москва</span>

                            <div class="pr-contacts__pre-rating">
                                <div class="pr-contacts__rating is-rounded">
                                    <div class="pr-contacts__stars rate__lvl rate__lvl--4"></div>
                                    <div class="pr-contacts__users is-blue-text">
                                        <i class="fa fa-users"></i>
                                        258
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-status">
                <div class="container pr-activity">
                    <div class="pr-activity__status pr-status flex-row">
                        <div class="pr-status__title is-grey-text">Статус</div>
                        <div class="pr-status__name">
                            <span>Ищем подрядчиков для строительства моста через пролив</span>
                        </div>
                        <a href="" class="pr-status__edit"><i class="fa fa-pencil is-grey-text"></i></a>
                    </div>
                </div>
            </div>
            <!-- end если профиль заполнен -->

        </div>
    </section>

    <section class="profile-links flex-row">
        <a href="#" class="profile-links__item -active">Новости</a>
        <a href="#" class="profile-links__item">Объявления</a>
        <a href="#" class="profile-links__item">Заявки</a>
    </section>

</div>
