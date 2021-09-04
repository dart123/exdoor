<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 18:59
 */

?>

<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <ul class="main-menu__list">
                <span class="current"><i class="fa fa-bars"></i><span>Меню</span></span>
                <li><a href="" class="is-first-item btn ripple-effect btn-primary">Моя страница</a></li>
                <li><a href="" class="btn ripple-effect">Моя компания</a></li>
                <li><a href="" class="btn ripple-effect">Новости</a></li>
                <li><a href="" class="btn ripple-effect">
                        <span class="msg-counter">
                            <span class="msg-counter__item">999</span>
                        </span>
                        Сообщения</a></li>
                <li><a href="" class="btn ripple-effect">Партнеры</a></li>
                <li><a href="" class="active btn ripple-effect">Заявки</a></li>
                <li><a href="" class="btn ripple-effect">Объявления</a></li>
                <li><a href="" class="btn ripple-effect">Парк техники</a></li>
                <li><a href="" class="is-last-item btn ripple-effect">Профиль</a></li>
            </ul>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <div class="header__promo-space">
                <img src="img/promo-space__bg.png" class="promo-space__bg" alt="">
                <div class="promo-space__cover">
                    <img src="img/promo-space__logo.png" alt="">
                    <div>Место для вашей<br>рекламы</div>
                </div>
                <a href="#" class="promo-space__more or-btn btn btn-info ripple-effect">Подробнее</a>
            </div>
        </section>
        <!-- Контент -->
        <section class="page-content-form left-400 ">
            <div class="page-content-form__left">
                <!--  Заголовок заявки -->
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        <b>Заявка #3212322.</b> Caterpillar, асфальтоукладчик, AP1055E
                    </div>
                </div>
            </div>
            <div class="page-content-form__right"></div>


            <div class="page-content-form__left">
                <!--  Заявка с кнопкой редактировать -->
                <div class="is-mtop-20">
                    <!--  Блок заявки -->
                    <div class="requests-info__block is-rounded is-box-shadow">
                        <div class="requests-info__photo">
                            <img src="img/content/big-img-example.jpg" alt="">
                        </div>
                        <div class="requests-info__content">
                            <p>
                                <span class="requests-ind is-grey-text">Производитель:</span>
                                <span class="requests-descr is-long-row">Caterpillar</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Назначение:</span>
                                <span class="requests-descr is-long-row">Экскаватор одноковшорвый, ямокоп</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Модель:</span>
                                <span class="requests-descr is-long-row">AP1055E</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Серийный номер:</span>
                                <span class="requests-descr is-long-row">363766-11-2474747-assd17a</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Двигатель:</span>
                                <span class="requests-descr is-long-row">QG82-12</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Год выпуска:</span>
                                <span class="requests-descr is-long-row">2006</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Подразделение:</span>
                                <span class="requests-descr is-long-row">Москва, Зеленоград, база №15</span>
                            </p>
                            <p>
                                <span class="requests-descr"><a href="" data-openajax="img-upload" class="is-blue-link"><span>8 фотографий</span></a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-content-form__right">
                <div class="is-mtop-20">
                    <a href="" class="requests__edit-btn btn ripple-effect btn-primary2 is-rounded">
                        <i class="fas fa-pen"></i>
                        <span class="">Редактировать</span>
                    </a>
                </div>
            </div>



            <div class="page-content-form__left">
                <!--  Заголовок позициии -->
                <div class="requests-step__line is-mtop-20 is-mright-400">
                    <div class="requests-step__title">
                        Запрашиваемые позиции
                    </div>
                </div>
            </div>
            <div class="page-content-form__right"></div>



            <div class="page-content-form__left">
                <!--  Запрашиваемые позиции с кнопкой редактировать -->
                <div class="is-mtop-20">
                    <!--  Запрашиваемые позиции -->
                    <div class="requests-eq__block is-rounded is-box-shadow">
                        <!--  Позиция номер 1 -->
                        <?php
                        $r_i = 1;
                        foreach ($request_positions as $r_position):?>
                        <div class="requests-eq__item">
                            <div class="requests-eq__pos-row">
                                <div class="requests-eq__no"><b>#<?php echo $r_i;?></b></div><!--
                                 --><div class="requests-eq__pos-descr">
                                    <div class="position-name is-grey-text">
                                        <p>Деталь:</p>
                                        <p>Номер в каталогах</p>
                                    </div>
                                    <div class="position-name">
                                        <p><?php echo $r_position->detail;?></p>
                                        <p><?php echo $r_position->catalog_num;?></p>
                                    </div>
                                    <!-- <a href="#" data-open-id="album-2" class="requests-eq__img requests-eq__img--2 open-album">
                                        <div class="requests-eq__inner">
                                            <img src="img/content/eq-img.jpg" alt="">
                                        </div>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                        <?php
                        $r_i++;
                        endforeach;?>
                    </div>
                </div>
            </div>

            <div class="page-content-form__right">
                <!--  Кнопка Редактировать  -->
                <div class="is-mtop-20">
                    <a href="" class="requests__edit-btn btn ripple-effect btn-primary2 is-rounded">
                        <i class="fas fa-pen"></i>
                        <span class="">Редактировать</span>
                    </a>
                </div>
            </div>



            <div class="page-content-form__left">
                <!--  Заголовок для блока с третьим шагом -->
                <div class="requests-step__line requests-step__third is-mtop-20">
                    <div class="requests-step__title">
                        <b><span class="i-left-20">3</span></b>/ 3 <b class="text">Кому отправляем заявку?</b> <span class="is-grey-text">Можно выбрать не более 10</span>
                    </div>
                    <div class="requests-step__indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="page-content-form__right"></div>



            <div class="page-content-form__left">
                <!--  Блок с третьим шагом заполнения формы  -->
                <div class="is-mtop-30">
                    <!--  Блок с формой  -->
                    <div class="my-partners__rec requests__rec is-rounded is-box-shadow is-mtop-20">
                        <div class="rec__head is-first-item">
                            <div class="rec__title">Рекомендации</div>
                        </div>
                        <div class="rec__body">
                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                        <img src="img/content/partner-info__photo-05.jpg" alt="">
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b>Дмитрий Анатольевич Медведев</b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                                <span>Правительство Российской Федерации</span>
                                            </a>
                                        </div>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--5"></div>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div class="choose-partner">
                                        <a href="#" class="is-blue-link">
                                            <i class="fas fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner is-hidden">
                                            <span href="#" class="is-grey-text">
                                                <i class="fas fa-check i-left-15"></i>
                                                <span>Выбран</span>
                                            </span>
                                    </div>
                                    <div class="choosen-partner del-partner is-hidden">
                                        <a href="#" class="is-or-link">
                                            <i class="fas fa-times i-left-15"></i>
                                            <span>Отменить</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                        <img src="img/content/partner-info__photo-01.jpg" alt="">
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b>Антонио Фагандэ</b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                                <span>CATERPILLAR</span>
                                            </a>
                                        </div>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div class="choose-partner is-hidden">
                                        <a href="#" class="is-blue-link">
                                            <i class="fas fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner">
                                            <span href="#" class="is-grey-text">
                                                <i class="fas fa-check i-left-15"></i>
                                                <span>Выбран</span>
                                            </span>
                                    </div>
                                    <div class="choosen-partner del-partner">
                                        <a href="#" class="is-or-link">
                                            <i class="fas fa-times i-left-15"></i>
                                            <span>Отменить</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                        <img src="img/content/partner-info__photo-04.jpg" alt="">
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b>Георгий Борисович Подорожный</b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                                <span>ДСУ-1039</span>
                                            </a>
                                        </div>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div class="choose-partner">
                                        <a href="#" class="is-blue-link">
                                            <i class="fas fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner is-hidden">
                                            <span href="#" class="is-grey-text">
                                                <i class="fas fa-check i-left-15"></i>
                                                <span>Выбран</span>
                                            </span>
                                    </div>
                                    <div class="choosen-partner del-partner is-hidden">
                                        <a href="#" class="is-or-link">
                                            <i class="fas fa-times i-left-15"></i>
                                            <span>Отменить</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                        <img src="img/content/partner-info__photo-05.jpg" alt="">
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b>Дмитрий Анатольевич Медведев</b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="index-6.html" target="_blank" target="_blank" class="my-partners__company-name is-grey-link">
                                                <span>Правительство Российской Федерации</span>
                                            </a>
                                        </div>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--5"></div>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div class="choose-partner">
                                        <a href="#" class="is-blue-link">
                                            <i class="fas fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner is-hidden">
                                            <span href="#" class="is-grey-text">
                                                <i class="fas fa-check i-left-15"></i>
                                                <span>Выбран</span>
                                            </span>
                                    </div>
                                    <div class="choosen-partner del-partner is-hidden">
                                        <a href="#" class="is-or-link">
                                            <i class="fas fa-times i-left-15"></i>
                                            <span>Отменить</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                        <img src="img/content/partner-info__photo-01.jpg" alt="">
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b>Антонио Фагандэ</b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                                <span>CATERPILLAR</span>
                                            </a>
                                        </div>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div class="choose-partner is-hidden">
                                        <a href="#" class="is-blue-link">
                                            <i class="fas fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner">
                                            <span href="#" class="is-grey-text">
                                                <i class="fas fa-check i-left-15"></i>
                                                <span>Выбран</span>
                                            </span>
                                    </div>
                                    <div class="choosen-partner del-partner">
                                        <a href="#" class="is-or-link">
                                            <i class="fas fa-times i-left-15"></i>
                                            <span>Отменить</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                        <img src="img/content/partner-info__photo-04.jpg" alt="">
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b>Георгий Борисович Подорожный</b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                                <span>ДСУ-1039</span>
                                            </a>
                                        </div>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div class="choose-partner">
                                        <a href="#" class="is-blue-link">
                                            <i class="fas fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner is-hidden">
                                            <span href="#" class="is-grey-text">
                                                <i class="fas fa-check i-left-15"></i>
                                                <span>Выбран</span>
                                            </span>
                                    </div>
                                    <div class="choosen-partner del-partner is-hidden">
                                        <a href="#" class="is-or-link">
                                            <i class="fas fa-times i-left-15"></i>
                                            <span>Отменить</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="requests__choose">
                            <a href="#choose-partner" class="is-or-link fancybox">
                                <i class="fas fa-plus"></i>
                                <span>Выбрать из списка своих партнеров</span>
                            </a>
                        </div>

                        <a href="" class="requests__submit is-last-item btn-primary2 btn ripple-effect">
                            <i class="fa fa-paper-plane i-left-20 "></i>
                            <span>Отправить заявку выбранным партнерам и сохранить</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="page-content-form__right">
                <div class="request-lvl__block is-mtop-30 is-rounded is-box-shadow">
                    Уровень заполненности

                    <div class="request-lvl__slider">
                        <div class="counter round-counter" id="counter-form-fill">
                            <div class="rs-handle"></div>
                        </div>
                    </div>

                    <span class="is-or-text is-mtop-10 request-lvl__descr lvl-descr__third">Высокий</span>
                    <span class="is-grey-text is-mtop-20">Ваша заявка обречена на оперативное выполнение</span>
                </div>
            </div>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->


        <!-- Выбрать партнера -->
        <div id="choose-partner" class="modal__block is-rounded">
            <div class="modal__head modal__head--blue is-first-item">
                <div class="modal__title">Мои партнеры</div>
                <a href="" class="modal__close-btn">Закрыть <i class="fas fa-times"></i></a>
            </div>
            <!-- -->

            <div class="submit--ncover">
                <form action="">
                    <input type="submit" class="requests-modal__submit" value="" title="Начать поиск">
                    <input type="search" class="requests__search" autocomplete="off" placeholder="Поиск среди своих партнеров"/>
                </form>
            </div>

            <!-- -->
            <div class="requests-partners__wrapper">
                <div class="wrapper-top"></div><div class="wrapper-btm"></div>
                <div class="requests-partners__slide scrollbar-inner scroll-content scroll-scrolly_visible" >
                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-05.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Дмитрий Анатольевич Медведев</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>Правительство Российской Федерации</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--5"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner is-hidden">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner is-hidden">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-01.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Антонио Фагандэ</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>CATERPILLAR</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner is-hidden">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-04.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Георгий Борисович Подорожный</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>ДСУ-1039</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner is-hidden">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner is-hidden">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-05.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Дмитрий Анатольевич Медведев</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>Правительство Российской Федерации</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--5"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner is-hidden">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner is-hidden">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-01.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Антонио Фагандэ</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>CATERPILLAR</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner is-hidden">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-04.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Георгий Борисович Подорожный</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>ДСУ-1039</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner is-hidden">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner is-hidden">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-01.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Антонио Фагандэ</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>CATERPILLAR</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner is-hidden">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="my-partners__row">
                        <div class="my-partners__lcell">
                            <a href="index-4.html" target="_blank" class="my-partners__image is-rounded">
                                <img src="img/content/partner-info__photo-04.jpg" alt="">
                            </a>
                            <div class="my-partners__content">
                                <div>
                                    <a href="index-4.html" target="_blank" class="my-partners__name is-blue-link">
                                        <span><b>Георгий Борисович Подорожный</b></span>
                                    </a>
                                </div>
                                <div>
                                    <a href="index-6.html" target="_blank" class="my-partners__company-name is-grey-link">
                                        <span>ДСУ-1039</span>
                                    </a>
                                </div>
                                <div class="my-partners__rating-level rate__lvl rate__lvl--2"></div>
                            </div>
                        </div>

                        <div class="my-partners__rcell">
                            <div class="choose-partner">
                                <a href="#" class="is-blue-link">
                                    <i class="fas fa-plus i-left-15"></i>
                                    <span>Выбрать</span>
                                </a>
                            </div>
                            <div class="choosen-partner is-hidden">
                                    <span href="#" class="is-grey-text">
                                        <i class="fas fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                            </div>
                            <div class="choosen-partner del-partner is-hidden">
                                <a href="#" class="is-or-link">
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Футер окна -->
            <div class="requests__footer">
                <span class="is-grey-text">Можно выбрать еще <span>7</span> человек</span>

                <a href="" class="requests__add-partner btn ripple-effect btn-primary2 is-rounded"><i class="fas fa-check i-left-15"></i><span>Добавить</span></a>
            </div>
            <!-- end Футер окна -->
        </div>
        <!-- Выбрать партнера -->


        <!-- Галерея фото -->
        <div id="gallery_two" class="modal__block">
            <a rel="album-2" class="image-show" href="img/content/eq-img.jpg">
                <img src="img/content/eq-img.jpg" alt=""/>
            </a>
            <a rel="album-2" class="image-show" href="img/content/news-advpost-01.jpg">
                <img src="img/content/news-advpost-01.jpg" alt=""/>
            </a>
        </div>
        <!--  -->

    </div>
</main>
