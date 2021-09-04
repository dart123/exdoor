<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.11.16
 * Time: 17:03
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
                        <b>Заявка #<?php echo $request_data->id;?>.</b> <?php echo $request_equipment->brand_name;?>, <?php echo $request_equipment->appointment_name;?>, <?php echo $request_equipment->serial_number;?>
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

                        <p>
                            <span class="requests-ind is-grey-text">Производитель:</span>
                            <span class="requests-descr is-long-row"><?php echo $request_equipment->brand_name;?></span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Назначение:</span>
                            <span class="requests-descr is-long-row"><?php echo $request_equipment->appointment_name;?> &nbsp;</span>
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
                <!--  Заголовок позициии -->
                <div class="requests-step__line is-mtop-20">
                    <div class="requests-step__title">
                        Запрашиваемые позиции
                    </div>
                </div>
                <!--  Запрашиваемые позиции -->
                <div class="requests-eq__block is-rounded is-box-shadow is-mtop-20">
                    <!--  Позиция номер 1 -->
                    <?php
                        $r_i = 1;
                        foreach ($request_positions as $r_position):
                    ?>
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
                                        <!--
                                        <a href="#" data-open-id="album-3" class="requests-eq__img requests-eq__img--more open-album">
                                            <div class="requests-eq__inner">
                                                <img src="img/content/eq-img.jpg" alt="">
                                            </div>
                                        </a>
                                        -->
                                    </div>
                                </div>
                            </div>
                    <?php
                            $r_i++;
                        endforeach;
                    ?>
                </div>
            </div>

            <!--  Правый блок контента -->
            <div class="page-content-form__right">
                <!--  Заголовок -->
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        Статус и управление заявкой
                    </div>
                    <a href="#req__cancel" class="requests-step__action is-or-link fancybox"><span>Отменить заявку</span></a>
                </div>
                <!--  Блок статуса -->
                <?php if( $request_data->executor == 0 ):?>
                <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                    <div class="req-status__title is-first-item">Сформирована (отправлена)</div>
                    <div class="req-status__content">
                        <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>
                    </div>
                </div>
                <?php endif;?>
                <!--  Заголовок 2 -->
                <div class="requests-step__line is-mtop-20">
                    <div class="requests-step__title">
                        Получатели заявки и статус обработки
                    </div>
                </div>
                <!--  Получатели -->
                <div class="requests-step__addressee is-rounded is-box-shadow is-mtop-20 req-addressee__list clear">
                    <ul>
                        <?php
                        if( $request_partners ):
                            foreach ( $request_partners as $request_partner ):
                            ?>
                            <li class="req-addressee__item req-addressee__item--inactive">
                                <a href="/requests/<?php echo $request_data->id;?>/compare" class="req-addressee__link is-fade">
                                    <div class="req-addressee__photo is-rounded">
                                        <?php if( $request_partner->avatar ):?>
                                            <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                        <?php endif;?>
                                    </div>
                                    <div class="req-addressee__descr">
                                        <div class="req-addressee__name is-blue-text is-fade"><b><?php echo $request_partner->name;?></b></div>
                                        <div class="req-addressee__answer"><?php echo $request_partner->status;?></div>
                                    </div>
                                </a>
                            </li>
                            <?php
                            endforeach;
                        endif;?>
                    </ul>
                </div>
                <!--  Ссылка "Сравнить" -->
                <div class="requests-step__line compare-link is-mtop-20">
                    <a href="/requests/<?php echo $request_data->id;?>/compare" class="is-or-link"><span>Сравнить предложения</span></a>
                </div>
                <!--  Заголовок 3 -->
                <div class="requests-step__line is-mtop-20">
                    <div class="requests-step__title">
                        Автор заявки (Вы)
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
        <div id="gallery_three" class="modal__block">
            <a data-fancybox="album-3" class="image-show" href="img/content/eq-img.jpg">
                <img src="img/content/eq-img.jpg" alt=""/>
            </a>
            <a data-fancybox="album-3" class="image-show" href="img/content/news-advpost-01.jpg">
                <img src="img/content/news-advpost-01.jpg" alt=""/>
            </a>
            <a data-fancybox="album-3" class="image-show" href="img/content/news-advpost-02.jpg">
                <img src="img/content/news-advpost-02.jpg" alt=""/>
            </a>
        </div>
        <!--  -->
    </div>
</main>