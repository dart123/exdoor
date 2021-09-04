<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.11.16
 * Time: 17:10
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


    <!-- Статус заявки -->


    <?php if( isset( $page_content["user_relation"] ) && is_object( $page_content["user_relation"] )):?>
        <?php /*
            <?php if( $page_content["request_author"]->id == $this->session->user):?>
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        Статус и управление заявкой
                    </div>
                    <a href="#req__cancel__author" class="requests-step__action is-or-link fancybox"><span>Отменить заявку</span></a>
                </div>
            <?php else:?>
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        Статус и управление заявкой
                    </div>
                    <?php if ($page_content["request_data"]->status != 'canceled' && isset($page_content["user_relation"]) && $page_content["user_relation"]->status != 'canceled'):?>
                        <a class="requests-step__action is-or-link pointer js__requests_list__partner_denied" data-request-id="<?php echo $page_content["request_data"]->id;?>" data-page-reload="yes">
                            <span>Отклонить заявку</span>
                        </a>
                    <?php endif;?>
                </div>
            <?php endif;?>
            */?>

        <?php if ($page_content["request_data"]->status != 'canceled' && isset($page_content["user_relation"]) && $page_content["user_relation"]->status != 'canceled'):?>
            <?php if ( isset($page_content["user_relation"]) && ( $page_content["user_relation"]->status == 'read' || $page_content["user_relation"]->status == 'send' ) ):?>
                <div class="requests-step__status requests-step__status--formed  is-box-shadow req-status">
                    <div class="req-status__title">Сформирована (ожидает ответа)</div>
                    <div class="req-status__content">
                        <p>Пожалуйста, подтоговьте предложение для запрашиваемых позиций и отправьте ответ автору.</p>
                    </div>
                </div>
            <?php endif;?>
            <?php if ( isset($page_content["user_relation"]) && ( $page_content["user_relation"]->status == 'answered' ) && $page_content["user_relation"]->disable ):?>
                <div class="requests-step__status requests-step__status--formed is-box-shadow req-status">
                    <div class="req-status__title">Сформирована (ответ отправлен)</div>
                    <div class="req-status__content">
                        <p>Вы отправили оценку запрашиваемых позиций автору. Изменить данные станет возможно после истечения срока актуальности.</p>
                    </div>
                </div>
            <?php endif;?>
            <?php if ( isset($page_content["user_relation"]) && ( $page_content["user_relation"]->status == 'answered'  )  && !$page_content["user_relation"]->disable ):?>
                <div class="requests-step__status requests-step__status--formed is-box-shadow req-status">
                    <div class="req-status__title">Сформирована (нуждается в обновлении)</div>
                    <div class="req-status__content">
                        <p>Вы отправили оценку запрашиваемых позиций автору, но дата актуальности уже прошла. Обновите ваш ответ.</p>
                    </div>
                </div>
            <?php endif;?>
        <?php else:?>
            <div class="requests-step__status requests-step__status--canceled is-box-shadow req-status">
                <div class="req-status__title">Отменена</div>
                <div class="req-status__content">
                    <p>Заявка отменена и в скором времени отправится в архив</p>
                </div>
            </div>
        <?php endif;?>
    <?php endif;?>



    <!-- Статус заявки -->


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





    <!--  Позиции заявки -->


    <?php
    //$this->load->view('mobile/requests/html_block__ready__title');
    $this->load->view('mobile/requests/html_block__ready__equipment');
    ?>



    <div class="requests-step__line requests-single__equipment is-mtop-20">

        <a class="is-blue-link request-positions__print-button" href="#" onclick="window.print();return false;" >
            <i class="fa fa-print"></i>
            <span>Печать</span>
        </a>

        <div class="requests-step__title">
            Запрашиваемые позиции
        </div>

    </div>

    <?php if ( isset($page_content["user_relation"]) && is_object($page_content["user_relation"]) ):

        $page_content["user_relation"]->disable = true;

        ?>

        <?php if ($page_content['responses'] ):?>

            <div class="requests-eq__block is-rounded is-box-shadow is-mtop-20">

                <form method="POST" class="request__add_form">

                <?php $i = 1;
                    foreach ($page_content["request_positions"] as $position ):
                    ?>

                    <div class="requests-eq__item">

                        <div class="requests-eq__pos-row">
                            <div class="requests-eq__no"><b>#<?php echo $i;?></b></div><!--
                                                     --><div class="requests-eq__pos-descr">
                                <div class="position-name">

                                    <?php if( $position->detail ):?>
                                        <?php if( mb_strlen( $position->detail, 'utf8' ) >= 12 ):?>
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
                                        <?php if( mb_strlen( $position->catalog_num, 'utf8' ) >= 12 ):?>
                                            <span class="tooltip tooltip__request_positions">
                                                                        <p>
                                                                            Номер в каталогах: <?php echo $position->catalog_num;?>
                                                                        </p>
                                                                        <span class="tooltip__msg">
                                                                            Номер в каталогах: <?php echo $position->catalog_num;?>
                                                                        </span>
                                                                    </span>
                                        <?php else:?>
                                            <p>Номер в каталогах: <?php echo $position->catalog_num;?></p>
                                        <?php endif;?>
                                    <?php endif;?>

                                    <p class="request_position__amount js__amount__position_<?php echo $position->id;?>" data-amount="<?php echo $position->amount;?>"><?php echo $position->amount;?> шт.</p>

                                    <?php if(  $page_content["responses"] || ( !$page_content["responses"] && $page_content["user_relation"]->status != 'canceled' )  ):?>
                                        <?php if( ( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->in_stock == 1 ) || $page_content["responses"] == false  ):?>
                                            <p class="request_position__report__in_stock">В наличии</p>
                                        <?php else:?>
                                            <p class="request_position__report__in_stock">Нет в наличии</p>
                                        <?php endif;?>
                                    <?php endif;?>


                                    <?php if( ( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) && $page_content["responses"][$position->id]->in_stock == 0 && array_key_exists($position->id, $page_content["responses"]) && $page_content["responses"][$position->id]->shipping )  ):?>
                                        <p><?php echo $page_content["responses"][$position->id]->shipping;?> дн.</p>
                                    <?php endif;?>

                                    <?php if(  $page_content["responses"] || ( !$page_content["responses"] && $page_content["user_relation"]->status != 'canceled' )  ):?>
                                        <p><?php
                                            if( $page_content["responses"][$position->id]->currency == 'RUB') $cur = "<i class='fa fa-rub'></i>"; else $cur = "<i class='fa fa-usd'></i>";
                                            echo $page_content["responses"][$position->id]->price. ' ' . $cur;?> </p>
                                        <?php

                                        if( $page_content["responses"][$position->id]->currency == "RUB" ){
                                            $total_price_rub    += $page_content["responses"][$position->id]->price * $position->amount;
                                        } else {
                                            $total_price_usd    += $page_content["responses"][$position->id]->price * $position->amount;
                                        }

                                        ?>
                                        <p><?php echo $page_content["responses"][$position->id]->price * $position->amount. ' ' . $cur;?> </p>
                                    <?php endif;?>
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
                    <?php
                    $i++;
                    endforeach;?>

            </form>
        </div>


        <?php else:
            $this->load->view('mobile/requests/html_block__ready__positions_list');
        endif;?>


        <?php if( isset( $page_content["user_relation"]->actual) ):?>
            <div style="padding: 10px;">
                <p>Актуально до: <b><?php echo $page_content["user_relation"]->actual;?></b></p>
                <?php if( isset( $page_content["user_relation"]->comment) &&  $page_content["user_relation"]->comment != ''):?>
                    <p>Комментарий: <?php echo $page_content["user_relation"]->comment;?></p>
                <?php endif;?>
            </div>
        <?php endif;?>

    <?php endif;?>



</div>




<?php

    $this->load->view("mobile/requests/html_block__print__positions");


    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/requests/js/in_process_position_price_calc');
    $this->load->view('mobile/requests/js/in_process_compare_show_comment');
