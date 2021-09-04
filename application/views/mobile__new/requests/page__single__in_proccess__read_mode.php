<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.17
 * Time: 16:24
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

        <?php

            switch ( $page_content["request_data"]->status ){
                case 'read':
                    $request_state_class    = 'requests-step__status--active';
                    $request_state_text     = 'Прочитано';
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

            ?>

            <!--  Блок статуса -->
            <div class="requests-step__status <?php echo $request_state_class;?>  is-box-shadow req-status">
                <div class="req-status__title">
                    <?php echo $request_state_text;?>
                </div>
            </div>



        <!--  Статус заявки -->




        <!-- Автор заявки -->


        <?php if( array_key_exists( "request_author", $page_content ) ):?>
            <div class="requests-step__author req-author is-box-shadow clear">

                <?php if ( $page_content["request_author"]->avatar ):?>
                    <a href="/partners/<?php echo $page_content["request_author"]->id;?>" class="req-author__image req-author__image--image_exists is-rounded ">
                        <img src="/uploads/users/<?php echo $page_content["request_author"]->id;?>/avatar/80x80_<?php echo $page_content["request_author"]->avatar;?>" alt="" class="img-responsive">
                    </a>
                <?php else:?>
                    <a href="/partners/<?php echo $page_content["request_author"]->id;?>" class="req-author__image is-rounded ">
                    </a>
                <?php endif;?>

                <div class="req-author__content">
                    <div class="is-long-row">
                        <a href="/partners/<?php echo $page_content["request_author"]->id;?>" class="is-blue-link">
                            <span>
                                <b>
                                    <?php if( $page_content["request_author"]->id == $this->session->user):?>(Вы)<?php endif;?>
                                    <?php echo $page_content["request_author"]->name;?> <?php echo $page_content["request_author"]->second_name;?> <?php echo $page_content["request_author"]->last_name;?>
                                </b>
                            </span>
                        </a>
                    </div>
                    <?php /*
                    <div class="is-long-row">
                        <?php if( $page_content["request_author"]->company ):?>
                            <a href="/company/id<?php echo $page_content["request_author"]->company->id;?>" class="is-grey-link"><span><?php echo $page_content["request_author"]->company->short_name;?></span></a>
                        <?php endif;?>
                    </div>
                    */?>
                </div>
            </div>
        <?php endif;?>


        <!-- Автор заявки -->



        <?php
        //$this->load->view('mobile/requests/html_block__ready__title');
        $this->load->view('mobile/requests/html_block__ready__equipment');

        if( $page_content["request_positions"] ):?>


            <div class="requests-eq__block requests-eq__block__no-margin is-rounded is-box-shadow is-mtop-20">


                <?php
                $total_price_rub    = 0;
                $total_price_usd    = 0;
                $r_i = 1;
                foreach ( $page_content["request_positions"] as $position ):
                    if( $page_content["request_executor"] && is_array( $page_content["request_executor"]->responses) && array_key_exists( $position->id, $page_content["request_executor"]->responses) ):
                        ?>
                        <div class="requests-eq__item">
                            <div class="requests-eq__pos-row">
                                <div class="requests-eq__no"><b>#<?php echo $r_i;?></b></div><!--
                                 --><div class="requests-eq__pos-descr">

                                    <div class="requests-eq__radio--line request__single__answer-form__in-stock__container">

                                        <?php if(  $page_content["request_executor"]->responses || ( !$page_content["request_executor"]->responses && $page_content["user_relation"]->status != 'canceled' )  ):?>
                                            <?php if( ( $page_content["request_executor"]->responses && is_array($page_content["request_executor"]->responses) && array_key_exists($position->id, $page_content["request_executor"]->responses) &&  $page_content["request_executor"]->responses[$position->id]->in_stock == 1 ) || $page_content["request_executor"]->responses == false  ):?>
                                                <p class="request_position__report__in_stock">В наличии</p>
                                            <?php else:?>
                                                <?php if( $page_content["request_executor"]->responses[$position->id]->shipping != ''  ):?>
                                                    <p class="request_position__report__in_stock is-grey-text"><i class="fa fa-clock"></i> Поставка через <?php echo $page_content["request_executor"]->responses[$position->id]->shipping;?> дн.</p>
                                                <?php else:?>
                                                    <p class="request_position__report__in_stock is-grey-text">Нет в наличии</p>
                                                <?php endif;?>
                                            <?php endif;?>
                                        <?php endif;?>

                                    </div>

                                    <div class="position-name">

                                        <?php if( $position->detail ):?>
                                            <p><?php echo $position->detail;?></p>
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
                                                <p>Номер в каталогах: <?php echo $position->catalog_num;?></p>
                                            <?php endif;?>
                                        <?php endif;?>

                                        <p class="request_position__amount js__amount__position_<?php echo $position->id;?>" data-amount="<?php echo $position->amount;?>"><?php echo $position->amount;?> шт.</p>


                                        <div class="clear"></div>

                                        <?php if( $position->amount > 1 ):?>
                                            <p class="is-mtop-5">
                                                <?php echo "Цена за ед.: ".number_format($page_content["request_executor"]->responses[$position->id]->price, 0, ',', ' ');?>

                                                <?php if ($page_content["request_executor"]->responses[$position->id]->currency == 'RUB'):?>
                                                    <i class="fa fa-rub"></i>
                                                <?php else:?>
                                                    <span>$</span>
                                                <?php endif;?>


                                            </p>
                                        <?php endif;?>

                                        <p class="is-highlight-r is-mtop-5">

                                            <?php
                                            $position_summa     = $position->amount*$page_content["request_executor"]->responses[$position->id]->price;

                                            if ($page_content["request_executor"]->responses[$position->id]->currency == 'RUB'):
                                                $total_price_rub    += $position_summa;
                                            elseif ($page_content["request_executor"]->responses[$position->id]->currency == 'USD'):
                                                $total_price_usd    += $position_summa;
                                            endif;

                                            ?>
                                            <b>
                                                Итого:
                                                <?php echo number_format($position_summa, 0, ',', ' ');?>

                                                <?php if ($page_content["request_executor"]->responses[$position->id]->currency == 'RUB'):?>
                                                    <i class="fa fa-rub"></i>
                                                <?php else:?>
                                                    <span>$</span>
                                                <?php endif;?>
                                            </b>

                                        </p>

                                    </div>
                                    <div class="clear"></div>
                                    <div style="height: 10px;"></div>

                                    <?php if (!empty($position->images_arr)):?>
                                        <a href="#" data-open-id="album-<?php echo $position->id;?>" class="is-mtop-10 requests-eq__img <?php if( count($position->images_arr) == 1):?>requests-eq__img--1<?php elseif( count($position->images_arr) == 2):?>requests-eq__img--2<?php elseif(count($position->images_arr) > 2):?>requests-eq__img--more<?php endif;?> open-album">
                                            <div class="requests-eq__inner">
                                                <img src="/uploads/requests/<?php echo $page_content["request_data"]->id;?>/158x158_<?php echo $position->images_arr[0];?>" alt="">
                                            </div>
                                        </a>

                                        <div class="modal modal__block">
                                            <?php foreach ($position->images_arr as $img):?>
                                                <a rel="album-<?php echo $position->id;?>" class="image-show" href="/uploads/requests/<?php echo $page_content["request_data"]->id;?>/lg1000_<?php echo $img;?>">
                                                    <img src="/uploads/requests/<?php echo $page_content["request_data"]->id;?>/lg1000_<?php echo $img;?>" alt=""/>
                                                </a>
                                            <?php endforeach;?>
                                        </div>
                                    <?php endif;?>


                                </div>


                            </div>
                        </div>
                    <?php endif;
                    $r_i++;
                endforeach;
                ?>

                <div class="requests-eq__item">
                    <div class="requests-eq__pos-row">
                        <div class="requests-eq__no"></div><!--
                                 --><div class="requests-eq__pos-descr requests-eq__pos-descr--full-width">
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


        <?php endif; ?>



        <?php if( $page_content["request_partners"] ):?>
            <?php $this->load->view('mobile/requests/html_block__ready__candidats');?>
        <?php endif;?>


        <?php if( $page_content["request_data"]->can__compare ):?>
            <a href="/requests/<?php echo $page_content["request_data"]->id;?>/compare" class="req-status__open-btn btn ripple-effect   bl-btn btn-block">
                <span>Просмотреть ответы</span>
            </a>
        <?php endif;?>






    </div>



<?php


$this->load->view('mobile/requests/html_block__modal__cancel_author');
$this->load->view('mobile/requests/html_block__modal__cancel_executor');

$this->load->view('mobile/requests/js/in_process_author_denied');
$this->load->view('mobile/requests/js/in_process_set_executor');
$this->load->view('mobile/requests/js/in_process_send_to_archive');

$this->load->view('mobile/requests/js/in_process_compare_show_comment');

$this->load->view('mobile/requests/js/in_process_copy');
