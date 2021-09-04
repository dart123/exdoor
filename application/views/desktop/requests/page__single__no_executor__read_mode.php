<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.17
 * Time: 16:24
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

                    if ( isset($user_relation) && is_object($user_relation) ):

                        $user_relation->disable = true;

                        if ( $responses ):
                            ?>
                            <!--  Заголовок позициии -->
                            <div class="requests-step__line is-mtop-20">
                                <div class="requests-step__title">
                                    Запрашиваемые позиции
                                </div>
                            </div>
                            <!--  Запрашиваемые позиции -->
                            <div class="requests-eq__block is-rounded is-box-shadow is-mtop-20">

                                <form method="POST" class="request__add_form">
                                    <input type="hidden" name="action" value="update_response">
                                    <!--  Позиция номер 1 -->
                                    <?php

                                    $total_price_rub        = 0;
                                    $total_price_usd        = 0;

                                    if( $request_positions ):

                                            $i = 1;
                                            foreach ($request_positions as $position ):
                                                ?>

                                                <div class="requests-eq__item">

                                                    <div class="requests-eq__pos-row">
                                                        <div class="requests-eq__no"><b>#<?php echo $i;?></b></div><!--
                                                             --><div class="requests-eq__pos-descr">
                                                            <div class="position-name is-grey-text">
                                                                <?php if( $position->detail ):?>
                                                                    <p>Деталь:</p>
                                                                <?php endif;?>

                                                                <?php if( $position->catalog_num ):?>
                                                                    <p>Номер в каталогах:</p>
                                                                <?php endif;?>

                                                                <?php if( ( $responses && is_array($responses) && array_key_exists($position->id, $responses) && $responses[$position->id]->in_stock == 0 && array_key_exists($position->id, $responses) && $responses[$position->id]->shipping )  ):?>
                                                                    <p>Срок поставки:</p>
                                                                <?php endif;?>
                                                                <?php if(  $responses || ( !$responses && $user_relation->status != 'canceled' )  ):?>
                                                                    <p>Цена за единицу:</p>
                                                                    <p><b>Итого:</b></p>
                                                                <?php endif;?>
                                                            </div>
                                                            <div class="position-name">

                                                                <?php if( $position->detail ):?>
                                                                    <?php if( mb_strlen( $position->detail , 'utf8' ) >= 12 ):?>
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
                                                                    <?php if( mb_strlen( $position->catalog_num ) >= 12 ):?>
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

                                                                <?php if(  $responses || ( !$responses && $user_relation->status != 'canceled' )  ):?>
                                                                    <?php if( ( $responses && is_array($responses) && array_key_exists($position->id, $responses) &&  $responses[$position->id]->in_stock == 1 ) || $responses == false  ):?>
                                                                        <p class="request_position__report__in_stock">В наличии</p>
                                                                    <?php else:?>
                                                                        <p class="request_position__report__in_stock">Нет в наличии</p>
                                                                    <?php endif;?>
                                                                <?php endif;?>


                                                                <?php if( ( $responses && is_array($responses) && array_key_exists($position->id, $responses) && $responses[$position->id]->in_stock == 0 && array_key_exists($position->id, $responses) && $responses[$position->id]->shipping )  ):?>
                                                                    <p><?php echo $responses[$position->id]->shipping;?> дн.</p>
                                                                <?php endif;?>

                                                                <?php if(  $responses || ( !$responses && $user_relation->status != 'canceled' )  ):?>
                                                                    <p><?php
                                                                        if($responses && $responses[$position->id]->currency == 'RUB') $cur = "<i class='fa fa-rub'></i>"; else $cur = "<i class='fa fa-usd'></i>";
                                                                        echo $responses[$position->id]->price. ' ' . $cur;?> </p>
                                                                    <?php

                                                                    if( $responses && $responses[$position->id]->currency == "RUB" ){
                                                                        $total_price_rub    += $responses[$position->id]->price * $position->amount;
                                                                    } else {
                                                                        $total_price_usd    += $responses[$position->id]->price * $position->amount;
                                                                    }

                                                                    ?>
                                                                    <p><?php echo $responses[$position->id]->price * $position->amount. ' ' . $cur;?> </p>
                                                                <?php endif;?>
                                                            </div>

                                                            <?php if (!empty($position->images_arr)):?>
                                                                <a href="#" data-open-id="album-<?php echo $position->id;?>" class="requests-eq__img <?php if( count($position->images_arr) == 1):?>requests-eq__img--1<?php elseif( count($position->images_arr) == 2):?>requests-eq__img--2<?php elseif(count($position->images_arr) > 2):?>requests-eq__img--more<?php endif;?> open-album">
                                                                    <div class="requests-eq__inner">
                                                                        <img src="/uploads/requests/<?php echo $request_data->id;?>/158x158_<?php echo $position->images_arr[0];?>" alt="">
                                                                    </div>
                                                                </a>

                                                                <div class="modal__block">
                                                                    <?php foreach ($position->images_arr as $img):?>
                                                                        <a data-fancybox="album-<?php echo $position->id;?>" class="image-show" href="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>">
                                                                            <img src="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>" alt=""/>
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

                                    <?php if( $responses || ( !$responses && $user_relation->status != 'canceled' )  ):
                                        $user_relation->disable     = true;
                                        ?>
                                        <div class="requests-eq__item">
                                            <div class="requests-eq__form--time">
                                                <div class="requests-eq__label">
                                                    <span class="is-grey-text position-label">Актуально до:</span>

                                                    <input name="actual" type="text" id="datepicker__requests" placeholder="дд.мм.гггг" class="requests-eq__date date-num js__temp_save_response" value="<?php if( $user_relation->saved_actual ) echo $user_relation->saved_actual; else echo $user_relation->actual;?>" <?php if($user_relation->disable):?>disabled<?php endif;?> readonly='true' data-input-name="actual">
                                                    <?php if(!$user_relation->disable):?><i class="fa fa-calendar i-date" onclick="$('#datepicker__requests').focus();"></i><?php endif;?>
                                                </div>

                                                <label for="" class="requests-eq__label clear">
                                                    <span class="is-grey-text position-label">Комментарий</span>
                                                    <textarea name="comment" id="advpost__ta-posttext" class="requests-eq__input--full js__temp_save_response" placeholder="Добавить комментарий о возможной скидке" <?php if($user_relation->disable):?>disabled<?php endif;?> data-input-name="comment"><?php if( $user_relation->saved_comment ) echo $user_relation->saved_comment; else echo $user_relation->comment;?></textarea>
                                                </label>

                                                <div class="requests-eq__label requests-eq__label__full_price">
                                                    <span class="is-grey-text position-label">Общая сумма:</span>

                                                    <div class="requests-eq__input--full js__full_price">
                                                        <?php
                                                        if( $total_price_usd && $total_price_rub ) {
                                                            echo $total_price_rub.' <i class="fa fa-rub"></i> и '.$total_price_usd.' <i class="fa fa-usd"></i>';
                                                        } elseif( $total_price_usd && !$total_price_rub ) {
                                                            echo $total_price_usd.' <i class="fa fa-usd"></i>';
                                                        } elseif( $total_price_rub && !$total_price_usd ) {
                                                            echo $total_price_rub.' <i class="fa fa-rub"></i>';
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>

                                </form>
                            </div>

                        <?php else:
                            $this->load->view('desktop/requests/html_block__ready__positions_list');
                        endif;

                    endif;?>


            </div>









            <!--  Правый блок контента -->
            <div class="page-content-form__right">


                <div class="requests-step__line">
                    <div class="requests-step__title">
                        Статус и управление заявкой
                    </div>
                </div>

                <?php if ($request_data->status != 'canceled' && isset($user_relation) && is_object( $user_relation ) && $user_relation->status != 'canceled'):?>

                    <?php if ( isset($user_relation) && ( $user_relation->status == 'read' || $user_relation->status == 'send' ) ):?>
                        <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item">Сформирована (ожидает ответа)</div>
                            <div class="req-status__content">
                                <p>Пожалуйста, подтоговьте предложение для запрашиваемых позиций и отправьте ответ автору.</p>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if ( isset($user_relation) && ( $user_relation->status == 'answered' ) && $user_relation->disable ):?>
                        <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item">Сформирована (ответ отправлен)</div>
                            <div class="req-status__content">
                                <p>Вы отправили оценку запрашиваемых позиций автору. Изменить данные станет возможно после истечения срока актуальности.</p>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if ( isset($user_relation) && ( $user_relation->status == 'answered'  )  && !$user_relation->disable ):?>
                        <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item">Сформирована (нуждается в обновлении)</div>
                            <div class="req-status__content">
                                <p>Вы отправили оценку запрашиваемых позиций автору, но дата актуальности уже прошла. Обновите ваш ответ.</p>
                            </div>
                        </div>
                    <?php endif;?>



                <?php else:?>
                    <div class="requests-step__status requests-step__status--canceled is-rounded is-box-shadow is-mtop-20 req-status">
                        <div class="req-status__title is-first-item">Отменена</div>
                        <div class="req-status__content">
                            <p>Заявка отменена и в скором времени отправится в архив</p>
                        </div>
                    </div>
                <?php endif;?>






                <?php if( $request_author ):?>
                    <div class="requests-step__line is-mtop-20">
                        <div class="requests-step__title">
                            Автор заявки
                        </div>
                    </div>
                    <div class="requests-step__author req-author is-rounded is-box-shadow is-mtop-20 clear">
                        <?php if ( $request_author->avatar ):?>
                            <a href="/id<?php echo $request_author->id;?>" class="req-author__image req-author__image--image_exists is-rounded">
                                <img src="/uploads/users/<?php echo $request_author->id;?>/avatar/80x80_<?php echo $request_author->avatar;?>" alt="" class="img-responsive">
                            </a>
                        <?php else:?>
                            <a href="/partners/<?php echo $request_author->id;?>" class="req-author__image is-rounded ">

                            </a>
                        <?php endif;?>
                        <div class="req-author__content">
                            <div class="is-long-row">
                                <a href="/id<?php echo $request_author->id;?>" class="is-blue-link">
                                    <span>
                                        <b>
                                            <?php echo $request_author->name;?> <?php echo $request_author->second_name;?> <?php echo $request_author->last_name;?>
                                        </b>
                                    </span>
                                </a>
                            </div>

                            <?php if( is_object($request_author->company)):?>
                                <div class="is-long-row">
                                    <a href="/company/id<?php echo $request_author->company->id;?>" class="is-grey-link">
                                        <span><?php echo $request_author->company->short_name;?></span>
                                    </a>
                                </div>
                            <?php endif;?>

                            <?php if ($request_author->rating):?>
                                <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo intval($request_author->rating);?>"></div>
                            <?php endif;?>

                            <div>
                                <a class="js-partner__open_chat is-blue-link pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $request_author->id;?>">
                                    <i class="fas fa-envelope i-left-15"></i>
                                    <span>Написать сообщение</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif;?>

            </div>


        </section>


    </div>
</main>


<?php

    $this->load->view('desktop/misc/js/partners__open_chat');
    $this->load->view('desktop/requests/js/in_process_position_price_calc');
    $this->load->view('desktop/requests/js/in_process_compare_show_comment');

