<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.11.16
 * Time: 17:10
 */

?>


<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар отсутствует -->
        <!-- Контент -->
        <section class="page-content-form left-400 full-request">
            <pre>
                <?php var_dump($request_data);?>
                <hr>
                <?php var_dump($request_equipment);?>

            </pre>
            <!--  Левый блок контента -->
            <div class="page-content-form__left">
                <!--  Заголовок заявки -->
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        <b>Заявка #<?php echo $request_data->id;?>.</b><?php echo $request_equipment->brand_name;?>, <?php echo $request_equipment->appointment;?>, <?php echo $request_equipment->model;?>
                    </div>
                </div>
                <!--  Блок заявки -->
                <div class="requests-info__block is-rounded is-box-shadow is-mtop-20">
                    <div class="requests-info__photo">
                        <?php if ($request_equipment->thumbnail != false):?>
                            <img src="/uploads/equipment/<?php echo $request_equipment->id;?>/<?php echo $request_equipment->thumbnail;?>" class="img-responsive">
                        <?php endif;?>
                    </div>
                    <div class="requests-info__content">
                        <?php if( $request_equipment ):?>
                            <?php if( $request_equipment->brand ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Производитель:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->brand_name;?></span>
                                </p>
                            <?php endif;?>
                            <?php if( $request_equipment->appointment ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Назначение:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->appointment_name;?></span>
                                </p>
                            <?php endif;?>
                            <?php if( $request_equipment->model ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Модель:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->model;?></span>
                                </p>
                            <?php endif;?>
                            <?php if( $request_equipment->serial_number ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Серийный номер:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->serial_number;?></span>
                                </p>
                            <?php endif;?>
                            <?php if( $request_equipment->engine ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Двигатель:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->engine;?></span>
                                </p>
                            <?php endif;?>
                            <?php if( $request_equipment->year ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Год выпуска:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->year;?></span>
                                </p>
                            <?php endif;?>
                            <?php if( $request_equipment->section ):?>
                                <p>
                                    <span class="requests-ind is-grey-text">Подразделение:</span>
                                    <span class="requests-descr is-long-row"><?php echo $request_equipment->section;?></span>
                                </p>
                            <?php endif;?>
                        <?php endif;?>

                        <p>
                            <span class="requests-descr"><a href="" data-openajax="img-upload" class="is-blue-link"><span>8 фотографий</span></a></span>
                        </p>
                    </div>
                </div>

                <!--  Заголовок позициии -->
                <div class="requests-step__line is-mtop-20">
                    <div class="requests-step__title">
                        Запрашиваемые позиции
                    </div>
                </div>
                <!--  Запрашиваемые позиции -->
                <div class="requests-eq__block is-rounded is-box-shadow is-mtop-20">
                    <form action="">
                        <!--  Позиция номер 1 -->
                        <?php
                            if( $request_positions ):
                                $i = 1;
                                foreach ($request_positions as $position ):
                                ?>
                                    <div class="requests-eq__item">

                                        <div class="requests-eq__pos-row">
                                            <div class="requests-eq__no"><b>#<?php echo $i;?></b></div><!--
                                             --><div class="requests-eq__pos-descr">
                                                <div class="position-name is-grey-text">
                                                    <p>Деталь:</p>
                                                    <p>Номер в каталогах</p>
                                                </div>
                                                <div class="position-name">
                                                    <p><?php echo $position->detail;?></p>
                                                    <p><?php echo $position->catalog_num;?></p>
                                                </div>
                                                <!--
                                                <a href="#" data-open-id="album-1" class="requests-eq__img requests-eq__img--1 open-album">
                                                    <div class="requests-eq__inner">
                                                        <img src="img/content/eq-img.jpg" alt="">
                                                    </div>
                                                </a>
                                                -->
                                            </div>
                                        </div>

                                        <div class="requests-eq__form">
                                            <div class="requests-eq__radio--line">
                                                <span class="is-grey-text position-label">Наличие:</span>
                                                <div class="requests-eq__radio--cover">
                                                    <input type="radio" class="radio requests-eq__is" name="requests-eq__radio-01" id="requests-eq__is" checked>
                                                    <label for="requests-eq__is" class="radio__label">Есть в наличии</label>

                                                    <input type="radio" class="radio requests-eq__isnot" name="requests-eq__radio-01" id="requests-eq__isnot">
                                                    <label for="requests-eq__isnot" class="radio__label">Нет в наличии</label>
                                                </div>
                                            </div>

                                            <label for="" class="requests-eq__label js-supply" style="display: none;">
                                                <span class="is-grey-text position-label">Срок поставки:</span>
                                                <input type="text" class="requests-eq__input--full numHyp" placeholder="Количество рабочих дней (цифры, дефис)">
                                            </label>

                                            <label for="" class="requests-eq__label">
                                                    <span class="is-grey-text position-label">Цена,
                                                        <select id="advpost__theme-name">
                                                            <option value="">Р, рубли</option>
                                                            <option value="">$, доллар</option>
                                                        </select>
                                                    </span>
                                                <input type="number" class="requests-eq__input--full" placeholder="Цифрами" pattern="[0-9]{10}">
                                            </label>
                                        </div>
                                    </div>
                                <?php
                                $i++;
                                endforeach;
                            endif;
                        ?>
                        <div class="requests-eq__item">
                            <div class="requests-eq__form--time">
                                <div class="requests-eq__label">
                                    <span class="is-grey-text position-label">Актуально до:</span>

                                    <input type="text" id="datepicker" placeholder="дд.мм.гггг" class="requests-eq__date date-num"><i class="fa fa-calendar i-date"></i>
                                </div>

                                <label for="" class="requests-eq__label clear">
                                    <span class="is-grey-text position-label">Комментарий</span>
                                    <textarea id="advpost__ta-posttext" class="requests-eq__input--full" placeholder="Добавить комментарий о возможной скидке"></textarea>
                                </label>
                            </div>
                        </div>

                        <a href="" class="requests__submit is-last-item btn-primary2 btn ripple-effect">
                            <i class="fa fa-paper-plane i-left-20 "></i>
                            <span>Отправить на заявку</span>
                        </a>
                    </form>
                </div>
            </div>

            <!--  Правый блок контента -->
            <div class="page-content-form__right">
                <!--  Заголовок -->
                <?php if( $request_author->id == $this->session->user):?>
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        Статус и управление заявкой
                    </div>
                    <a href="#req__cancel" class="requests-step__action is-or-link fancybox"><span>Отменить заявку</span></a>
                </div>
                <?php endif;?>
                <!--  Блок статуса -->
                <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                    <div class="req-status__title is-first-item">Сформирована (в обработке)</div>
                    <div class="req-status__content">
                        <p>Пожалуйста, дайте свою оценку запрашиваемых позиций и отправьте ответ автору</p>
                    </div>
                </div>
                <?php if( $request_author ):?>
                <!--  Заголовок 2 -->
                <div class="requests-step__line is-mtop-20">
                    <div class="requests-step__title">
                        Автор заявки <?php if( $request_author->id == $this->session->user):?>(Вы)<?php endif;?>
                    </div>
                </div>
                <!--  Автор заявки -->
                <div class="requests-step__author req-author is-rounded is-box-shadow is-mtop-20 clear">

                    <?php if ( $request_author->avatar ):?>
                        <a href="" class="req-author__image is-rounded">
                            <img src="/uploads/users/<?php echo $request_author->id;?>/avatar/80x80_<?php echo $request_author->avatar;?>" alt="" class="img-responsive">
                        </a>
                    <?php endif;?>

                    <div class="req-author__content">
                        <div class="is-long-row">
                            <a href="" class="is-blue-link"><span><b><?php echo $request_author->name;?> <?php echo $request_author->second_name;?> <?php echo $request_author->last_name;?></b></span></a>
                        </div>
                        <div class="is-long-row">
                            <a href="" class="is-grey-link"><span>СпецДорПокрБригада</span></a>
                        </div>
                        <div class="company-profile__rating-level rate__lvl rate__lvl--4"></div>
                        <?php if( $request_author->id != $this->session->user):?>
                        <div>
                            <a class="js-partner__open_chat is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_author->id;?>">
                                <i class="fas fa-envelope i-left-15"></i>
                                <span>Написать сообщение</span>
                            </a>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif;?>
            </div>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

        <!--  Подверждение  -->
        <div id="req__cancel" class="modal__block is-rounded">
            <div class="modal__head modal__head--blue is-first-item">
                <div class="modal__title">Ответ на заявку</div>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>

            <div class="modal__content">
                <h2>Удалить заявку?</h2>
                <p>Вы действительно хотите отменить данную заявку на этом этапе? Подтверждая свой выбор, Вы даете согласие на полное удаление заявки из списка активных.</p>
                <div class="confirm__block">
                    <a href="" class="confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                        <i class="fas fa-check"></i>
                        <span>Да, удалить</span>
                    </a>

                    <a href="" class="confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                        <i class="fas fa-times"></i>
                        <span>Нет, отмена</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- end Подверждение -->

        <!-- Галерея фото -->
        <div id="gallery_one" class="modal__block">
            <a rel="album-1" class="image-show" href="img/content/eq-img.jpg">
                <img src="img/content/eq-img.jpg" alt=""/>
            </a>
        </div>
        <!--  -->

    </div>
</main>
