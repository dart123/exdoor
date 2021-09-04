<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.17
 * Time: 15:20
 */

?>


<body>

    <?php $this->load->view('mobile/misc/preloader');?>
    <aside class="sidebar">
        <?php
        $this->load->view('mobile/user/page__header', $page_content['menu']);
        $this->load->view('mobile/user/menu_user', $page_content['menu']);
        ?>

    </aside>
    <div class="sidebar-cover"></div>


    <header class="header">
        <div class="container">
            <!-- блоки, видимые на мобильном -->
            <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>

            <?php if( $page_content['menu']["go_back_url"] ):?>
                <div class="header__page-title t-hide request__single__header__go-back">
                    <a href="<?php echo $page_content['menu']["go_back_url"];?>" class="header__go-back is-white-link">
                        <i class="fa fa-caret-left"></i>
                        <span>Назад</span>
                    </a>
                </div>
            <?php endif;?>

            <div class="header__page-title" style="padding: 15px">
                Заявка #<?php echo $page_content["request_data"]->id;?>
            </div>
            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>

        </div>
    </header>

    <div class="content">

        <main class="feedback feedback--nums-<?php echo count($page_content["request_positions"]);?>">
            <div class="container">
                <!-- Левый сайдбар -->
                <div class="main-features">


                    <div class="requests-step__line no-print">
                        <div class="requests-step__title requests-step__title__compare">
                            <?php
                            $request_state_text     = "";
                            $request_state_class    = "";
                            switch ( $page_content["request_data"]->status ) {
                                case 'send':
                                    $request_state_class    = 'requests-step__status--active';
                                    $request_state_text     = 'Сформирована (отправлена)';
                                    break;
                                case 'read':
                                    $request_state_class    = 'requests-step__status--active';
                                    $request_state_text     = 'Сформирована (в обработке)';
                                    break;
                                case 'answered':
                                    $request_state_class    = 'requests-step__status--active';
                                    $request_state_text     = 'Сформирована (есть ответ)';
                                    break;
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
                            };?>


                            <p><b><?php echo $request_state_text;?></b></p>

                            <?php foreach ( $page_content["request_partners_count"] as $rpc_key => $rpc_val ):
                                    if ($rpc_val != 0  && $rpc_key != 'total'):
                                        if ($rpc_key == 'answered'):
                                            echo 'Получено ответов: '.$rpc_val;
                                        endif;
                                    endif;
                                 endforeach;?>

                            <a class="is-blue-link request-compare__print-button" href="#" onclick="window.print();return false;" >
                                <i class="fa fa-print"></i>
                                <span>Печать</span>
                            </a>
                        </div>
                    </div>






                    <div class="feedback__nums-block">

                        <?php
                        $r_i = 1;
                        foreach ($page_content["request_positions"] as $r_position): ?>
                            <div class="feedback__nums">
                                <span>№<?php echo $r_i;?></span>
                                <span>
                                    <?php if( $r_position->detail ):?>

                                        <?php if( mb_strlen( $r_position->detail, 'utf8' ) > 25 ):?>
                                            <span class="tooltip tooltip__request_positions">
                                            <p><?php echo $r_position->detail;?></p>
                                            <span class="tooltip__msg">
                                                <?php echo $r_position->detail;?>
                                            </span>
                                        </span>
                                        <?php else:?>
                                            <p><?php echo $r_position->detail;?></p>
                                        <?php endif;?>
                                    <?php endif;?>

                                    <?php if( $r_position->catalog_num ):?>
                                        <?php if( mb_strlen( $r_position->catalog_num, 'utf8' ) > 25 ):?>
                                            <span class="tooltip tooltip__request_positions">
                                            <p>
                                                <?php echo $r_position->catalog_num;?>
                                            </p>
                                            <span class="tooltip__msg">
                                                <?php echo $r_position->catalog_num;?>
                                            </span>
                                        </span>
                                        <?php else:?>
                                            <p><?php echo $r_position->catalog_num;?></p>
                                        <?php endif;?>
                                    <?php endif;?>
                                </span>
                            </div>
                            <?php
                            $r_i++;
                        endforeach;?>
                        <div class="feedback__nums-total">
                            <span></span>
                            <span>
                                <p>Итого</p>
                                <p class="is-grey-text">Актуально до</p>
                            </span>
                        </div>
                        <div class="feedback__nums-comment">
                            <span></span>
                            <span>
                                <p>Комментарий</p>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Правый сайдбар отсутствует -->
                <!-- Контент -->
                <section class="page-content-wide">
                    <!--  Основной блок -->
                    <div class="feed-back">
                        <!--  Заголовок заявки -->


                        <!--  Блок всех заявок -->
                        <div class="feedback__list-cover">
                            <div class="feedback__list-wrapper scrollbar-inner">
                                <div class="frame feedback__list">
                                    <ul class="feedback__sortable">
                                        <?php
                                        if( $page_content["request_partners"] ):
                                            foreach ( $page_content["request_partners"] as $request_partner ):
                                                /*  В зависимости от статуса заявки мы показываем разые шаблоны */
                                                switch ($request_partner->last_status):
                                                    case 'send':?>
                                                        <li  class="feedback__item feedback__item--processing processing send" <?php if($page_content["request_data"]->executor):?> style="opacity: 0.5" <?endif;?> data-response-id="<?php echo $request_partner->response_id;?>">
                                                            <div class="feedback__head is-first-item">
                                                                <?php if( $request_partner->avatar ):?>
                                                                    <a href="/partners/<?php echo $request_partner->user_id;?>" class="feedback__img">
                                                                        <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                                    </a>
                                                                <?php else:?>
                                                                    <a href="/partners/<?php echo $request_partner->user_id;?>" class="my-partners__image is-rounded"></a>
                                                                <?php endif;?>
                                                                <div class="feedback__info feedback__info--comment">
                                                                    <?php /* <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div> */ ?>

                                                                    <a href="#" class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                        <i class="fa fa-comment"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="feedback__content">
                                                                <div class="feedback__block">
                                                                    <i class="fa fa-envelope-o"></i>
                                                                    заявка отправлена
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php break;?>
                                                    <?php case 'read':?>
                                                    <li  class="feedback__item feedback__item--processing processing read" <?php if($page_content["request_data"]->executor):?> style="opacity: 0.5" <?endif;?> data-response-id="<?php echo $request_partner->response_id;?>">
                                                        <div class="feedback__head is-first-item">
                                                            <a href="/partners/<?php echo $request_partner->user_id;?>" class="feedback__img">
                                                                <?php if( $request_partner->avatar ):?>
                                                                    <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                                <?php else:?>
                                                                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                                                <?php endif;?>
                                                            </a>
                                                            <div class="feedback__info feedback__info--comment">
                                                                <?php /* <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div> */ ?>

                                                                <a href="#" class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                    <i class="fa fa-comment"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="feedback__content">
                                                            <div class="feedback__block">
                                                                <i class="fa fa-clock-o"></i>
                                                                заявка просмотрена
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php break;?>
                                                <?php
                                                    case 'canceled':
                                                        if( !$page_content["request_data"]->executor || $request_partner->user_id == $page_content["request_data"]->executor )
                                                            $opacity    = 1;
                                                        else $opacity    = 0.5;
                                                        ?>
                                                    <li class="feedback__item canceled" style="opacity: <?php echo $opacity;?>" data-response-id="<?php echo $request_partner->response_id;?>">
                                                        <div class="feedback__head is-first-item">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <a href="/partners/<?php echo $request_partner->user_id;?>" class="feedback__img">
                                                                    <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                                </a>
                                                            <?php else:?>
                                                                <a href="/partners/<?php echo $request_partner->user_id;?>" class="my-partners__image is-rounded"></a>
                                                            <?php endif;?>

                                                            <div class="feedback__info feedback__info--comment">
                                                                <?php /* <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div> */ ?>

                                                                <a href="#" class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                    <i class="fa fa-comment"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="feedback__content">


                                                            <?php
                                                            $total_price_rub = 0;
                                                            $total_price_usd = 0;
                                                            foreach ($page_content["request_positions"] as $r_position):?>

                                                                <?php if( is_array($request_partner->responses) && array_key_exists( $r_position->id, $request_partner->responses) ):?>

                                                                    <?php if( $request_partner->responses[$r_position->id]->price ):

                                                                        if ($request_partner->responses[$r_position->id]->currency == "RUB") {
                                                                            $total_price_rub += $request_partner->responses[$r_position->id]->price * $r_position->amount;
                                                                        } elseif ($request_partner->responses[$r_position->id]->currency == "USD"){
                                                                            $total_price_usd += $request_partner->responses[$r_position->id]->price * $r_position->amount;
                                                                        }

                                                                        ?>
                                                                        <div class="feedback__row">

                                                                            <div>
                                                                                <?php echo number_format($request_partner->responses[$r_position->id]->price * $r_position->amount, 0, ',', ' ');?>
                                                                                <?php echo $request_partner->responses[$r_position->id]->currency;?>
                                                                            </div>
                                                                            <?php if ($request_partner->responses[$r_position->id]->in_stock):?>
                                                                                <div class="is-grey-text">в наличии</div>
                                                                            <?php else:?>
                                                                                <?php if( $request_partner->responses[$r_position->id]->shipping ):?>
                                                                                    <div class="is-grey-text">
                                                                                        <i class="fa fa-clock-o"></i>
                                                                                        <?php echo $request_partner->responses[$r_position->id]->shipping;?> день
                                                                                    </div>

                                                                                <?php else:?>
                                                                                    <div class="is-grey-text">нет в наличии</div>
                                                                                <?php endif;?>
                                                                            <?php endif;?>

                                                                        </div>
                                                                    <?php else:?>
                                                                        <div class="feedback__row">
                                                                            <div class="text-center">&mdash;</div>
                                                                            <div class="is-grey-text">нет в наличии</div>
                                                                        </div>
                                                                    <?php endif;?>



                                                                <?php else:?>
                                                                    <div class="feedback__row">
                                                                        <div class="text-center">&mdash;</div>
                                                                        <div class="is-grey-text">нет информации</div>
                                                                    </div>
                                                                <?php endif;?>

                                                            <?php endforeach;?>


                                                            <div class="feedback__total-row">
                                                                <?php if( $total_price_rub != 0 && $total_price_usd != 0 ):?>
                                                                    <div>
                                                                        <b>
                                                                            <?php echo number_format($total_price_rub, 0, ',', ' ');?> <i class="fa fa-rub"></i> и <?php echo number_format($total_price_usd, 0, ',', ' ');?> <i class="fa fa-usd"></i>
                                                                        </b>
                                                                    </div>
                                                                <?php elseif ( $total_price_rub ):?>
                                                                    <div><b><?php echo number_format($total_price_rub, 0, ',', ' ');?> <i class="fa fa-rub"></i></b></div>
                                                                <?php elseif ( $total_price_usd ):?>
                                                                    <div><b><?php echo number_format($total_price_usd, 0, ',', ' ');?> <i class="fa fa-usd"></i></b></div>
                                                                <?php else:?>
                                                                    <div><b> &mdash; </b></div>
                                                                <?php endif;?>

                                                                <span class="is-grey-text">
                                                                        <?php echo $request_partner->request_response_data->actual;?>
                                                                    </span>
                                                            </div>
                                                            <div class="show-helper">
                                                                <div class="feedback__comment-row has-comment">
                                                                    <?php if( $request_partner->request_response_data->comment ):?>
                                                                        <?php echo $request_partner->request_response_data->comment;?>
                                                                    <?php else:?>
                                                                        <div class="text-center">&mdash;</div>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php break;?>
                                                <?php case 'answered':
                                                    case 'in_process':
                                                    case 'payed':
                                                    case 'delivered':
                                                    case 'payed_delivered':
                                                    case 'done':
                                                    case 'finished':?>
                                                    <li class="feedback__item <?php echo $request_partner->last_status;?>" <?php if($request_partner->status == 'canceled'):?>style="opacity: 0.5"<?php endif;?>" data-response-id="<?php echo $request_partner->response_id;?>">
                                                        <div class="feedback__head is-first-item">
                                                            <a href="/partners/<?php echo $request_partner->user_id;?>" class="feedback__img">
                                                                <?php if( $request_partner->avatar ):?>
                                                                    <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                                <?php else:?>
                                                                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                                                <?php endif;?>
                                                            </a>
                                                            <div class="feedback__info feedback__info--comment">
                                                                <?php /* <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div> */ ?>

                                                                <a href="#" class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                    <i class="fa fa-comment"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="feedback__content">


                                                            <?php
                                                            $total_price_rub = 0;
                                                            $total_price_usd = 0;
                                                            foreach ($page_content["request_positions"] as $r_position):?>

                                                                <?php if( is_array($request_partner->responses) && array_key_exists( $r_position->id, $request_partner->responses) ):?>

                                                                    <?php if( $request_partner->responses[$r_position->id]->price ):

                                                                        if ($request_partner->responses[$r_position->id]->currency == "RUB") {
                                                                            $total_price_rub += $request_partner->responses[$r_position->id]->price * $r_position->amount;
                                                                        } elseif ($request_partner->responses[$r_position->id]->currency == "USD"){
                                                                            $total_price_usd += $request_partner->responses[$r_position->id]->price * $r_position->amount;
                                                                        }

                                                                        ?>
                                                                        <div class="feedback__row">

                                                                            <div>
                                                                                <?php echo number_format($request_partner->responses[$r_position->id]->price * $r_position->amount, 0, ',', ' ');?>
                                                                                <?php if( $request_partner->responses[$r_position->id]->currency == 'RUB'):?>
                                                                                    <i class="fa fa-rub"></i>
                                                                                <?php elseif( $request_partner->responses[$r_position->id]->currency == 'USD'):?>
                                                                                    <i class="fa fa-usd"></i>
                                                                                <?php endif;?>
                                                                                <?php if( $r_position->amount > 1) echo ' за '.$r_position->amount.' шт.';?>
                                                                            </div>
                                                                            <?php if ($request_partner->responses[$r_position->id]->in_stock):?>
                                                                                <div class="is-grey-text">в наличии</div>
                                                                            <?php else:?>
                                                                                <?php if( $request_partner->responses[$r_position->id]->shipping ):?>
                                                                                    <div class="is-grey-text">
                                                                                        <i class="fa fa-clock-o"></i>
                                                                                        <?php echo $request_partner->responses[$r_position->id]->shipping;?> день
                                                                                    </div>

                                                                                <?php else:?>
                                                                                    <div class="is-grey-text">нет в наличии</div>
                                                                                <?php endif;?>
                                                                            <?php endif;?>

                                                                        </div>
                                                                    <?php else:?>
                                                                        <div class="feedback__row">
                                                                            <div class="text-center">&mdash;</div>
                                                                            <div class="is-grey-text">нет в наличии</div>
                                                                        </div>
                                                                    <?php endif;?>



                                                                <?php else:?>
                                                                    <div class="feedback__row">
                                                                        <div class="text-center">&mdash;</div>
                                                                        <div class="is-grey-text">нет информации</div>
                                                                    </div>
                                                                <?php endif;?>

                                                            <?php endforeach;?>


                                                            <div class="feedback__total-row">
                                                                <?php if( $total_price_rub != 0 && $total_price_usd != 0 ):?>
                                                                    <div>
                                                                        <b>
                                                                            <?php echo number_format($total_price_rub, 0, ',', ' ');?> <i class="fa fa-rub"></i> и <?php echo number_format($total_price_usd, 0, ',', ' ');?> <i class="fa fa-usd"></i>
                                                                        </b>
                                                                    </div>
                                                                <?php elseif ( $total_price_rub ):?>
                                                                    <div><b><?php echo number_format($total_price_rub, 0, ',', ' ');?> <i class="fa fa-rub"></i></b></div>
                                                                <?php elseif ( $total_price_usd ):?>
                                                                    <div><b><?php echo number_format($total_price_usd, 0, ',', ' ');?> <i class="fa fa-usd"></i></b></div>
                                                                <?php else:?>
                                                                    <div><b> &mdash; </b></div>
                                                                <?php endif;?>

                                                                <span class="is-grey-text">
                                                                        <?php echo $request_partner->request_response_data->actual;?>
                                                                    </span>
                                                            </div>
                                                            <div class="show-helper">
                                                                <div class="feedback__comment-row has-comment">
                                                                    <?php if( $request_partner->request_response_data->comment ):?>
                                                                        <?php echo $request_partner->request_response_data->comment;?>
                                                                    <?php else:?>
                                                                        <div class="text-center">&mdash;</div>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php break;?>

                                                <?php endswitch;?>

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

            </div>

        </main>


        <div class="print">
            <div class="print__logo">
                <img src="/assets__old/img/header__company--logo_backend.png">
            </div>
            <p class="print__h1">Ответы на заявку <?php echo $page_content["request_positions"][0]->request_id;?></p>

            <table>
                <tr>
                    <th>Описание<br>детали</th>
                    <?php foreach ($page_content["request_partners"] as $r_partner):?>
                        <th>
                            <?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?><br>
                            <?php switch ($request_partner->status):
                                case 'send': echo "Отправлено"; break;
                                case 'read': echo "Просмотрено"; break;
                                case 'canceled': echo "Отменено"; break;
                                case 'answered': echo "Есть ответ"; break;
                                case 'in_process': echo "В работе"; break;
                                case 'payed': echo "Оплачено"; break;
                                case 'delivered': echo "Доставлено"; break;
                                case 'payed_delivered': echo "Оплачено и доставлено"; break;
                                case 'done': echo "Завершено"; break;
                                case 'finished': echo "Закончено"; break;
                            endswitch;
                            ?>
                        </th>
                    <?php endforeach;?>

                </tr>
                <?php $r_i = 1;?>
                <?php foreach ($page_content["request_positions"] as $r_position):  ?>
                    <tr>
                        <td>
                            <?php echo $r_i;?> <?php if( $r_position->detail ) echo $r_position->detail; ?><br>
                            <?php if( $r_position->catalog_num ) echo $r_position->catalog_num; ?><br>
                            <?php echo $r_position->amount;?> шт.
                        </td>
                        <?php foreach ($page_content["request_partners"] as $r_partner):?>
                            <td>

                                <?php if( $r_partner->responses[$r_position->id] ):?>
                                    <?php echo $r_partner->responses[$r_position->id]->price." ".$r_partner->responses[$r_position->id]->currency;?><br>
                                    <?php if( $r_position->amount > 1) echo ' за '.$r_position->amount.' шт.<br>';?>

                                    <?php if ($r_partner->responses[$r_position->id]->in_stock):?>
                                        в наличии
                                    <?php else:?>
                                        <?php if( $r_partner->responses[$r_position->id]->shipping ):?>
                                            <i class="fa fa-clock-o"></i> <?php echo $r_partner->responses[$r_position->id]->shipping;?> день
                                        <?php else:?>
                                            <div class="is-grey-text">нет в наличии</div>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php else:?>
                                    –
                                <?php endif;?>

                            </td>
                        <?php endforeach;?>
                    </tr>
                    <?php $r_i++; ?>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

