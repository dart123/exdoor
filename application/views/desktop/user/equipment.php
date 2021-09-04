<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 18:10
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
    <div class="eq__add-new is-rounded is-box-shadow">
        <a href="#add-equipment" class="eq__add-btn or-btn btn btn-info ripple-effect fancybox">
            <i class="fas fa-plus"></i>
            Добавить технику
        </a>
    </div>

    <div class="eq__wrap is-rounded is-box-shadow is-mtop-20">

        <div class="eq__form-sidebar">
            <form action="">
                <div class="advpost__check-block" id="eq-group-01">
                    <div class="eq__form-title"><b>Производители</b></div>

                    <input type="checkbox" class="eq__checkbox" id="equipment-name-01">
                    <label class="eq__label" for="equipment-name-01">CATERPILLAR <span>(2)</span></label>

                    <input type="checkbox" class="eq__checkbox" id="equipment-name-02">
                    <label class="eq__label is-last-el" for="equipment-name-02">RESSTA <span>(1)</span></label>

                    <a href="" rel="eq-group-01" class="eq__check-all is-blue-link"><span>Все</span></a>

                    <a href="" rel="eq-group-01" class="eq__check-none is-blue-link slide-hidden"><span>Ничего</span></a>
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
<section class="page-content-masonry">
    <!-- Блок списка техники -->


    <?php if ($equipment):?>
    <ul class="eq__block">
        <!-- Карточка техники  -->
        <?php foreach ( $equipment as $eq):?>
            <li class="eq__item is-box-shadow is-rounded">
                <!-- Картинка карточки -->
                <div class="eq-desrc__image">
                    <img src="img/content/eq-img.jpg" class="eq-photo" alt="">
                </div>

                <!-- Текст карточки -->
                <div class="eq-desrc__text">
                    <p><b>AP10500E</b>, <?php echo $eq->brand;?> <?php echo $eq->model;?></p>
                    <p><?php echo $eq->appointment;?></p>
                    <p>SN — <b><?php echo $eq->serial_number;?></b>   |   <?php echo $eq->year;?> г.в.</p>
                    <p>Двигатель — <?php echo $eq->engine;?></p>
                    <p class="is-grey-text"><i class="fas fa-thumbtack"></i><?php echo $eq->section;?></p>

                    <div class="req-item__helpers">
                        <ul class="req-item__actions is-rounded is-box-shadow">
                            <li class="is-first-item">Редактировать</li>
                            <li class="is-last-item"><a href="?action=remove_item&id=<?php echo $eq->id;?>">Удалить</a></li>
                        </ul>
                    </div>
                </div>

                <div class="eq-desrc__create">
                    <a href="index-29.html" target="_blank" class="create__request is-blue-link">
                        <i class="fas fa-plus"></i><i class="fa fa-list-alt"></i>
                        <span>Создать заявку</span>
                    </a>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
    <?php else: ?>
        <script>
            $(document).ready(function () {
                $('.eq__add-btn').click();
            })
        </script>
    <?php endif;?>
    <!-- Кнопка Подгружаю еще -->
</section>
<!-- Кнопка Наверх -->

<!-- Добавить технику -->
<div id="add-equipment" class="modal is-rounded">
    <div class="modal__head is-rounded">
        <div class="modal__title">Новая техника</div>
        <?php if ($equipment != false):?>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
        <?php endif;?>
    </div>
    <form action="" method="POST">
        <input type="hidden" name="action" value="add_new_item">
        <input type="hidden" name="owner" value="<?php echo $this->session->user;?>" >
        <div class="modal__body">

            <div class="modal__filled">
                Заполнено
                <div id="eq__progressbar">
                    <span class="eq__progressval"><i>0%</i></span>
                </div>
            </div>
            <div class="eq__form">
                <label for="eq__brand" class="eq__line-label clear"><span>Производитель</span>
                    <select id="eq__brand" name="brand" class="eq__val select-box is-placeholder">
                        <option value="" selected>Выбрать бренд из списка</option>
                        <option value="Самая крупная компания">Самая крупная компания</option>
                        <option value="Компания и сервис A">Компания и сервис A</option>
                        <option value="Компания B">Компания B</option>
                        <option value="Inc C">Inc C</option>
                        <option value="Company D">Company D</option>
                    </select>
                </label>

                <label for="eq__type" class="eq__line-label clear"><span>Назначение</span>
                    <select id="eq__type" name="appointment" class="eq__val select-box is-placeholder">
                        <option value="" selected>Выберите тип техники</option>
                        <option value="Самая крупная компания">Самая крупная компания</option>
                        <option value="Компания и сервис A">Компания и сервис A</option>
                        <option value="Компания B">Компания B</option>
                        <option value="Inc C">Inc C</option>
                        <option value="Company D">Company D</option>
                    </select>
                </label>

                <label for="eq__model" class="eq__line-label clear"><span>Модель</span>
                    <input type="text" name="model" id="eq__model" class="eq__val" placeholder="В соответствии с техпаспортом" required>
                </label>

                <label for="eq__sn" class="eq__line-label clear"><span>Серийный номер</span>
                    <input type="text" name="serial_number" id="eq__sn" class="eq__val" placeholder="SN">
                </label>

                <label for="eq__motor" class="eq__line-label clear"><span>Двигатель</span>
                    <input type="text" name="engine" id="eq__motor" class="eq__val" placeholder="Код">
                </label>

                <label for="eq__year" class="eq__line-label clear"><span>Год выпуска</span>
                    <input type="number" name="year" id="eq__year" class="eq__val" placeholder="ГГГГ" min="1900" max="2020">
                </label>

                <label for="eq__unit" class="eq__line-label clear"><span>Подразделение</span>
                    <input type="text" name="section" id="eq__unit" class="eq__val" placeholder="Например, автобаза №15">
                    <div class="tooltip">
                        <i class="fa fa-question"></i>
                        <div class="tooltip__msg is-rounded is-box-shadow is-fade">Подсказка с текстом, описывающая информацию, которая полезна будет для заполнения поля.</div>
                    </div>
                </label>

                <div class="add-equipment__file--wrap">
                    <!-- загрузка фото -->
                    <div class="add-advpost__file--wrap">
                        <input type="file" accept="image/jpeg,image/png*" id="fileElem" class="eq__val" multiple="" style="display:none" onchange="handleFiles(this.files);" >
                        <a href="#" id="fileSelect" class="is-blue-link add-requests__label" onClick="uploadImg(event);">
                            <i class="fa fa-paperclip i-left-20"></i>
                            <span>Прикрепить фото</span>
                        </a>
                    </div>
                </div>
                <ul id="filelist" class="clear"></ul>
                <!-- -->
            </div>
        </div>
        <div class="modal__footer">
            <span class="add-equipment__submit--wrap is-last-item btn ripple-effect btn-primary2 ">
                <i class="fas fa-check"></i>
                <input type="submit" class="add-equipment__submit " value="Добавить в парк">
            </span>
        </div>
    </form>
</div>
</div>
</main>
