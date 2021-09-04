<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 18:15
 */
?>

<main>
<div class="container">
<!-- Левый сайдбар -->
<div class="main-features">
    <?php $this->load->view('desktop/user/menu_user', $menu);?>

    <!-- Кнопка Наверх -->
    <a href="#" class="back-to-top is-blue-link">
        <i class="fas fa-caret-up"></i>
        <span>Наверх</span>
    </a>
</div>
<!-- Правый сайдбар -->
<section class="additional-features">
    <div class="request__add-new is-rounded is-box-shadow">
        <a href="/requests/add" class="request__add-btn or-btn btn btn-info ripple-effect">
            <i class="fas fa-plus"></i>
            Создать заявку
        </a>
    </div>

    <div class="request__wrap is-rounded is-box-shadow is-mtop-20">
        <div class="request__form-sidebar">
            <form action="">

                <div class="request__btn-block">
                                <span class="request__reset-btn--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                    <input type="reset" class="request__reset-btn is-rounded" value="Сбросить фильтры">
                                </span>
                </div>

                <div class="request__check-block is-mtop-10" id="req-group-01">
                    <div class="request__form-title"><b>В статусе</b></div>

                    <input type="checkbox" class="request__checkbox" id="request-status-01">
                    <label class="request__label-c" for="request-status-01">Сформирована</label>

                    <input type="checkbox" class="request__checkbox" id="request-status-02">
                    <label class="request__label-c" for="request-status-02">В работе</label>

                    <input type="checkbox" class="request__checkbox" id="request-status-03">
                    <label class="request__label-c" for="request-status-03">Завершена</label>

                    <input type="checkbox" class="request__checkbox" id="request-status-04">
                    <label class="request__label-c is-last-el" for="request-status-04">Отменена</label>

                    <a href="" rel="req-group-01" class="request__check-all is-blue-link"><span>Все</span></a>

                    <a href="" rel="req-group-01" class="request__check-none is-blue-link slide-hidden"><span>Ничего</span></a>
                </div>

                <label for="request-filter" class="request__select-sidebar--wrap"><b>Хронология</b>
                    <select id="request-filter" class="request__select-sidebar">
                        <option value="Последние">Последние</option>
                        <option value="Давние">Давние</option>
                        <option value="Третий вариант">Третий вариант</option>
                    </select>
                </label>

                <div class="advpost__check-block">
                    <div class="advpost__form-title"><b>По технике</b></div>
                    <!-- Выбранный элемент из списка техники -->
                    <div class="advpost__tech-choosen is-long-row">
                        <a href="" class="is-or-link"><i class="fas fa-trash-alt"></i></a>
                        <span class="tech-choosen-01">CATERPILLAR</span>
                    </div>

                    <a href="#requests__choose-eq" class="is-or-link tech-choose fancybox"><span>Выбрать из парка...</span></a>
                </div>

                <div class="request__select-sidebar--wrap"><b>Суммы</b>
                    <div>
                        <input type="number" class="advpost__summ-sidebar" placeholder="от" pattern="[0-9]{2}" inputmode="numeric"> - <input type="number" class="advpost__summ-sidebar advpost__summ-sidebar--r" placeholder="до" pattern="[0-9]{2}" inputmode="numeric">
                    </div>
                </div>

                <div class="advpost__check-block">
                    <div class="advpost__form-title"><b>Сотрудники</b></div>
                    <!-- Выбранный человек из списка партнеров -->
                    <div class="employee__me-choosen is-long-row">
                        <a href="" class="is-grey-link"><i class="fas fa-trash-alt"></i></a>
                        <span class="tech-choosen-01">Я</span>
                    </div>
                    <!-- Выбранный человек из списка партнеров -->
                    <div class="employee__name-choosen is-long-row">
                        <a href="" class="is-or-link"><i class="fas fa-trash-alt"></i></a>
                        <span class="tech-choosen-01">Василий Викторович Развязкин</span>
                    </div>
                    <!-- Выбранный человек из списка партнеров -->
                    <div class="employee__name-choosen is-long-row">
                        <a href="" class="is-or-link"><i class="fas fa-trash-alt"></i></a>
                        <span class="tech-choosen-01">Подорожный Георгий Борисович</span>
                    </div>

                    <a href="#choose-partner" class="is-or-link partner-choose fancybox"><span>Выбрать из списка...</span></a>
                </div>
            </form>
        </div>
    </div>

    <div class="header__promo-space is-mtop-20">
        <img src="img/promo-space__bg.png" class="promo-space__bg" alt="">
        <div class="promo-space__cover">
            <img src="img/promo-space__logo.png" alt="">
            <div>Место для вашей<br>рекламы</div>
        </div>
        <a href="#" class="promo-space__more or-btn btn btn-info ripple-effect">Подробнее</a>
    </div>
