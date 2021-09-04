<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 18:16
 */

?>


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
                <!--  Заявка -->
                <div class="is-mtop-20">
                    <!--  Блок заявки -->
                    <div class="requests-info__block is-rounded is-box-shadow">
                        <div class="requests-info__photo">
                            <!-- <img src="img/content/big-img-example.jpg" alt=""> -->
                        </div>
                        <div class="requests-info__content">

                            <p>
                                <span class="requests-ind is-grey-text">Производитель:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->brand;?></span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Назначение:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->appointment;?> &nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Модель:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->model;?></span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Серийный номер:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->serial_number;?></span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Двигатель:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->engine;?></span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Год выпуска:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->year;?></span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Подразделение:</span>
                                <span class="requests-descr is-long-row"><?php echo $request_equipment->section;?></span>
                            </p>
                            <p>
                                <span class="requests-descr"><a href="" data-openajax="img-upload" class="is-blue-link"><span>8 фотографий</span></a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content-form__right">
                <!-- Кнопка редактировать -->
                <div class="is-mtop-20">
                    <a href="" class="requests__edit-btn btn ripple-effect btn-primary2 is-rounded">
                        <i class="fas fa-pen"></i>
                        <span class="">Редактировать</span>
                    </a>
                </div>
            </div>


            <div class="page-content-form__left">
                <!--  Заголовок заявки -->
                <div class="requests-step__line requests-step__second is-mtop-20">
                    <div class="requests-step__title">
                        <b><span class="i-left-20">2</span></b>/ 3 <b class="text">Запрашиваемые позиции по заявленной технике</b>
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
                <!--  Блок 2 шага заполнения формы  -->
                <div class="is-mtop-30">
                    <!--  Блок с формой  -->
                    <div class="requests-step__block is-rounded is-box-shadow">
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="add_positions">
                            <!-- Первая позиция -->
                            <div class="requests-step__form-2">

                                <div class="req__col requests__form-number">№1</div>
                                <div class="req__col">
                                    <a href="" class="js-del-step-form  is-or-link"><i class="fas fa-trash-alt"></i></a>
                                </div>
                                <div class="req__col">
                                    <input type="text" name="detail[]" class="requests-col__input" id="" placeholder="Название детали">
                                    <!--  -->
                                    <input type="text" name="catalog_num[]" class="requests-col__input" id="" placeholder="Номер в каталогах">
                                    <!--  -->
                                    <ul id="filelist" class="scrollbar-inner has-edit clear">
                                        <li>
                                            <img src="img/promo-space__bg.png">
                                            <a href="" class="remove"></a>
                                            <a href="" class="edit"></a>
                                        </li>
                                        <li>
                                            <img src="img/news-01.jpg">
                                            <a href="" class="remove"></a>
                                            <a href="" class="edit"></a>
                                        </li>
                                        <li>
                                            <img src="img/new-service__screen.jpg">
                                            <a href="" class="remove"></a>
                                            <a href="" class="edit"></a>
                                        </li>
                                    </ul>
                                    <!--  -->
                                    <a href="#" data-openajax="img-upload" class="is-blue-link add-requests__label">
                                        <i class="fa fa-paperclip i-left-20"></i>
                                        <span>Прикрепить фото</span>
                                    </a>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Вторая позиция -->
                            <div class="requests-step__form-2">
                                <div class="req__col requests__form-number">№2</div>
                                <div class="req__col">
                                    <a href="" class="js-del-step-form is-or-link"><i class="fas fa-trash-alt"></i></a>
                                </div>
                                <div class="req__col">
                                    <input type="text" name="detail[]" class="requests-col__input" id="" placeholder="Название детали">
                                    <!--  -->
                                    <input type="text" name="catalog_num[]" class="requests-col__input" id="" placeholder="Номер в каталогах">
                                    <!--  -->
                                    <a href="#" data-openajax="img-upload" class="is-blue-link add-requests__label">
                                        <i class="fa fa-paperclip i-left-20"></i>
                                        <span>Прикрепить фото</span>
                                    </a>
                                </div>
                            </div>
                            <!--  -->

                            <div class="requests__add-row">
                                <a href="" class="requests__add-eq is-or-link">
                                    <i class="fas fa-plus"></i>
                                    <span>Добавить еще одну позицию</span>
                                </a>
                            </div>

                            <button type="submit" class="requests__next-step is-last-item btn-primary2 btn ripple-effect">Продолжить</button>
                        </form>
                    </div>
                    <!--  end Блок с формой  -->
                </div>
            </div>
            <div class="page-content-form__right">
                <div class="request-lvl__block is-rounded is-mtop-30 is-box-shadow">
                    Уровень заполненности

                    <div class="request-lvl__slider">
                        <div class="counter round-counter" id="counter-form-fill">
                            <div class="rs-handle"></div>
                        </div>
                    </div>

                    <span class="is-or-text is-mtop-10 request-lvl__descr lvl-descr__second">Средний</span>
                    <span class="is-grey-text is-mtop-20">Дополнительные сведения о технике, котрая указана на предыдущем шаге.</span>
                </div>
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->



    </div>
</main>