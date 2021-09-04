<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.17
 * Time: 16:22
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

        <!--  Статус заявки -->

        <?php /*
            <div class="requests-step__line">
                <div class="requests-step__title">
                    Статус и управление заявкой
                </div>
                <?php if( $page_content["request_data"]->status != 'canceled'):?>
                    <a class="requests-step__action is-or-link pointer js__requests_list__author_denied" data-request-id="<?php echo $page_content["request_data"]->id;?>" data-page-reload="yes">
                        <span>Отменить заявку</span>
                    </a>
                <?php endif;?>
            </div>
            <!--  Блок статуса -->
            */?>

        <?php if( $page_content["request_data"]->executor == 0 ):?>
            <?php if ($page_content["request_data"]->status == 'send'):?>
                <div class="requests-step__status requests-step__status--formed is-box-shadow  req-status">
                    <div class="req-status__title">Сформирована (отправлена)</div>
                    <div class="req-status__content">
                        <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>
                    </div>
                </div>
            <?php elseif ($page_content["request_data"]->status == 'read'):?>
                <div class="requests-step__status requests-step__status--formed  is-box-shadow req-status">
                    <div class="req-status__title">Сформирована (в обработке)</div>
                    <div class="req-status__content">
                        <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>

                        <div class="is-mtop-10">
                            <a href="/requests/<?php echo $page_content["request_data"]->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                <span>Просмотреть ответы</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php elseif ($page_content["request_data"]->status == 'answered'):?>
                <div class="requests-step__status requests-step__status--formed is-box-shadow req-status">
                    <div class="req-status__title"><?php echo $page_content["request_data"]->answered_text;?></div>
                    <div class="req-status__content">
                        <p>Статус изменится автоматически после того, как выбранные партнеры начнут обработку заявки.</p>

                        <div class="is-mtop-10">
                            <a href="/requests/<?php echo $page_content["request_data"]->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                <span>Просмотреть ответы</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php elseif ($page_content["request_data"]->status == 'canceled'):?>
                <div class="requests-step__status requests-step__status--canceled is-box-shadow req-status">
                    <div class="req-status__title">Отменена</div>
                    <div class="req-status__content">
                        <p>Заявка отменена и в скором времени отправится в архив</p>

                        <div class="is-mtop-10">
                            <a href="/requests/<?php echo $page_content["request_data"]->id;?>/compare" class="req-status__open-btn btn ripple-effect btn-primary2 is-rounded">
                                <span>Просмотреть ответы</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <?php endif;?>


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

        if( $page_content["request_positions"] ):
            $this->load->view('mobile/requests/html_block__ready__positions_list');
        endif;
        ?>



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

$this->load->view('mobile/requests/js/in_process_copy');

$this->load->view('mobile/requests/js/in_process_compare_show_comment');
