<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.02.17
 * Time: 15:33
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

            <!--  Левый блок контента -->
            <div class="page-content-form__left">

                <?php
                    $this->load->view('desktop/requests/html_block__ready__title');
                    $this->load->view('desktop/requests/html_block__ready__equipment');
                ?>

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

                    $total_price_rub    = 0;
                    $total_price_usd    = 0;

                    foreach ( $request_positions as $position ):
                        if( is_array($request_executor->responses) && array_key_exists( $position->id, $request_executor->responses)):
                            ?>
                            <div class="requests-eq__item">
                                <div class="requests-eq__pos-row">
                                    <div class="requests-eq__no"><b>#<?php echo $position->id;?></b></div><!--
                                     --><div class="requests-eq__pos-descr">
                                        <div class="position-name is-grey-text">

                                            <?php if( $position->detail ):?>
                                                <p>Деталь:</p>
                                            <?php endif;?>
                                            <?php if( $position->catalog_num ):?>
                                                <p>Номер в каталогах:</p>
                                            <?php endif;?>

                                            <?php if( $position->amount > 1 ):?>
                                                <p>Цена за единицу:</p>
                                            <?php endif;?>
                                            <p class="is-or-text is-highlight-l">Итого:</p>
                                        </div><!--
                                         --><div class="position-name">

                                            <?php if( $position->detail ):?>
                                                <?php if( mb_strlen( $position->detail, 'utf8'  ) >= 12 ):?>
                                                    <span class="tooltip tooltip__request_positions">
                                                        <p><?php echo $position->detail;?></p>
                                                        <span class="tooltip__msg">
                                                            <?php echo $position->detail;?>
                                                        </span>
                                                    </span>
                                                <?php else:?>
                                                    <p><?php echo $position->detail;?></p>
                                                <?php endif;?>
                                            <?php endif;?>

                                            <?php if( $position->catalog_num ):?>
                                                <?php if( mb_strlen( $position->catalog_num , 'utf8' ) >= 12 ):?>
                                                    <span class="tooltip tooltip__request_positions">
                                                        <p>
                                                            <?php echo $position->catalog_num;?>
                                                        </p>
                                                        <span class="tooltip__msg">
                                                            <?php echo $position->catalog_num;?>
                                                        </span>
                                                    </span>
                                                <?php else:?>
                                                    <p><?php echo $position->catalog_num;?></p>
                                                <?php endif;?>
                                            <?php endif;?>

                                            <p class="request_position__amount js__amount__position_<?php echo $position->id;?>" data-amount="<?php echo $position->amount;?>"><?php echo $position->amount;?> шт.</p>


                                            <?php if(  $request_executor->responses || ( !$request_executor->responses && $user_relation->status != 'canceled' )  ):?>
                                                <?php if( ( $request_executor->responses && is_array($request_executor->responses) && array_key_exists($position->id, $request_executor->responses) &&  $request_executor->responses[$position->id]->in_stock == 1 ) || $request_executor->responses == false  ):?>
                                                    <p class="request_position__report__in_stock">В наличии</p>
                                                <?php else:?>
                                                    <?php if( $request_executor->responses[$position->id]->shipping != ''  ):?>
                                                        <p class="request_position__report__in_stock is-grey-text"><i class="far fa-clock"></i> Поставка через <?php echo $request_executor->responses[$position->id]->shipping;?> дн.</p>
                                                    <?php else:?>
                                                        <p class="request_position__report__in_stock is-grey-text">Нет в наличии</p>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            <?php endif;?>

                                            <?php if( $position->amount > 1 ):?>
                                            <p>
                                                <?php echo number_format($request_executor->responses[$position->id]->price, 0, ',', ' ');?>

                                                <?php if ($request_executor->responses[$position->id]->currency == 'RUB'):?>
                                                    <i class="fa fa-rub"></i>
                                                <?php else:?>
                                                    <span>$</span>
                                                <?php endif;?>


                                            </p>
                                            <?php endif;?>

                                            <p class="is-highlight-r">

                                                <?php
                                                    $position_summa     = $position->amount*$request_executor->responses[$position->id]->price;

                                                    if ($request_executor->responses[$position->id]->currency == 'RUB'):
                                                        $total_price_rub    += $position_summa;
                                                    elseif ($request_executor->responses[$position->id]->currency == 'USD'):
                                                        $total_price_usd    += $position_summa;
                                                    endif;

                                                    ?>
                                                    <b>
                                                        <?php echo number_format($position_summa, 0, ',', ' ');?>

                                                        <?php if ($request_executor->responses[$position->id]->currency == 'RUB'):?>
                                                            <i class="fa fa-rub"></i>
                                                        <?php else:?>
                                                            <span>$</span>
                                                        <?php endif;?>
                                                    </b>

                                            </p>

                                        </div>

                                        <?php if (!empty($position->images_arr)):?>
                                            <a href="#" data-open-id="album-<?php echo $position->id;?>" class="requests-eq__img <?php if( count($position->images_arr) == 1):?>requests-eq__img--1<?php elseif( count($position->images_arr) == 2):?>requests-eq__img--2<?php elseif(count($position->images_arr) > 2):?>requests-eq__img--more<?php endif;?> open-album">
                                                <div class="requests-eq__inner">
                                                    <img src="/uploads/requests/<?php echo $request_data->id;?>/158x158_<?php echo $position->images_arr[0];?>" alt="">
                                                </div>
                                            </a>
                                        <?php endif;?>

                                        <?php  /*foreach ($r_position->images_arr as $img):?>
                                            <a rel="album-<?php echo $r_position->id;?>" class="image-show" href="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>">
                                                <img src="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>" alt=""/>
                                            </a>
                                        <?php endforeach; */?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    endforeach;
                    ?>

                    <div class="requests-eq__item">
                        <div class="requests-eq__pos-row">
                            <div class="requests-eq__no"></div><!--
                                     --><div class="requests-eq__pos-descr">
                                <div class="position-name is-or-text">

                                    <p><b>Общая сумма:</b></p>
                                </div><!--
                                         --><div class="position-name">
                                                <p>
                                                    <b>
                                                        <?php if( $total_price_rub > 0 && $total_price_usd > 0 ):?>
                                                            <?php echo number_format($total_price_rub, 0, ',', ' ');?> <i class="fa fa-rub"></i> и <?php echo number_format($total_price_usd, 0, ',', ' ');?> <i class="fa fa-usd"></i>
                                                        <?php elseif( $total_price_rub > 0 && $total_price_usd == 0 ) :?>
                                                            <?php echo number_format($total_price_rub, 0, ',', ' ');?> <i class="fa fa-rub"></i>
                                                        <?php elseif( $total_price_rub == 0 && $total_price_usd > 0 ) :?>
                                                            <?php echo number_format($total_price_usd, 0, ',', ' ');?> <span>$</span>
                                                        <?php endif;?>
                                                    </b>

                                                </p>
                                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if( $request_executor->request_response_data->comment):?>
                    <!--  Заголовок комментария -->
                    <div class="requests-step__line is-mtop-20">
                        <div class="requests-step__title">
                            Комментарий исполнителя
                        </div>
                    </div>
                    <!--  Блок комментария -->
                    <div class="requests-comment__block is-rounded is-box-shadow is-mtop-20 clear">
                        <?php if( $request_executor->avatar ):?>
                            <a href="/partners/<?php echo $request_executor->user_id;?>" class="req-author__image__comment req-author__image req-author__image--image_exists is-rounded">
                                <img src="/uploads/users/<?php echo $request_executor->user_id;?>/avatar/80x80_<?php echo $request_executor->avatar;?>" alt="">
                            </a>
                        <?php else:?>
                            <a href="/partners/<?php echo $request_executor->user_id;?>" class="req-author__image req-author__image__comment is-rounded">
                            </a>
                        <?php endif;?>
                        <div class="req-addressee__descr">
                            <div class="req-addressee__comment"><?php echo $request_executor->request_response_data->comment;?></div>
                        </div>


                        <?php if (mb_strlen( $request_executor->request_response_data->comment, 'utf8' ) > 77):?>
                            <a class="js__show_full_comment req-addressee__msg is-blue-link pointer">
                                <span>Показать полностью</span>
                            </a>
                        <?php endif;?>


                        <?php if( $request_executor->user_id != $this->session->user):?>
                            <a class="js-partner__open_chat req-addressee__msg is-blue-link pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_executor->user_id;?>">
                                <span>Открыть диалог</span>
                            </a>
                        <?php endif;?>


                    </div>
                <?php endif;?>
            </div>

            <!--  Правый блок контента -->
            <div class="page-content-form__right">
                <!--  Заголовок -->
                <?php

                switch ( $request_data->status ){
                    case 'in_process':
                        $request_state_class    = 'requests-step__status--active';
                        $request_state_text     = 'В работе (ожидает оплаты)';
                        break;
                    case 'payed':
                        $request_state_class    = 'requests-step__status--active';
                        $request_state_text     = 'В работе (оплачено, ожидает отгрузки)';
                        break;
                    case 'delivered':
                        $request_state_class    = 'requests-step__status--active';
                        $request_state_text     = 'В работе (отгружено, ожидает оплаты)';
                        break;
                    case 'payed_delivered':
                        $request_state_class    = 'requests-step__status--active';
                        $request_state_text     = 'В работе (оплачено и отгружено)';
                        break;
                    case 'canceled':
                        $request_state_class    = 'requests-step__status--canceled';
                        $request_state_text     = 'Отменена';
                        break;
                    case 'done':
                        $request_state_class    = 'requests-step__status--done';
                        $request_state_text     = 'Завершена';
                        break;
                    case 'finished':
                        $request_state_class    = 'requests-step__status--done';
                        $request_state_text     = 'Завершена';
                        break;
                    default:
                        $request_state_text = 'Ошибка: обратитесь к администратору.';
                        break;
                }
                /*
                 *
                 *
                 *
                 *
                 *  Если это автор заявки
                 *      - Он может завершить заявку по клику
                 *      - Он может в любой момент отменить заявку
                 *
                 *
                 *
                 *
                 */

                if( $request_author->id == $this->session->user ):

                    ?>
                    <div class="requests-step__line">
                        <div class="requests-step__title">
                            Статус и управление заявкой
                        </div>
                        <?php if( $request_data->status != 'canceled' && $request_data->status != 'done' && $request_data->status != 'finished' ):?>
                            <a class="requests-step__action is-or-link pointer js__requests_list__author_denied" data-request-id="<?php echo $request_data->id;?>" data-page-reload="yes">
                                <span>Отменить заявку</span>
                            </a>
                        <?php endif;?>
                    </div>
                    <!--  Блок статуса -->
                    <div class="requests-step__status <?php echo $request_state_class;?> is-rounded is-box-shadow is-mtop-20 req-status">
                        <div class="req-status__title is-first-item">
                            <?php echo $request_state_text;?>
                        </div>


                    <?php
                        // Если заявка в статусе done - рейтинг выставляется по завершению
                        if ( $request_data->status == 'done' ):?>
                            <div class="req-status__content">
                                <a href="#req__rating" class="fancybox__rating_modal is-blue-link pointer">
                                    <span>
                                        Подтвердить завершение заявки
                                    </span>
                                </a>
                            </div>
                        <?php else:
                            // если заявка не требует подтверждения

                            if( $request_data->rating_executor ):?>
                                <div class="req-status__content">
                                    <form method="POST" >
                                        Вы оценили работу партнера: <div class='req-controls__rating-level rate__lvl rate__lvl--<?php echo $request_data->rating_executor;?>'></div><br>
                                        <?php if($request_data->can__set_rating):?><a href="#req__rating" class="fancybox is-blue-link"><i class="fas fa-pen"></i> <span>Изменить оценку</span></a><?php endif;?>
                                    </form>
                                </div>
                            <?php else:?>

                                <div class="req-status__content">
                                    <form method="POST" >
                                        <a href="#req__rating" class="fancybox__rating_modal is-blue-link">
                                            <i class="fa fa-star"></i>&nbsp;<span>Оценить работу партнера</span>
                                        </a>
                                        <?php if ( $request_data->status != 'finished' ):?>до завершения заявки<?php endif;?>
                                    </form>
                                </div>
                            <?php endif;?>

                        <?php endif;?>



                        <div class="req-status__content" style="border-top:1px solid #e5e5e5">
                            <div class="">
                                <a href="/requests/<?php echo $request_data->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                    <span>Просмотреть ответы</span>
                                </a>
                            </div>
                        </div>



                </div>
                <?php else:

                    /*
                     *
                     *
                     *
                     *  Пользователь - исполнитель заявки
                     *      - Он может менять статусы заявки
                     *      - Он может отклонить зявку
                     *
                     *
                     *
                     */



                    ?>



                    <div class="requests-step__line">
                        <div class="requests-step__title">
                            Статус и управление заявкой
                        </div>
                    <?php if( $request_data->status != 'canceled' && $request_data->status != 'done' && $request_data->status != 'finished' ):?>
                        <a class="requests-step__action is-or-link pointer js__requests_list__partner_denied" data-request-id="<?php echo $request_data->id;?>" data-page-reload="yes">
                            <span>Отклонить заявку</span>
                        </a>
                    <?php endif;?>
                    </div>

                    <div class="requests-step__status <?php echo $request_state_class;?> is-rounded is-box-shadow is-mtop-20 req-status">
                        <div class="req-status__title is-first-item">
                            <?php echo $request_state_text;?>
                        </div>

                        <?php if ($request_data->status != 'finished' && $request_data->status != 'canceled'):?>
                        <div class="req-status__content">
                            <p><b>Изименить статус заявки:</b></p>
                            <form method="POST" id="js__form__request_status">
                                <input type="hidden" name="action" value="update_request_status">
                                <input type="hidden" name="request_id" value="<?php echo $request_data->id;?>">
                                <div>
                                    <input type="checkbox" name="request_status__payed" value="1" class="req-status__checkbox js__form__request_status__checkbox" id="req-status-01" <?php if( $request_data->status == 'payed' ||  $request_data->status == 'payed_delivered' ||  $request_data->status == 'done'):?>checked<?php endif;?> <?php if( $request_data->status == 'done' || $request_data->status == 'finished' ):?>disabled<?php endif;?>>
                                    <label class="req-status__label" for="req-status-01">Оплачено</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="request_status__delivered" value="1" class="req-status__checkbox js__form__request_status__checkbox" id="req-status-02" <?php if( $request_data->status == 'delivered' || $request_data->status == 'payed_delivered' || $request_data->status == 'done'):?>checked<?php endif;?> <?php if( $request_data->status == 'done' || $request_data->status == 'finished' ):?>disabled<?php endif;?>>
                                    <label class="req-status__label" for="req-status-02">Отгружено</label>
                                </div>
                                <div class="is-last-el">
                                    <input type="checkbox" name="request_status__done" value="1" class="req-status__checkbox js__form__request_status__checkbox" id="req-status-03" <?php if( $request_data->status == 'done'):?>checked<?php endif;?> <?php if( $request_data->status != 'payed_delivered'  ):?>disabled<?php endif;?>>
                                    <label class="req-status__label is-last-el" for="req-status-03">Завершена</label>
                                </div>
                            </form>
                        </div>
                        <?php endif;?>

                            <div class="req-status__content" style="border-top:1px solid #e5e5e5">
                                <?php if( $request_data->rating_author ):?>
                                    Вы оценили работу партнера: <div class='req-controls__rating-level rate__lvl rate__lvl--<?php echo $request_data->rating_author;?>'></div><br>
                                    <?php if( $request_data->can__set_rating):?><a href="#req__rating" class="fancybox is-blue-link"><i class="fas fa-pen"></i> <span>Изменить оценку</span></a><?php endif;?>
                                <?php elseif ( $request_data->can__set_rating):?>
                                    Вы можете оценить работу партнера когда он подтвердит завершение работ по заявке, либо
                                    <a href="#req__rating" class="fancybox is-blue-link">
                                        <i class="fa fa-star"></i>&nbsp;<span>Оцените работу партнера</span>
                                    </a> прямо сейчас
                                <?php endif;?>
                            </div>


                    </div>


                <?php endif;?>




                <?php if( $request_executor ):?>
                    <!--  Заголовок 2 -->
                    <div class="requests-step__line is-mtop-20">
                        <div class="requests-step__title">
                            Исполнитель заявки <?php if( $request_executor->user_id == $this->session->user):?>(Вы)<?php endif;?>
                        </div>
                    </div>
                    <!--  Автор заявки -->
                    <div class="requests-step__author req-author is-rounded is-box-shadow is-mtop-20 clear">

                        <?php if ( $request_executor->avatar ):?>
                            <a href="/partners/<?php echo $request_executor->user_id;?>" class="req-author__image req-author__image--image_exists is-rounded">
                                <img src="/uploads/users/<?php echo $request_executor->user_id;?>/avatar/80x80_<?php echo $request_executor->avatar;?>" alt="" class="img-responsive">
                            </a>
                        <?php else:?>
                            <a href="/partners/<?php echo $request_executor->user_id;?>" class="req-author__image is-rounded ">

                            </a>
                        <?php endif;?>

                        <div class="req-author__content">
                            <div class="is-long-row">
                                <a href="/partners/<?php echo $request_executor->user_id;?>" class="is-blue-link">
                                    <span>
                                        <b>
                                            <?php echo $request_executor->name;?> <?php echo $request_executor->second_name;?> <?php echo $request_executor->last_name;?>
                                        </b>
                                    </span>
                                </a>
                            </div>
                            <div class="is-long-row">
                                <?php if( $request_executor->company ):?>
                                    <a href="/company/id<?php echo $request_executor->company->id;?>" class="is-grey-link"><span><?php echo $request_executor->company->short_name;?></span></a>
                                <?php endif;?>
                            </div>

                            <?php if ($request_executor->rating):?>
                                <div class="company-profile__rating-level rate__lvl--<?php echo intval( $request_executor->rating);?>"></div>
                            <?php endif;?>

                            <?php if( $request_executor->user_id != $this->session->user):?>
                                <div>
                                    <a class="js-partner__open_chat is-blue-link pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_executor->user_id;?>">
                                        <i class="fas fa-envelope i-left-15"></i>
                                        <span>Написать сообщение</span>
                                    </a>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endif;?>



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
                            <a href="/partners/<?php echo $request_author->id;?>" class="req-author__image req-author__image--image_exists is-rounded ">
                                <img src="/uploads/users/<?php echo $request_author->id;?>/avatar/80x80_<?php echo $request_author->avatar;?>" alt="" class="img-responsive">
                            </a>
                        <?php else:?>
                            <a href="/partners/<?php echo $request_author->id;?>" class="req-author__image is-rounded ">
                            </a>
                        <?php endif;?>

                        <div class="req-author__content">
                            <div class="is-long-row">
                                <a href="/partners/<?php echo $request_author->id;?>" class="is-blue-link">
                                    <span>
                                        <b>
                                            <?php echo $request_author->name;?> <?php echo $request_author->second_name;?> <?php echo $request_author->last_name;?>
                                        </b>
                                    </span>
                                </a>
                            </div>
                            <div class="is-long-row">
                                <?php if( $request_author->company ):?>
                                    <a href="/company/id<?php echo $request_author->company->id;?>" class="is-grey-link"><span><?php echo $request_author->company->short_name;?></span></a>
                                <?php endif;?>
                            </div>

                            <?php if ($request_author->rating):?>
                                <div class="company-profile__rating-level rate__lvl--<?php echo intval( $request_author->rating);?>"></div>
                            <?php endif;?>


                            <?php if( $request_author->id != $this->session->user):?>
                                <div>
                                    <a class="js-partner__open_chat pointer is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_author->id;?>">
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
        <div id="req__rating" class="modal__block is-rounded">
            <div class="modal__head modal__head--blue is-first-item">
                <?php if($request_data->status == 'done' && $request_author->id == $this->session->user ):?>
                    <div class="modal__title">Подтвердите завершение заявки</div>
                <?php elseif( $request_data->status == 'payed_delivered' && $request_executor->user_id == $this->session->user ):?>
                    <div class="modal__title">Вы завершаете работу над заявкой</div>
                <?php else:?>
                    <div class="modal__title">Оцените работу партнера</div>
                <?php endif;?>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>

            <div class="modal__content">

                <?php if($request_data->status == 'done' && $request_author->id == $this->session->user):?>
                    <h2>Заявка завершена!</h2>
                    <p>Ваш партнер указал, что заявка завершена. Подтвердите завершение заявки.</p>
                <?php endif;?>

                <?php if( $request_data->status == 'payed_delivered' && $request_executor->user_id == $this->session->user ):?>
                    <h2>Вы завершаете работу над заявкой!</h2>
                    <p>Автор должен будет подтвердить, что заявка завершена.</p>
                <?php endif;?>


                <h2>Оцените работу партнера</h2>


                <?php if($request_data->status == 'done' && $request_author->id == $this->session->user):?>
                    <p>Вы завершаете сотрудничество в рамках данной заявки. Выскажите свое мнение поставив оценку от 1 до 5. Вы сможете изменить рейтинг в течение 7 дней после завершения заявки.</p>
                <?php else:?>
                    <p>Выскажите свое мнение поставив оценку от 1 до 5. Вы сможете изменить рейтинг в течение 7 дней после завершения заявки.</p>
                <?php endif;?>



                <?php if ( $request_author->id == $this->session->user  ):?>
                    <div class="js__set-partners-rating fa-3x <?php if ($request_data->rating_executor > 0): echo 'is-blue-text'; endif;?>" style="text-align: center">
                        <i class="fa-star <?php if ($request_data->rating_executor >= 1): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_01"></i>
                        <i class="fa-star <?php if ($request_data->rating_executor >= 2): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_02"></i>
                        <i class="fa-star <?php if ($request_data->rating_executor >= 3): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_03"></i>
                        <i class="fa-star <?php if ($request_data->rating_executor >= 4): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_04"></i>
                        <i class="fa-star <?php if ($request_data->rating_executor == 5): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_05"></i>
                    </div>
                    <form id="js__rating_form">
                        <input type="hidden" id="js__request_id" value="<?php echo $request_data->id;?>">
                        <input type="hidden" id="js__rating_input" value="<?php echo $request_data->rating_executor;?>">
                    </form>
                <?php elseif(  $request_executor->user_id == $this->session->user ):?>

                    <div class="js__set-partners-rating fa-3x <?php if ($request_data->rating_author > 0): echo 'is-blue-text'; endif;?>" style="text-align: center">
                        <i class="fa-star <?php if ($request_data->rating_author >= 1): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_01"></i>
                        <i class="fa-star <?php if ($request_data->rating_author >= 2): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_02"></i>
                        <i class="fa-star <?php if ($request_data->rating_author >= 3): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_03"></i>
                        <i class="fa-star <?php if ($request_data->rating_author >= 4): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_04"></i>
                        <i class="fa-star <?php if ($request_data->rating_author == 5): echo 'js__rating-done fas'; else: echo 'js__rating-done far '; endif;?> js-rating" id="icon_rating_05"></i>
                    </div>
                    <form id="js__rating_form">
                        <input type="hidden" id="js__request_id" value="<?php echo $request_data->id;?>">
                        <input type="hidden" id="js__rating_input" value="<?php echo $request_data->rating_author;?>">
                    </form>

                <?php endif;?>


                <div class="confirm__block">

                    <?php if($request_data->status == 'done' && $request_author->id == $this->session->user):?>
                        <a class="ajax__confirm-request-finished pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded" data-request-id="<?php echo $request_data->id;?>" data-executor-id="<?php echo $request_data->executor;?>">
                            <i class="fas fa-check"></i>
                            <span>Да, завершена</span>
                        </a>
                    <?php elseif($request_data->status == 'payed_delivered' && $request_executor->user_id == $this->session->user):?>
                        <a class="ajax__confirm-request-finished pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded" data-request-id="<?php echo $request_data->id;?>" data-executor-id="<?php echo $request_data->executor;?>">
                            <i class="fas fa-check"></i>
                            <span>Завершить</span>
                        </a>
                    <?php else:?>
                        <a class="ajax__set-rating pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                            <i class="fas fa-check"></i>
                            <span>Оценить</span>
                        </a>
                    <?php endif;?>

                    <a class="modal__close-btn pointer confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                        <i class="fas fa-times"></i>
                        <span>Закрыть</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- end Подверждение -->


        <div class="modal__block">
            <?php foreach ($request_positions as $r_position):?>
                <?php foreach ($r_position->images_arr as $img):?>
                    <a data-fancybox="album-<?php echo $r_position->id;?>" class="image-show" href="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>">
                        <img src="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>" alt=""/>
                    </a>
                <?php endforeach;?>
            <?php endforeach;?>
        </div>



    </div>
</main>


<?php


    $this->load->view('desktop/requests/html_block__model__cancel_author');
    $this->load->view('desktop/requests/html_block__model__cancel_executor');

    $this->load->view('desktop/misc/js/partners__open_chat');
    $this->load->view('desktop/requests/js/in_process_author_denied');
    $this->load->view('desktop/requests/js/in_process_partner_denied');
    $this->load->view('desktop/requests/js/in_process_confirm_finish');
    $this->load->view('desktop/requests/js/in_process_set_rating');

    $this->load->view('desktop/requests/js/in_process_compare_show_comment');

?>





<?php if( $this->input->get('set_rating') == 'true'):?>
    <script>
        $(document).ready( function() {
            $.fancybox.open({
                src      : '#req__rating',
                closeBtn : false
            })
        })
    </script>
<?php endif;?>