</section>
<!-- Контент -->
<section class="page-content">
<div class="sub-menu sub-menu--wide-n">
    <ul class="sub-menu__list">
        <li><a href="#" class="active is-fade">Исходящие</a></li>
        <li><a href="#" class="is-fade">Входящие <span>(2)</span></a></li>
        <li><a href="#" class="is-fade">Архив</a></li>
    </ul>
</div>

<!-- Блок списка заявок -->
<div class="main-requests is-mtop-20">
<!-- Заявки от первого лица -->
<div class="requests__col is-rounded is-box-shadow">
<!-- От кого заявки -->
<div class="my-partners__row write-msg">
    <div class="my-partners__lcell">
        <a href="" class="my-partners__image-sm is-rounded">
            <img src="img/content/partner-info__photo-05.jpg" alt="">
        </a>
        <div class="my-partners__content-sm">
            <a href="" class="my-partners__name is-blue-text"><b>Дмитрий Анатольевич Медведев</b></a>
            <div class="my-partners__request is-grey-text">Последние <span>5</span> заявок (из <span>48</span> совпадений)</div>


            <a href="" class="requests__slide-list-down">
                <div class="is-blue-link">
                    <i class="fa fa-long-arrow-down"></i>
                    <span>Показать все</span>
                </div>
            </a>
            <a href="" class="requests__slide-list-up slide-hidden">
                <div class="is-blue-link">
                    <i class="fa fa-long-arrow-up"></i>
                    <span>Свернуть список</span>
                </div>
            </a>

        </div>
    </div>
    <div class="my-partners__rcell">
    </div>
</div>
<!-- Список заявок от этого человека -->
<div class="section-user-request__block">

<div class="request__item req-item request__status--answered">
    <a href="index-28.html" target="_blank" class="request__item--wrap">
        <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
        <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
        <p class="is-last-el"><span>Статус: </span><span class="req-item__status ">Сформирована (есть ответ)</span></p>
    </a>

    <div class="req-item__helpers">
        <ul class="req-item__actions is-rounded is-box-shadow">
            <li class="is-first-item"><a href="">Сравнить предложения</a></li>
            <li><a href="">Редактировать</a></li>
            <li class="is-last-item"><a href="">Удалить</a></li>
        </ul>
    </div>
    <div class="req-item__time">21:23</div>
</div>
<div class="request__item req-item request__status--canceled">
    <a href="index-28.html" target="_blank" class="request__item--wrap">
        <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
        <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
        <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
    </a>

    <div class="req-item__helpers">
        <ul class="req-item__actions is-rounded is-box-shadow">
            <li class="is-first-item"><a href="">Сравнить предложения</a></li>
            <li><a href="">Редактировать</a></li>
            <li class="is-last-item"><a href="">Удалить</a></li>
        </ul>
    </div>
    <div class="req-item__time">10 мая 2015</div>
</div>
<div class="request__item req-item request__status--active">
    <a href="index-28.html" target="_blank" class="request__item--wrap">
        <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
        <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
        <p class="is-last-el"><span>Статус: </span><span class="req-item__status">В работе (оплачен)</span></p>
    </a>

    <div class="req-item__helpers">
        <ul class="req-item__actions is-rounded is-box-shadow">
            <li class="is-first-item"><a href="">Сравнить предложения</a></li>
            <li><a href="">Редактировать</a></li>
            <li class="is-last-item"><a href="">Удалить</a></li>
        </ul>
    </div>
    <div class="req-item__time">5 мая 2014</div>
</div>
<div class="request__item req-item request__status--done">
    <a href="index-28.html" target="_blank" class="request__item--wrap">
        <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
        <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
        <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Завершена</span></p>
    </a>

    <div class="req-item__helpers">
        <ul class="req-item__actions is-rounded is-box-shadow">
            <li class="is-first-item"><a href="">Сравнить предложения</a></li>
            <li><a href="">Редактировать</a></li>
            <li class="is-last-item"><a href="">Удалить</a></li>
        </ul>
    </div>
    <div class="req-item__time">1 января 2015</div>
