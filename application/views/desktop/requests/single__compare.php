<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 23.02.2017
 * Time: 17:16
 */
?>


<main class="feedback feedback--nums-3">
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
            <div class="feedback__nums-block">
                <div class="feedback__main-title">Запрашиваемые позиции</div>
                <?php foreach ($request_positions as $r_position):?>
                    <div class="feedback__nums">
                        <span>#1</span>
                        <span>
                            <p><?php echo $r_position->detail;?></p>
                            <p><?php echo $r_position->catalog_num;?></p>
                        </span>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <!-- Правый сайдбар отсутствует -->
        <!-- Контент -->
        <section class="page-content-wide">
            <!--  Основной блок -->
            <div class="feed-back">
                <!--  Заголовок заявки -->
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        <span class="is-blue-text">Исходящая заявка #1351313</span>  /
                        <b>Ответы на заявку:</b>
                        <span class="feedback__check-line">
                                <input type="checkbox" class="request__checkbox" id="req-status-01" rel="answered" checked>
                                <label class="request__label-c" for="req-status-01">3 получено</label>
                            </span>
                        <span class="feedback__check-line">
                                <input type="checkbox" class="request__checkbox"  id="req-status-02" rel="processing" checked>
                                <label class="request__label-c" for="req-status-02">2 ожидается</label>
                            </span>
                        <span class="feedback__check-line">
                                <input type="checkbox" class="request__checkbox" id="req-status-03" rel="rejected" checked>
                                <label class="request__label-c is-last-el" for="req-status-03">2 отклонили заявку</label>
                            </span>
                    </div>
                </div>

                <!--  Блок всех заявок -->
                <div class="feedback__list-cover">
                    <div class="controls">
                        <div class="prevPage"></div><!--
                            --><div class="nextPage"></div>
                    </div>
                    <div class="feedback__list-wrapper scrollbar-inner">
                        <div class="frame feedback__list">
                            <ul class="feedback__sortable">
                                <?php
                                if( $request_partners ):
                                    foreach ( $request_partners as $request_partner ):
                                    ?>
                                    <li class="feedback__item answered">
                                        <div class="feedback__head is-first-item">
                                            <a href="" class="feedback__img">
                                                <?php if( $request_partner->avatar ):?>
                                                    <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                <?php endif;?>
                                            </a>
                                            <div class="feedback__info feedback__info--comment">
                                                <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                <i class="fas fa-comment"></i>
                                            </div>
                                        </div>
                                        <div class="feedback__fix feedback__head--cloned">
                                            <a href="" class="feedback__img">
                                                <img src="img/content/partner-info__photo-05.jpg" alt="">
                                            </a>
                                            <div class="feedback__info feedback__info--comment">
                                                <div class="feedback__name">Дмитрий Медведев</div>
                                                <i class="fas fa-comment"></i>
                                            </div>
                                        </div>
                                        <div class="feedback__content">
                                            <?php foreach ( $request_partner->responses as $r_p_response ):?>
                                                <?php if( $r_p_response->price ):?>
                                                    <div class="feedback__row">
                                                        <div><?php echo $r_p_response->price;?> Р</div>
                                                        <div class="is-grey-text">в наличии</div>
                                                    </div>
                                                <?php else:?>
                                                    <div class="feedback__row">
                                                        <div> - </div>
                                                        <div class="is-grey-text">в наличии</div>
                                                    </div>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                            <div class="feedback__total-row">
                                                <div><b>1 535 432 Р</b></div>
                                                <span class="is-grey-text"><i class="far fa-clock"></i> 14 дней</span>
                                            </div>
                                            <div class="show-helper">
                                                <div class="feedback__comment-row has-comment">
                                                    Сделаем скидку 10%, если закажете у нас с установкой. Готовы приехать в СПб.
                                                </div>
                                            </div>
                                            <a href="#confirm" class="feedback__choose-executant is-last-item fancybox">
                                                <div class="feedback__helper is-last-item">
                                                    <div class="is-grey-link">
                                                        <i class="fa fa-hand-o-up i-left-15"></i>
                                                        <span>Выбрать исполнителя</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                <?php
                                    endforeach;
                                endif;?>

                            </ul>
                        </div>
                    </div>
                </div>
                <!--  end Блок заявки -->
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

        <!--  Подверждение  -->
        <div id="confirm" class="modal__block is-rounded">
            <div class="modal__head modal__head--blue is-first-item">
                <div class="modal__title">Выбор исполнителя</div>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>

            <div class="modal__content">
                <h2>Подвердить статус исполнителя?</h2>
                <p>В качестве исполнителя заявки  Вы выбрали <b>Дмитрия Медведева</b>. После принятия заявки Вашим партнером, Вы не сможете изменить исполнителя.</p>
                <p class="center">Вы готовы подвердить свое решение?</p>
                <div class="confirm__block">
                    <a href="" class="confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                        <i class="fas fa-check"></i>
                        <span>Выбрать</span>
                    </a>

                    <a href="" class="confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                        <i class="fas fa-times"></i>
                        <span>Отменить</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- end Подверждение -->
    </div>
</main>

