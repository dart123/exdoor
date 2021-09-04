<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 23.02.2017
 * Time: 17:16
 */
?>

<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img preloader__show">
</div>

<main class="feedback feedback--nums-<?php echo count($request_positions);?>">
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
            <div class="feedback__nums-block">
                <div class="feedback__main-title">Запрашиваемые позиции</div>
                <?php
                $r_i = 1;
                foreach ($request_positions as $r_position): ?>
                    <div class="feedback__nums">
                        <span>№<?php echo $r_i;?></span>
                        <span>
                            <?php if( $r_position->detail ):?>
                                <?php if( mb_strlen( $r_position->detail ) > 25 ):?>
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
                                <?php if( mb_strlen( $r_position->catalog_num ) > 25 ):?>
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
                <div class="requests-step__line no-print">
                    <div class="requests-step__title requests-step__title__compare">
                        <a href="/requests/<?php echo $request_data->id;?>" class="is-blue-link">
                            <span>Исходящая заявка #<?php echo $request_data->id;?></span>
                        </a>  /
                        <b>Ответы на заявку:</b>
                        <?php foreach ( $request_partners_count as $rpc_key => $rpc_val ):?>
                            <?php if ($rpc_val != 0  && $rpc_key != 'total'):?>
                                <span class="feedback__check-line">
                                    <input type="checkbox" class="request__checkbox" id="req-status-<?php echo $rpc_key;?>" rel="<?php echo $rpc_key;?>" checked>
                                    <label class="request__label-c" for="req-status-<?php echo $rpc_key;?>">
                                        <?php echo $rpc_val;?>
                                        <?php switch ($rpc_key):
                                            case 'send':
                                                echo 'отправлено';
                                                break;
                                            case 'read':
                                                echo 'ожидается';
                                                break;
                                            case 'answered':
                                                echo 'получена';
                                                break;
                                            case 'canceled':
                                                echo 'отклонена';
                                                break;
                                            endswitch;
                                        ?>
                                    </label>
                                </span>
                            <?php endif;?>
                        <?php endforeach;?>

                        <a class="is-blue-link request-compare__print-button" href="#" onclick="window.print();return false;" >
                            <i class="fa fa-print"></i>
                            <span>Печать</span>
                        </a>
                    </div>
                </div>

                <!--  Блок всех заявок -->
                <div class="feedback__list-cover">
                    <div class="controls no-print">
                        <div class="prevPage"></div><!--
                            --><div class="nextPage"></div>
                    </div>
                    <div class="feedback__list-wrapper scrollbar-inner">
                        <div class="frame feedback__list">
                            <ul class="feedback__sortable">
                                <?php
                                if( $request_partners ):
                                    foreach ( $request_partners as $request_partner ):

                                        /*  В зависимости от статуса заявки мы показываем разые шаблоны */
                                        switch ($request_partner->status):
                                            case 'send':?>
                                                <li class="feedback__item feedback__item--processing processing send" data-response-id="<?php echo $request_partner->response_id;?>">
                                                    <div class="feedback__head is-first-item">
                                                        <?php if( $request_partner->avatar ):?>
                                                            <a href="" class="feedback__img">
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            </a>
                                                        <?php else:?>
                                                            <a href="" class="my-partners__image is-rounded"></a>
                                                        <?php endif;?>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>

                                                            <a class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                <i class="fas fa-comment"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__fix feedback__head--cloned">
                                                        <a href="" class="feedback__img">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            <?php endif;?>
                                                        </a>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                            <a class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                <i class="fas fa-comment"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__content">
                                                        <div class="feedback__block">
                                                            <i class="far fa-envelope"></i>
                                                            заявка отправлена
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php break;?>
                                            <?php case 'read':?>
                                                <li class="feedback__item feedback__item--processing processing read" data-response-id="<?php echo $request_partner->response_id;?>">
                                                    <div class="feedback__head is-first-item">
                                                        <a href="" class="feedback__img">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            <?php else:?>
                                                                <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                                            <?php endif;?>
                                                        </a>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                            <a class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                <i class="fas fa-comment"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__fix feedback__head--cloned">
                                                        <a href="" class="feedback__img">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            <?php endif;?>
                                                        </a>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                            <a class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                <i class="fas fa-comment"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__content">
                                                        <div class="feedback__block">
                                                            <i class="far fa-clock"></i>
                                                            заявка просмотрена
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php break;?>
                                            <?php case 'canceled':?>
                                                <li class="feedback__item feedback__item--rejected rejected canceled" data-response-id="<?php echo $request_partner->response_id;?>">
                                                    <div class="feedback__head is-first-item">
                                                        <?php if( $request_partner->avatar ):?>
                                                            <a href="" class="feedback__img">
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            </a>
                                                        <?php else:?>
                                                            <a href="/partners/51" class="my-partners__image is-rounded"></a>
                                                        <?php endif;?>

                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__fix feedback__head--cloned">
                                                        <a href="" class="feedback__img">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            <?php endif;?>
                                                        </a>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__content">
                                                        <div class="feedback__block">
                                                            <i class="fas fa-times"></i>
                                                            заявка отклонена
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
                                                case 'finished':
                                                                ?>
                                                <li class="feedback__item <?php if(!$request_partner->request_response_data->disable):?>feedback__item--unactual<?php endif;?> answered" data-response-id="<?php echo $request_partner->response_id;?>">
                                                    <div class="feedback__head is-first-item">
                                                        <a href="" class="feedback__img">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            <?php else:?>
                                                                <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                                            <?php endif;?>
                                                        </a>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                            <a class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                <i class="fas fa-comment"></i>
                                                            </a>

                                                        </div>
                                                    </div>
                                                    <div class="feedback__fix feedback__head--cloned">
                                                        <a href="" class="feedback__img">
                                                            <?php if( $request_partner->avatar ):?>
                                                                <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                            <?php endif;?>
                                                        </a>
                                                        <div class="feedback__info feedback__info--comment">
                                                            <div class="feedback__name"><?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?></div>
                                                            <a class="js-partner__open_chat <?php if( $request_partner->request_response_data->comment != "" ):?>is-or-link<?php endif;?>" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                <i class="fas fa-comment"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="feedback__content">


                                                        <?php
                                                        $total_price_rub = 0;
                                                        $total_price_usd = 0;
                                                        foreach ($request_positions as $r_position):?>

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
                                                                                    <i class="far fa-clock"></i>
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

                                                        <?php if ( $request_partner->request_response_data->disable ):?>

                                                            <a class="feedback__choose-executant is-last-item" data-executor="<?php echo $request_partner->last_name;?> <?php echo $request_partner->name;?> <?php echo $request_partner->second_name;?>" data-executor-id="<?php echo $request_partner->user_id;?>">
                                                                <div class="feedback__helper is-last-item">
                                                                    <div class="is-grey-link">
                                                                        <i class="fa fa-hand-o-up i-left-15"></i>
                                                                        <span>Выбрать исполнителя</span>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                        <?php else:?>
                                                            <?php if( $request_partner->request_response_data->can_re_response):?>
                                                                <a class="js__send_re-response feedback__choose-executant__unactual is-last-item" data-request-id="<?php echo $request_data->id;?>" data-partner-id="<?php echo $request_partner->user_id;?>">
                                                                    <div class="feedback__helper is-last-item">
                                                                        <div>
                                                                            <i class="fa fa-question i-left-15"></i>
                                                                            <span>Запросить данные</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="feedback__choose-executant__unactual-disabled is-hidden is-last-item">
                                                                    <div class="feedback__helper is-last-item">
                                                                        <div class="is-grey-text">
                                                                            <i class="fas fa-check i-left-15"></i>
                                                                            <span>Данные запрошены</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            <?php else:?>

                                                                <a class="feedback__choose-executant__unactual-disabled is-last-item">
                                                                    <div class="feedback__helper is-last-item">
                                                                        <div class="is-grey-text">
                                                                            <i class="fas fa-check i-left-15"></i>
                                                                            <span>Данные запрошены</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            <?php endif;?>

                                                        <?php endif;?>

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
        <!-- Кнопка Наверх -->

        <!--  Подверждение  -->
        <div id="confirm" class="modal__block is-rounded">
            <div class="modal__head modal__head--blue is-first-item">
                <div class="modal__title">Выбор исполнителя</div>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>

            <div class="modal__content">
                <h2>Подвердить статус исполнителя?</h2>
                <p>В качестве исполнителя заявки Вы хотите выбрать: <b id="js__executor_name"></b>. После подтверждения данного действия Вы не сможете изменить исполнителя.</p>
                <p class="center">Вы готовы подвердить свое решение?</p>
                <form method="POST" action="/requests/<?php echo $request_data->id;?>">
                    <input type="hidden" name="action" value="set_executor">
                    <input type="hidden" name="executor_id" value="" id="js__executor_id">
                    <input type="hidden" name="request_id" value="<?php echo $request_data->id;?>" >

                    <div class="confirm__block">
                        <button type="submit" class="confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                            <i class="fas fa-check"></i>
                            <span>Да, выбрать</span>
                        </button>

                        <a class="modal__close-btn pointer confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                            <i class="fas fa-times"></i>
                            <span>Отменить</span>
                        </a>
                    </div>
                </form>

            </div>
        </div>
        <!-- end Подверждение -->
    </div>






    <div class="print">
        <div class="print__logo">
            <img src="/assets/img/header__company--logo_backend.png">
        </div>
        <p class="print__h1">Ответы на заявку <?php echo $request_positions[0]->request_id;?></p>

        <table>
            <tr>
                <th>Описание<br>детали</th>
                <?php foreach ($request_partners as $r_partner):?>
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
            <?php foreach ($request_positions as $r_position):  ?>
                <tr>
                    <td>
                        <?php echo $r_i;?> <?php if( $r_position->detail ) echo $r_position->detail; ?><br>
                        <?php if( $r_position->catalog_num ) echo $r_position->catalog_num; ?><br>
                        <?php echo $r_position->amount;?> шт.
                    </td>
                    <?php foreach ($request_partners as $r_partner):?>
                        <td>

                            <?php if( $request_partner->responses[$r_position->id] ):?>
                                <?php echo $request_partner->responses[$r_position->id]->price." ".$request_partner->responses[$r_position->id]->currency;?><br>
                                <?php if( $r_position->amount > 1) echo ' за '.$r_position->amount.' шт.<br>';?>

                                <?php if ($request_partner->responses[$r_position->id]->in_stock):?>
                                    в наличии
                                <?php else:?>
                                    <?php if( $request_partner->responses[$r_position->id]->shipping ):?>
                                        <i class="far fa-clock"></i> <?php echo $request_partner->responses[$r_position->id]->shipping;?> день
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
</main>