</div>
<div class="request__item req-item request__status--answered">
    <a href="index-28.html" target="_blank" class="request__item--wrap">
        <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
        <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
        <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Сформирована (есть ответ)</span></p>
    </a>

    <div class="req-item__helpers">
        <ul class="req-item__actions is-rounded is-box-shadow">
            <li class="is-first-item"><a href="">Сравнить предложения</a></li>
            <li><a href="">Редактировать</a></li>
            <li class="is-last-item"><a href="">Удалить</a></li>
        </ul>
    </div>
    <div class="req-item__time">6 июня 20015</div>
</div>

<div class="request__wrapper is-hidden">
    <div class="request__item req-item request__status--canceled">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">10 мая 2015</div>
    </div>
    <div class="request__item req-item request__status--canceled">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">10 мая 2015</div>
    </div>
    <div class="request__item req-item request__status--canceled">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">10 мая 2015</div>
    </div>
    <div class="request__item req-item request__status--active">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">В работе (оплачен)</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">5 мая 2014</div>
    </div>
    <div class="request__item req-item request__status--canceled">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">10 мая 2015</div>
    </div>
    <div class="request__item req-item request__status--active">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">В работе (оплачен)</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">5 мая 2014</div>
    </div>
    <div class="request__item req-item request__status--answered">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Сформирована (есть ответ)</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">6 июня 20015</div>
    </div>
    <div class="request__item req-item request__status--answered">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Сформирована (есть ответ)</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">6 июня 20015</div>
    </div>
    <div class="request__item req-item request__status--answered">
        <a href="index-28.html" target="_blank" class="request__item--wrap">
            <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
            <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
            <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Сформирована (есть ответ)</span></p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                <li><a href="">Редактировать</a></li>
                <li class="is-last-item"><a href="">Удалить</a></li>
            </ul>
        </div>
        <div class="req-item__time">6 июня 20015</div>
    </div>
</div>

<a href="" class="requests__open requests__slide-list is-blue-link js-more-history is-last-item"><span>Показать еще</span></a>
</div>
<!-- -->
</div>

<!-- Заявки от второго человека -->
<div class="requests__col is-rounded is-box-shadow is-mtop-20">
    <!-- От кого заявки -->
    <div class="my-partners__row write-msg">
        <div class="my-partners__lcell">
            <a href="" class="my-partners__image-sm is-rounded">
                <img src="img/content/partner-info__photo-03.jpg" alt="">
            </a>
            <div class="my-partners__content-sm">
                <a href="" class="my-partners__name is-blue-text"><b>Георгий Борисович Подорожный</b></a>
                <div class="my-partners__request is-grey-text"><span>6</span> заявок</div>


                <a href="" class="requests__slide-list-down">
                    <div class="is-blue-link">
                        <i class="fa fa-long-arrow-down"></i>
                        <span>Показать все</span>
                    </div>
                </a>
                <a href="" class="requests__slide-list-up slide-hidden">
                    <div class="is-blue-link">
                        <i class="fa fa-long-arrow-up"></i>
                        <span>Свернуть список</span>
                    </div>
                </a>

            </div>
        </div>
        <div class="my-partners__rcell">
            <div>
                <a href="index-10.html" class="is-blue-link">
                    <i class="fas fa-envelope i-left-15"></i>
                    <span>Написать сообщение</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Список заявок от этого человека -->
    <div class="section-user-request__block">

        <div class="request__item req-item request__status--answered">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status ">Сформирована (есть ответ)</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">21:23</div>
        </div>
        <div class="request__item req-item request__status--canceled">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">10 мая 2015</div>
        </div>
        <div class="request__item req-item request__status--active">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status">В работе (оплачен)</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">5 мая 2014</div>
        </div>
        <div class="request__item req-item request__status--done">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Завершена</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">1 января 2015</div>
        </div>
        <div class="request__item req-item request__status--answered">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Сформирована (есть ответ)</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">6 июня 20015</div>
        </div>

        <div class="request__wrapper is-hidden">
            <div class="request__item req-item request__status--canceled">
                <a href="index-28.html" target="_blank" class="request__item--wrap">
                    <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                    <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
                    <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
                </a>

                <div class="req-item__helpers">
                    <ul class="req-item__actions is-rounded is-box-shadow">
                        <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                        <li><a href="">Редактировать</a></li>
                        <li class="is-last-item"><a href="">Удалить</a></li>
                    </ul>
                </div>
                <div class="req-item__time">10 мая 2015</div>
            </div>
            <div class="request__item req-item request__status--canceled">
                <a href="index-28.html" target="_blank" class="request__item--wrap">
                    <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                    <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
                    <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
                </a>

                <div class="req-item__helpers">
                    <ul class="req-item__actions is-rounded is-box-shadow">
                        <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                        <li><a href="">Редактировать</a></li>
                        <li class="is-last-item"><a href="">Удалить</a></li>
                    </ul>
                </div>
                <div class="req-item__time">10 мая 2015</div>
            </div>
            <div class="request__item req-item request__status--canceled">
                <a href="index-28.html" target="_blank" class="request__item--wrap">
                    <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                    <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
                    <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
                </a>

                <div class="req-item__helpers">
                    <ul class="req-item__actions is-rounded is-box-shadow">
                        <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                        <li><a href="">Редактировать</a></li>
                        <li class="is-last-item"><a href="">Удалить</a></li>
                    </ul>
                </div>
                <div class="req-item__time">10 мая 2015</div>
            </div>
        </div>

        <a href="" class="requests__open requests__slide-list is-blue-link js-more-history is-last-item"><span>Показать еще</span></a>
    </div>
    <!-- -->
