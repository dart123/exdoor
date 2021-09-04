<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width" name="viewport">
    <title>eXdor</title>

    <link href='https://fonts.googleapis.com/css?family=Arimo:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="/assets__old/css/global.css" rel="stylesheet" />
    <link href="/assets__old/css/normalize.css" rel="stylesheet"  />
    <link href="/assets__old/css/material.css" rel="stylesheet"  />
    <link href="/assets__old/css/roundslider.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="/assets__old/css/jquery.fancybox.css" media="screen" />
    <link rel="stylesheet" href="/assets__old/css/jquery.fancybox-thumbs.css" media="screen" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <script src="/assets__old/js/jquery-1.9.1.min.js"></script>
    <script src="/assets__old/js/jquery.maskedinput.min.js"></script>
    <script src="/assets__old/js/masonry.pkgd.min.js"></script>
    <script src="/assets__old/js/jquery-ui.min.js"></script>
    <script src="/assets__old/js/jquery.scrollbar.min.js"></script>
    <script src="/assets__old/js/roundslider.min.js"></script>
    <script src="/assets__old/js/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script src="/assets__old/js/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script src="/assets__old/js/jquery.fancybox-media.js?v=1.0.6"></script>
    <script src="/assets__old/js/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script src="/assets__old/js/html5Forms.js"></script>

    <script src="/assets__old/js/sly.min.js"></script>
    <script src="/assets__old/js/horizontal.js"></script>

    <link href="/assets__old/css/component.css" rel="stylesheet" />
    <script src="/assets__old/js/modernizr.custom.js"></script>
    <script src="/assets__old/js/classie.js"></script>
    <script src="/assets__old/js/modalEffects.js"></script>
    <script src="/assets__old/js/global.js"></script>
</head>

<body class="main-page">
<!-- Preloader -->
<div id="preloader">
    <img src="/assets__old/img/preload.gif" alt="" id="preloader__img">
</div>
<!-- Video modal window -->
<div class="md-modal md-effect-16" id="modal-16">
    <div class="md-content">
    </div>
</div>