<script>
    $(document).ready(function(){

        function widthListPr(){
            var widthListPr = 0;
            $('.feedback__list li').filter(':visible').each(function(){
                widthListPr = widthListPr + $(this).width() + 20;
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

        $(window).scroll(function(event) {
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= top) {
                // if so, ad the fixed class
                $('.feedback__item.answered').children('.feedback__fix').show();
            } else {
                // otherwise remove it
                $('.feedback__item.answered').children('.feedback__fix').hide();
            }
        });

        $('.feedback__list-wrapper').scroll(function(event) {
            var x = 0 - $(this).scrollLeft();
            //alert(leftInit[5]);
            $('.feedback__item:visible .feedback__fix').each(function(index, element) {
                var feedbackLeft = x + leftInit[index];
                $(element).css('left', feedbackLeft);
            });

        });

        $( ".feedback__sortable" ).sortable({
            axis: 'x',
            cursor: 'move',
            start: function (event, ui) {
                $('.feedback__item.answered').children('.feedback__fix').hide();
            },
            stop: function (event, ui) {
                scrollLeft = 0 - $(ui.item).parent().parent().parent().scrollLeft();
                $('.feedback__item:visible .feedback__fix').each(function(index, element) {
                    var feedbackLeft = scrollLeft + leftInit[index];
                    $(element).css('left', feedbackLeft);
                });

                var y = $(window).scrollTop();
                // whether that's below the form
                if (y >= top) {
                    // if so, ad the fixed class
                    $('.feedback__item.answered').children('.feedback__fix').show();
                }

                var sorted_response = [];

                $('.feedback__item').each(function(index, element) {
                    sorted_response.push( $(this).data('response-id') );
                });

                $.ajax({
                    url:   '/ajax/request__compare_sort',
                    data: {
                        'sorted_response'    : sorted_response,
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(data){

                    }
                });
            }
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

    $this->load->view('desktop/misc/js/partners__open_chat');

    $this->load->view('desktop/requests/js/in_process_compare_show_comment');
    $this->load->view('desktop/requests/js/in_process_send_re-response');
    $this->load->view('desktop/requests/js/in_process_set_executor');

