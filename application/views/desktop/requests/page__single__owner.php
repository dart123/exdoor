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

            <!--  Левый блок контента -->
            <div class="page-content-form__left">


                <?php
                    $this->load->view('desktop/requests/html_block__ready__title');
                    $this->load->view('desktop/requests/html_block__ready__equipment');

                    if( $request_positions ):
                        $this->load->view('desktop/requests/html_block__ready__positions_list');
                    endif;
                ?>

            </div>

            <!--  Правый блок контента -->
            <div class="page-content-form__right">
                <!--  Заголовок -->
                <div class="requests-step__line">
                    <div class="requests-step__title">
                        Статус и управление заявкой
                    </div>
                    <?php if( $request_data->status != 'canceled'):?>
                        <a class="requests-step__action is-or-link pointer js__requests_list__author_denied" data-request-id="<?php echo $request_data->id;?>" data-page-reload="yes">
                            <span>Отменить заявку</span>
                        </a>
                    <?php endif;?>
                </div>
                <!--  Блок статуса -->
                <?php if( $request_data->executor == 0 ):?>
                    <?php if ($request_data->status == 'send'):?>
                        <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item">Сформирована (отправлена)</div>
                            <div class="req-status__content">
                                <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>
                            </div>
                        </div>
                    <?php elseif ($request_data->status == 'read'):?>
                        <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item">Сформирована (в обработке)</div>
                            <div class="req-status__content">
                                <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>

                                <div class="is-mtop-10">
                                    <a href="/requests/<?php echo $request_data->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                        <span>Просмотреть ответы</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($request_data->status == 'answered'):?>
                        <div class="requests-step__status requests-step__status--formed is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item"><?php echo $request_data->answered_text;?></div>
                            <div class="req-status__content">
                                <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>

                                <div class="is-mtop-10">
                                    <a href="/requests/<?php echo $request_data->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                        <span>Просмотреть ответы</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($request_data->status == 'canceled'):?>
                        <div class="requests-step__status requests-step__status--canceled is-rounded is-box-shadow is-mtop-20 req-status">
                            <div class="req-status__title is-first-item">Отменена</div>
                            <div class="req-status__content">
                                <p>Заявка отменена и в скором времени отправится в архив</p>

                                <div class="is-mtop-10">
                                    <a href="/requests/<?php echo $request_data->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                        <span>Просмотреть ответы</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endif;?>



                <?php if( $request_partners ):?>
                    <?php $this->load->view('desktop/requests/html_block__ready__candidats');?>
                <?php endif;?>



                <!--  Заголовок 3 -->
                <div class="requests-step__line is-mtop-20">
                    <div class="requests-step__title">
                        Автор заявки (Вы)
                    </div>
                </div>

                <!--  Автор заявки -->
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
                                    <b><?php echo $request_author->name;?> <?php echo $request_author->second_name;?> <?php echo $request_author->last_name;?></b>
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


    </div>
</main>


<?php


    $this->load->view('desktop/requests/html_block__model__cancel_author');
    $this->load->view('desktop/requests/html_block__model__cancel_executor');

    $this->load->view('desktop/requests/js/in_process_author_denied');
    $this->load->view('desktop/requests/js/in_process_set_executor');
    $this->load->view('desktop/requests/js/in_process_send_to_archive');

    $this->load->view('desktop/requests/js/in_process_compare_show_comment');
