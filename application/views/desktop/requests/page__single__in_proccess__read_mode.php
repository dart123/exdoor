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
                                                    <p class="request_position__report__in_stock">Нет в наличии</p>
                                                <?php endif;?>
                                            <?php endif;?>

                                            <?php if( $position->amount > 1 ):?>
                                                <p>
                                                    <?php echo number_format($request_executor->responses[$position->id]->price, 0, ',', ' ');?>
                                                    <i class="fa fa-rub"></i>
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
                            <?php
                        endif;
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
                ?>

                    <div class="requests-step__line">
                        <div class="requests-step__title">
                            Статус и управление заявкой
                        </div>
                    </div>

                    <div class="requests-step__status <?php echo $request_state_class;?> is-rounded is-box-shadow is-mtop-20 req-status">
                        <div class="req-status__title is-first-item">
                            <?php echo $request_state_text;?>
                        </div>

                        <?php if( $_GET['employer'] == $request_data->author ):?>
                        <div class="req-status__content" style="border-top:1px solid #e5e5e5">
                            <div class="">
                                <a href="/requests/<?php echo $request_data->id;?>/compare?&view=b&employer=<?php echo $_GET['employer'];?>" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                    <span>Просмотреть ответы</span>
                                </a>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>







                <?php if( $request_executor ):?>
                    <!--  Заголовок 2 -->
                    <div class="requests-step__line is-mtop-20">
                        <div class="requests-step__title">
                            Исполнитель заявки
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
                            Автор заявки
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
                                <a href="/partners/<?php echo $request_author->id;?>" class="is-blue-link"><span><b><?php echo $request_author->name;?> <?php echo $request_author->second_name;?> <?php echo $request_author->last_name;?></b></span></a>
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

    $this->load->view('desktop/misc/js/partners__open_chat');

    $this->load->view('desktop/requests/js/in_process_compare_show_comment');