<script>
    $(document).ready(function(){

        function widthListPr(){
            var widthListPr = 0;
            $('.feedback__list li').filter(':visible').each(function(){
                widthListPr = widthListPr + $(this).width() + 9;
                $('.feedback__list').width(widthListPr);
            });
        }

        widthListPr();

        var width = 0;
        $('.nextPage').on('click', function()     {
            var feedback__list_width = $('.feedback__list').width() / 6;
            if (width < feedback__list_width) {
                width = 200 + width;
                //alert(width + ' < ' + feedback__list_width);
                $('.feedback__list-wrapper').animate({
                    scrollLeft: width
                }, 200);
            }
        });

        $('.prevPage').on('click', function()     {
            if (width != 0) {
                width = width - 200;
                $('.feedback__list-wrapper').animate({
                    scrollLeft: width
                }, 200);
            }
        });

        var top = $('.feedback__head').offset().top - parseFloat($('.feedback__head').css('margin-top').replace(/auto/, 0));

        var leftInit = new Array();
        $('.feedback__head').each(function() {
            leftInit.push(
                $(this).offset().left
            );
        });

        $("body").on("click", ".request__checkbox", function() {
            if($(this).is(':checked')) {
                $("li." + $(this).attr('rel') + "").show();
            } else {
                $("li." + $(this).attr('rel') + "").hide();
            }
            widthListPr();
            leftInit = [];
            $('.feedback__item:visible .feedback__head').each(function() {
                leftInit.push(
                    $(this).offset().left
                );
            });
            //alert(leftInit[5]);
        });

    });
</script>


<?php
    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/requests/js/in_process_compare_show_comment');