</div>
<!-- -->

<!-- Заявки от третьего человека -->
<div class="requests__col is-rounded is-box-shadow is-mtop-20">
    <!-- От кого заявки -->
    <div class="my-partners__row write-msg">
        <div class="my-partners__lcell">
            <a href="" class="my-partners__image-sm is-rounded">
                <img src="img/content/partner-info__photo-06.jpg" alt="">
            </a>
            <div class="my-partners__content-sm">
                <a href="" class="my-partners__name is-blue-text"><b>Алевтина Перекрестова</b></a>
                <div class="my-partners__request is-grey-text"><span>5</span> заявок</div>

            </div>
        </div>
        <div class="my-partners__rcell">
            <div>
                <a href="index-10.html" target="_blank" class="is-blue-link">
                    <i class="fas fa-envelope i-left-15"></i>
                    <span>Написать сообщение</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Список заявок от этого человека -->
    <div class="section-user-request__block">

        <div class="request__item req-item request__status--answered">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212322.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Двигатель внутреннего сгорания, Цепь, Подушки ДВС</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status ">Сформирована (есть ответ)</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">21:23</div>
        </div>
        <div class="request__item req-item request__status--canceled is-last-item">
            <a href="index-28.html" target="_blank" class="request__item--wrap">
                <p><b>#3212351.</b> <span>Caterpillar, асфальтоукладчик, AP1055E</span></p>
                <p class="req-item__descr">Нужно очень много деталей и оперативненько. Пожалуйста, поторопитесь с обработкой этой заявки, потому что нам очень срочно...</p>
                <p class="is-last-el"><span>Статус: </span><span class="req-item__status">Отменена</span></p>
            </a>

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item"><a href="">Сравнить предложения</a></li>
                    <li><a href="">Редактировать</a></li>
                    <li class="is-last-item"><a href="">Удалить</a></li>
                </ul>
            </div>
            <div class="req-item__time">10 мая 2015</div>
        </div>

        <div class="request__wrapper is-hidden">
        </div>

    </div>
    <!-- -->
</div>
<!-- -->
</div>

<div class="requests__last is-no-select"><p>Это все заявки, найденные с учетом заданного фильтра.</p><p>Уточните запрос, если не нашли нужного. Также Вы можете <a href="" class="is-blue-link js-filter-del"><span>сбросить фильтры</span></a></div>
<!-- Кнопка Подгружаю еще -->
</section>


