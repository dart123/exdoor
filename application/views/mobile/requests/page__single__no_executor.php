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

            if( $page_content["user_relation"]->status == 'canceled' )
                $page_content["user_relation"]->disable = true;

            ?>

            <!--  Запрашиваемые позиции -->
            <div class="requests-eq__block is-rounded is-box-shadow is-mtop-20">

                <form method="POST" class="request__add_form">
                    <input type="hidden" name="action" value="update_response">

                    <?php

                        $total_price_rub        = 0;
                        $total_price_usd        = 0;

                        if( $page_content["request_positions"] && !$page_content["user_relation"]->disable):
                            $i = 1;
                            foreach ($page_content["request_positions"] as $position ):
                            ?>
                                <div class="requests-eq__item  requests-eq__form">

                                    <?php if( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) ):?>
                                        <input type="hidden" name="response_id[<?php echo $position->id;?>]" value="<?php echo $page_content["responses"][$position->id]->id;?>">
                                    <?php endif;?>

                                    <div class="requests-eq__pos-row">
                                        <div class="requests-eq__no">
                                            <b>#<?php echo $i;?></b>
                                        </div><!--
                                         --><div class="requests-eq__pos-descr">


                                            <div class="requests-eq__radio--line request__single__answer-form__in-stock__container">
                                                <span class="is-grey-text position-label">Наличие:</span>
                                                <div class="requests-eq__radio--cover is-mtop-10">
                                                    <div>
                                                        <label for="requests-eq__is__<?php echo $position->id;?>" class="radio__label">Есть</label>
                                                        <input type="radio" class="radio requests-eq__is js__temp_save_response" name="in_stock[<?php echo $position->id;?>]" id="requests-eq__is__<?php echo $position->id;?>" value="1" <?php if( ( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) && $page_content["responses"][$position->id]->saved_in_stock == 1 ) || $page_content["responses"] == false  ):?>checked<?php endif;?> data-position-id="<?php echo $position->id;?>" data-input-name="in_stock">

                                                    </div>

                                                    <div class="is-mtop-5">
                                                        <label for="requests-eq__isnot__<?php echo $position->id;?>" class="radio__label">Нет</label>
                                                        <input type="radio" class="radio requests-eq__isnot js__temp_save_response" name="in_stock[<?php echo $position->id;?>]" id="requests-eq__isnot__<?php echo $position->id;?>" value="0" <?php if( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->saved_in_stock == 0  ):?>checked<?php endif;?> data-position-id="<?php echo $position->id;?>" data-input-name="not_in_stock">

                                                    </div>

                                                </div>
                                            </div>


                                            <div class="position-name">
                                                <?php if( $position->detail ):?>
                                                    <p><?php echo $position->detail;?></p>
                                                <?php endif;?>

                                                <?php if( $position->catalog_num ):?>
                                                    <?php if( mb_strlen( $position->catalog_num, 'utf8'  ) >= 12 ):?>
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

                                                <p class="request_position__amount js__amount__position_<?php echo $position->id;?>" data-amount="<?php echo $position->amount;?>">В количестве <?php echo $position->amount;?> шт.</p>
                                            </div>



                                            <label for="" class="requests-eq__label js-supply" <?php if( ( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->saved_in_stock == 1 ) || $page_content["responses"] == false  ):?>style="display: none;"<?php endif;?>>
                                                <span class="is-grey-text position-label">Срок поставки:</span><br>
                                                <input type="number" inputmode="numeric" class="input__type-text      is-mtop-5       requests-eq__input--full numHyp js__temp_save_response js__form__required-field" placeholder="Рабочих дней"  name="shipping[<?php echo $position->id;?>]" <?php if( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->saved_in_stock == 0  ):?>value="<?php echo $page_content["responses"][$position->id]->saved_shipping ;?>"<?php endif;?> data-position-id="<?php echo $position->id;?>" data-input-name="shipping">
                                            </label>

                                            <label for="" class="requests-eq__label">
                                                <span class="is-grey-text position-label">Цена</span>
                                                <div class="is-mtop-5">
                                                    <input type="number" inputmode="numeric" class="input__type-text            requests-eq__input--full js__form__required-field numHyp js__one_item_price__position js__temp_save_response" name="price[<?php echo $position->id;?>]" placeholder="Цифрами, за единицу" pattern="[0-9]{10}" <?php if( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->saved_price ):?>value="<?php echo $page_content["responses"][$position->id]->saved_price;?>"<?php endif;?> data-position-id="<?php echo $position->id;?>" data-input-name="price">
                                                    <select style="width: 80px; padding: 6px 0" id="advpost__theme-name" class="select select-box             js__currency__position select__currency__<?php echo $position->id;?> js__temp_save_response" name="currency[<?php echo $position->id;?>]" data-position-id="<?php echo $position->id;?>" data-input-name="currency">
                                                        <option value="RUB" <?php if( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->saved_currency == 'RUB' ):?>selected<?php endif;?>>Р, рубли</option>
                                                        <option value="USD" <?php if( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->saved_currency == 'USD' ):?>selected<?php endif;?>>$, доллар</option>
                                                    </select>
                                                </div>

                                            </label><!--
                                         --><div class="requests-eq__pos-descr is-mtop-20 is-mbtm-30 request_position__total_price js__request_position__total_price__position_<?php echo $position->id;?>" style="display: none" >
                                                <div class="position-name">
                                                    <p><b>Итого:</b>&nbsp;<span class="position-name total_price__position js__total_price__position_<?php echo $position->id;?>"></span></p>
                                                </div>
                                            </div>



                                            <?php if (!empty($position->images_arr)):?>
                                            <div class="clear"></div>
                                            <div class="is-mtop-10"></div>
                                                <a href="#" data-open-id="album-<?php echo $position->id;?>" class="requests-eq__img <?php if( count($position->images_arr) == 1):?>requests-eq__img--1<?php elseif( count($position->images_arr) == 2):?>requests-eq__img--2<?php elseif(count($position->images_arr) > 2):?>requests-eq__img--more<?php endif;?> open-album">
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
                            endforeach;


                        elseif( $page_content["request_positions"] && $page_content["user_relation"]->disable):


                            $i = 1;
                            foreach ($page_content["request_positions"] as $position ):
                                ?>

                                <div class="requests-eq__item">

                                    <div class="requests-eq__pos-row">
                                        <div class="requests-eq__no"><b>#<?php echo $i;?></b></div><!--
                                         --><div class="requests-eq__pos-descr">

                                            <div class="requests-eq__radio--line request__single__answer-form__in-stock__container">

                                                <?php if(  $page_content["responses"] || ( !$page_content["responses"] && $page_content["user_relation"]->status != 'canceled' )  ):?>
                                                    <?php if( ( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) &&  $page_content["responses"][$position->id]->in_stock == 1 ) || $page_content["responses"] == false  ):?>
                                                        <p class="request_position__report__in_stock">В наличии</p>
                                                    <?php else:?>
                                                        <p class="request_position__report__in_stock">Нет в наличии</p>
                                                    <?php endif;?>
                                                <?php endif;?>


                                                <?php if( ( $page_content["responses"] && is_array($page_content["responses"]) && array_key_exists($position->id, $page_content["responses"]) && $page_content["responses"][$position->id]->in_stock == 0 && array_key_exists($position->id, $page_content["responses"]) && $page_content["responses"][$position->id]->shipping )  ):?>
                                                    <p>Срок поставки: <?php echo $page_content["responses"][$position->id]->shipping;?> дн</p>
                                                <?php endif;?>

                                            </div>
                                            <div class="position-name">

                                                <?php if( $position->detail ):?>
                                                    <p><?php echo $position->detail;?></p>
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

                                            </div>

                                            <div class="clear"></div>


                                            <?php if(  $page_content["responses"] || ( !$page_content["responses"] && $page_content["user_relation"]->status != 'canceled' )  ):?>
                                                <p><?php
                                                    if( $page_content["responses"][$position->id]->currency == 'RUB') $cur = "<i class='fa fa-rub'></i>"; else $cur = "<i class='fa fa-usd'></i>";
                                                    echo "Цена за ед.: ".$page_content["responses"][$position->id]->price. ' ' . $cur;?> </p>
                                                <?php

                                                if( $page_content["responses"][$position->id]->currency == "RUB" ){
                                                    $total_price_rub    += $page_content["responses"][$position->id]->price * $position->amount;
                                                } else {
                                                    $total_price_usd    += $page_content["responses"][$position->id]->price * $position->amount;
                                                }

                                                ?>
                                                <p class="is-mtop-5"><?php echo "<b>Итого:</b> ".$page_content["responses"][$position->id]->price * $position->amount. ' ' . $cur;?> </p>
                                            <?php endif;?>

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
                            endforeach;

                        endif;
                    ?>

                    <?php if( $page_content["responses"] || ( !$page_content["responses"] && $page_content["user_relation"]->status != 'canceled' )  ):?>






                        <!--
                        <div class="requests-eq__item">
                            <div class="requests-eq__form--time">


                                <label for="" class="requests-eq__label clear">
                                    <span class="is-grey-text position-label">Комментарий</span>
                                    <textarea name="comment" id="advpost__ta-posttext" class="requests-eq__input--full js__temp_save_response" placeholder="Добавить комментарий о возможной скидке" <?php if($page_content["user_relation"]->disable):?>disabled<?php endif;?> data-input-name="comment"><?php if( $page_content["user_relation"]->saved_comment ) echo $page_content["user_relation"]->saved_comment; else echo $page_content["user_relation"]->comment;?></textarea>
                                </label>


                            </div>
                        </div>
                        -->
                    <?php endif;?>

                    <?php if(!$page_content["user_relation"]->disable):?>
                    <!--
                        <a class="pointer  is-last-item btn-primary2 btn ripple-effect    requests__submit js__req__modal__send_answer__open">
                            <i class="fa fa-paper-plane i-left-20 "></i>
                            <span>Ответить на заявку</span>
                        </a>
                    -->
                        <div style="height: 145px;"></div>


                        <div class="m-news-add-comment">
                            <div class="content">

                                <div class="request-single__pre-footer-container">
                                    <div class="requests-eq__label requests-eq__label__full_price">
                                        <span class="is-grey-text position-label">Общая сумма:</span>

                                        <span class="requests-eq__input--full js__full_price">
                                            <?php
                                            if( $total_price_usd && $total_price_rub ) {
                                                echo $total_price_rub.' <i class="fa fa-rub"></i> и '.$total_price_usd.' <i class="fa fa-usd"></i>';
                                            } elseif( $total_price_usd && !$total_price_rub ) {
                                                echo $total_price_usd.' <i class="fa fa-usd"></i>';
                                            } elseif( $total_price_rub && !$total_price_usd ) {
                                                echo $total_price_rub.' <i class="fa fa-rub"></i>';
                                            }
                                            ?>

                                        </span>
                                    </div>


                                    <div class="requests-eq__label is-mtop-5">
                                        <span class="is-grey-text position-label">Актуально до:</span>

                                        <input name="actual" type="text" id="datepicker__requests" placeholder="дд.мм.гггг" class="input__type-text       requests-eq__date date-num js__temp_save_response js__form__required-field" value="<?php if( $page_content["user_relation"]->saved_actual ) echo $page_content["user_relation"]->saved_actual; elseif($page_content["user_relation"]->disable && $page_content["user_relation"]->actual) echo $page_content["user_relation"]->actual;?>" <?php if($page_content["user_relation"]->disable):?>disabled<?php endif;?> readonly='true' data-input-name="actual">
                                        <?php if(!$page_content["user_relation"]->disable):?><i class="fa fa-calendar i-date" onclick="$('#datepicker__requests').focus();"></i><?php endif;?>
                                    </div>
                                </div>



                                <!--  Добавить комментарий  -->
                                <div class="news-advpost__form is-last-item">

                                    <a href="/partners/<?php echo $page_content["user"]->id;?>" class="m-news-add-comment__avatar      reply__form-image is-rounded">
                                        <?php if( $page_content["user"]->avatar ):?>
                                            <img class="author_avatar img-responsive" src="/uploads/users/<?php echo $page_content["user"]->id;?>/avatar/80x80_<?php echo $page_content["user"]->avatar;?>" alt="">
                                        <?php else:?>
                                            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                                        <?php endif;?>
                                    </a>

                                    <span class="m-news-add-comment__submit-container          reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                        <button type="submit" class="m-news-add-comment__submit       reply__submit is-rounded            requests__submit js__req__modal__send_answer__open" value="Отправить" >
                                            <i class="fa fa-send"></i>
                                        </button>
                                    </span>

                                    <div class="reply__form-box">
                                        <textarea name="comment" class="m-news-add-comment__textarea    js__temp_save_response reply__area is-rounded " placeholder="Добавить комментарий о возможной скидке" <?php if($page_content["user_relation"]->disable):?>disabled<?php endif;?> data-input-name="comment"><?php if( $page_content["user_relation"]->saved_comment ) echo $page_content["user_relation"]->saved_comment; else echo $page_content["user_relation"]->comment;?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>


                    <?php endif;?>
                </form>
            </div>


            <?php if( isset( $page_content["user_relation"]->actual) ):?>
                <div style="padding: 10px;">
                    <p>Актуально до: <b><?php echo $page_content["user_relation"]->actual;?></b></p>
                    <?php if( isset( $page_content["user_relation"]->comment) &&  $page_content["user_relation"]->comment != ''):?>
                        <p>Комментарий: <?php echo $page_content["user_relation"]->comment;?></p>
                    <?php endif;?>
                </div>
            <?php endif;?>
        <?php endif;?>




        <!--  Позиции заявки -->










        <!--  Подверждение  -->


        <div id="req__modal__send_answer" class="modal modal--middle is-rounded">

            <div class="modal-form">
                <div class="modal__head">
                    <div class="modal__head__section">

                        <div class="modal__head__close">
                            <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
                        </div>

                    </div>

                    <div class="modal__head__section">

                        <div class="modal__head__title">Отправить ответ?</div>

                    </div>

                    <div class="modal__head__section">

                        <div class="modal__head__submit">

                            <button class="js__request_add_form_submit" data-request-id="<?php echo $page_content["request_data"]->id;?>">
                                <span class="m-hide">Отправить</span> <i class="fa fa-check"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <div class="modal__body">
                    <div class="modal__body__white-container">
                        <p>
                            Вы не сможете редактировать данные до даты актуальности, которую вы установили, в случае если заявка будет в работе.
                        </p>
                    </div>

                </div>
            </div>

        </div>


        <!-- end Подверждение -->




    </div>

<?php
    $this->load->view("mobile/requests/html_block__print__positions");


    $this->load->view('mobile/requests/html_block__modal__cancel_executor');

    $this->load->view('mobile/misc/js/partners__open_chat');

    $this->load->view('mobile/requests/js/in_process_partner_denied');
    $this->load->view('mobile/requests/js/in_process_temp_save_response');
    $this->load->view('mobile/requests/js/in_process_send_response');
    $this->load->view('mobile/requests/js/in_process_position_price_calc');

    $this->load->view('mobile/requests/js/in_process_compare_show_comment');