<div class="video-cover">
    <header>
        <!-- Header bar -->
        <div class="header__topbar">
            <div class="container">
                <div class="header__company">
                    <img src="/assets__old/img/header__company--logo.png" alt="">
                    <div>Дорожно-строительный<br/>экспресс</div>
                </div>
                <div class="header__user-panel">
                    <form action="" class="h-user-reg__form">
                        <div class="user-city__wrap">
                            <select class="user-city" id="selected-head" required>
                                <option cvalue="+994 (Азербайджан)">+994 (Азербайджан)</option>
                                <option value="+374 (Армения)">+374 (Армения)</option>
                                <option value="+375 (Белоруссия)">+375 (Белоруссия)</option>
                                <option value="+7 (Казахстан)">+7 (Казахстан)</option>
                                <option value="+996 (Киргизия)">+996 (Киргизия)</option>
                                <option value="+373 (Молдавия)">+373 (Молдавия)</option>
                                <option selected value="+7 (Россия)">+7 (Россия)</option>
                                <option value="+992 (Таджикистан)">+992 (Таджикистан)</option>
                                <option value="+993 (Туркмения)">+993 (Туркмения)</option>
                                <option value="+998 (Узбекистан)">+998 (Узбекистан)</option>
                                <option value="+380 (Украина)">+380 (Украина)</option>
                            </select>
                            <select id="tmp-select">
                                <option id="tmp-option"></option>
                            </select>
                        </div>
                        <input type="tel" class="user-phone-num" placeholder="Номер мобильного телефона" inputmode="numeric" required>
                        <span class="is-over-submit btn ripple-effect btn-default is-rounded">
                            <input type="submit" class="user-reg-submit btn btn-default is-rounded" id="" value="Войти / Зарегистрироваться">
                        </span>
                        <a href="#enter-code" class="send-pass fancybox" style="display: none"></a>
                    </form>
                </div>
            </div>
        </div>
        <!-- Header -->
        <div class="header__main">
            <div class="container">
                <ul class="header__project-about">
                    <?php echo $sidebar_menu;?>
                </ul>
                <div class="header__exdor">
                    <div class="row">
                        <h1><img src="/assets__old/img/header__exdor.png" alt="Дорожно-строительный экспресс" title="Дорожно-строительный экспресс"></h1>
                        <div class="header__exdor--show">
                            <a href="#" class="header__exdor--play md-trigger is-fade" data-modal="modal-16"><i class="fa fa-play"></i></a>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="exdor-presentation is-fade">презентация сервиса</a>
                </div>
                <div class="header__promo-space">
                    <img src="/assets__old/img/promo-space__bg.png" class="promo-space__bg" alt="">
                    <div class="promo-space__cover">
                        <img src="/assets__old/img/promo-space__logo.png" alt="">
                        <div>Место для вашей<br>рекламы</div>
                    </div>
                    <a href="#" class="promo-space__more or-btn btn btn-info ripple-effect">Подробнее</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Регистрация -->
    <section class="registration">
        <div class="container">
            <div class="user-reg__wrap">

                <form action="" class="user-reg__form">
                    <span class="user-reg__title">Быстрая регистрация</span>
                    <div class="user-reg__inputs">
                        <div class="user-reg__city--wrap">
                            <select class="user-reg__city" id="selected-01" required>
                                <option value="+994 (Азербайджан)">+994 (Азербайджан)</option>
                                <option value="+374 (Армения)">+374 (Армения)</option>
                                <option value="+375 (Белоруссия)">+375 (Белоруссия)</option>
                                <option value="+7 (Казахстан)">+7 (Казахстан)</option>
                                <option value="+996 (Киргизия)">+996 (Киргизия)</option>
                                <option value="+373 (Молдавия)">+373 (Молдавия)</option>
                                <option selected="selected" value="+7 (Россия)">+7 (Россия)</option>
                                <option value="+992 (Таджикистан)">+992 (Таджикистан)</option>
                                <option value="+993 (Туркмения)">+993 (Туркмения)</option>
                                <option value="+998 (Узбекистан)">+998 (Узбекистан)</option>
                                <option value="+380 (Украина)">+380 (Украина)</option>
                            </select>
                            <select id="reg-tmp-select">
                                <option id="reg-tmp-option"></option>
                            </select>
                        </div>
                        <input type="tel" class="user-reg__phone-num" placeholder="Номер мобильного телефона" inputmode="numeric" required>
                        <span class="is-over-submit btn btn-info ripple-effect is-rounded">
                            <input type="submit" class="user-reg__submit or-btn btn btn-info is-rounded" id="" value="Зарегистрироваться">
                        </span>
                        <a href="#enter-code" class="send-pass fancybox" style="display: none"></a>
                    </div>
                </form>
            </div>
            <div class="user-reg__benefits">
                <h2>Что Вам даст бесплатная регистрация в Exdor?</h2>
                <div class="benefits__item"><i class="fas fa-comments-o"></i>Общение с партнерами в формате социальной сети</div>
                <div class="benefits__item"><i class="fa fa-list-alt"></i>Простое создание заявок на запчасти и технику</div>
                <div class="benefits__item"><i class="fa fa-bullseye"></i>Постоянное расширение партнерской сети</div>
                <div class="benefits__item"><i class="fa fa-sitemap"></i>Комфортное управление компанией</div>
            </div>
        </div>
    </section>
    <!-- "Ещё больше возможностей" -->
    <section class="opportunities">
        <div class="container">
            <h2>Ещё больше возможностей вместе с Exdor! Только взгляните:</h2>
            <div class="opportunities__slider-cover">
                <div class="frame" id="opportunities__slider-w">
                    <ul>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-01.jpg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-01.jpg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-02.jpg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-03.jpg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-04.jpg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-01.jpg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="img/content/big-img-example.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                                <img src="/assets__old/img/content/main-page__item-02.jpg" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="pages"></ul>
                <div class="controls center">
                    <div class="prevPage"></div>
                    <div class="nextPage"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ввод пароля -->
    <div id="enter-code" class="modal__block is-rounded">
        <div class="modal__head modal__head--blue is-first-item">
            <div class="modal__title">Авторизация</div>
            <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
        </div>
        <form action="">
            <div class="modal__content send-code__block">
                <h2>Подтвердите мобильный телефон</h2>
                <p>Введите полученный Вами SMS-код</p>

                <label for="" class="send-code__line-label">
                    <span class="send-code__placeholder" style="display: none">Пароль</span>
                    <input type="number" class="send-code__input" id="" placeholder="Пароль *" required>
                </label>
                <input type="submit" class="send-code__submit or-btn btn btn-info is-rounded" value="Подтвердить">

                <p class="">Запросить пароль повторно можно через <span class="send-code__counter">40</span> секунд</p>
                <a href="" class="send-code__more is-blue-link" style="display: none"><span>Отправить пароль повторно</span></a>
            </div>
        </form>
    </div>
    <!--  -->


    <!-- Подвал -->
    <footer class="main-page-footer">
        <div class="container">
            <div class="footer__copyright">Exdor.ru © 2015 - 2016</div>
            <div class="footer__project-about"><?php echo $footer_menu;?></div>
            <?php echo $language_switcher;?>
        </div>
    </footer>
</div>
<!-- Overlay под видео -->
<div class="md-overlay"></div>

</body>
</html>