<!-- Создать Заявку -->
<div id="add-advpost" class="modal is-rounded">
    <div class="modal__head is-rounded">
        <div class="modal__title">Новое объявление</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>
    <div class="modal__body">

        <form action="" class="advpost__form">
            <div class="advpost__radio--line clear"><b>Тип объявления</b>
                <div class="advpost__radio--cover">
                    <input type="radio" name="advpost-radio" id="advpost__sell" />
                    <label for="advpost__sell">Продать</label>

                    <input type="radio" name="advpost-radio" id="advpost__buy" />
                    <label for="advpost__buy">Купить</label>

                    <input type="radio" name="advpost-radio" id="advpost__services" />
                    <label for="advpost__services">Услуги</label>
                </div>
            </div>

            <label for="advpost__theme-name" class="advpost__line-label clear"><span>Рубрика</span>
                <select id="advpost__theme-name">
                    <option value="Компания A" selected>Ремонт запчастей</option>
                    <option value="Компания A">Материалы</option>
                    <option value="Компания B">Техника</option>
                </select>
            </label>

            <label for="advpos__brand" class="advpost__line-label clear"><span>Производители</span>
                <select id="advpos__brand">
                    <option disabled selected>Выбрать из списка</option>
                    <option value="Компания A">Самая крупная компания</option>
                    <option value="Компания A">Компания и сервис A</option>
                    <option value="Компания B">Компания B</option>
                    <option value="Компания C">Inc C</option>
                    <option value="Компания D">Company D</option>
                </select>
            </label>

            <label for="advpost__ta-title" class="advpost__line-label clear"><span>Заголовок</span>
                <textarea id="advpost__ta-title" maxlength="100" placeholder="Не используйте слова «продам», «куплю»"></textarea>
            </label>

            <label for="" class="advpost__line-label clear"><span>Ключевые слова<br>(через запятую)</span>
                <textarea id="advpost__ta-keywords" maxlength="100" placeholder="Артикул, модель, важные характеристики"></textarea>
            </label>

            <label for="" class="advpost__line-label clear"><span>Стоимость</span>
                <input type="text" class="advpost__input" id="" placeholder="Цифра">
                <span class="advpost__new-input">или <a href="" class="is-or-link"><span>Указать ценовой диапазон</span></a></span>
            </label>

            <label for="advpost__ta-posttext" class="advpost__line-label clear"><span>Текст объявления</span>
                <textarea id="advpost__ta-posttext" maxlength="400" placeholder="Описание Вашего предложения"></textarea>
            </label>
        </form>

        <div class="add-advpost__file--wrap">
            <input type="file" id="add-advpost__file">
            <label for="add-advpost__file" class="is-blue-link add-advpost__label">
                <i class="fa fa-paperclip"></i>
                <span>Прикрепить фото</span>
            </label>
        </div>
    </div>
    <div class="modal__footer">
                    <span class="add-equipment__submit--wrap is-last-item btn ripple-effect btn-primary2 ">
                        <i class="fas fa-check"></i>
                        <input type="submit" class="add-equipment__submit " value="Опубликовать">
                    </span>
    </div>
</div>


<!-- Выбрать технику -->
<div id="requests__choose-eq" class="new-msg__modal">
    <div class="new-msg__top-line">
        <div class="new-msg__title">Выберите технику из парка</div>

        <div class="submit--rcover">
            <form action="">
                <input type="submit" class="new-msg__submit" value="" title="Начать поиск">
                <input type="search" class="new-msg__search is-rounded" placeholder="Поиск по технике в парке">
            </form>
        </div>

        <a href="" class="new-msg__close-btn"><i class="fas fa-times"></i></a>
    </div>
    <div class="requests__choose-block is-rounded is-box-shadow">
        <!-- строка с оборудованием -->
        <div class="requests-info__block is-rounded is-box-shadow">
            <div class="requests-info__photo">
                <!-- если фото нет, остается серый фон с иконкой -->
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
            </div>
        </div>

        <!-- строка с оборудованием -->
        <div class="requests-info__block is-mtop-10 is-rounded is-box-shadow">
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
            </div>
        </div>

        <!-- строка с оборудованием -->
        <div class="requests-info__block is-mtop-10 is-rounded is-box-shadow">
            <div class="requests-info__photo">
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
            </div>
        </div>

        <!-- последняя строка с оборудованием -->
        <div class="requests-info__block is-mtop-10 is-rounded is-box-shadow">
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
            </div>
        </div>

        <a href="" class="req-choose__btn btn-primary2 btn ripple-effect is-hidden">Добавить технику</a>
    </div>
</div>
<!-- end Выбрать технику -->


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
</div>
</main>