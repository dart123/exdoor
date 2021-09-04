<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.11.16
 * Time: 13:14
 */

?>

    <div class="preloader preloader__show">
        <img src="/assets/img/preload.gif" alt="" class="preloader__img preloader__show">
    </div>


    <main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
            <!-- Кнопка Наверх -->
            <a href="#" class="back-to-top is-blue-link">
                <i class="fas fa-caret-up"></i>
                <span>Наверх</span>
            </a>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <div class="request__add-new is-rounded is-box-shadow">
                <a href="/requests/add" class="request__add-btn or-btn btn btn-info ripple-effect">
                    <i class="fas fa-plus"></i>
                    Создать заявку
                </a>

            </div>


            <?php if ( $user->requests || $employers ):?>
            <div class="request__wrap is-rounded is-box-shadow is-mtop-20">
                <?php $this->load->view('desktop/requests/page__filter', $filter__avalible_options);?>
            </div>
            <?php endif;?>

            <div class="header__promo-space is-mtop-20">
                <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
            </div>
        </section>
        <!-- Контент -->
        <section class="page-content">
            <?php $this->load->view('desktop/requests/sub_menu', $sub_menu);?>

            <div class="main-requests is-mtop-20">

                <?php

                if ( $user->requests || $employers ):
                    $this->load->view('desktop/requests/loop__user', $user);
                    if ( $employers ):
                        foreach ($employers as $employer):
                            $this->load->view('desktop/requests/loop__user', $employer);
                        endforeach;
                    endif;
                else:?>
                    <div class="requests__last is-no-select">
                        <p>В настоящее время заявки отсутствуют.</p>
                        <?php if ( $sub_menu['selected'] != 'archive' ):?>
                            <p>Вы можете <a href="/requests/add" class="is-blue-link"><span>создать заявку</span></a> прямо сейчас!</p></div>
                        <?php else:?>
                            <p>Завки в архиве появятся автоматически после завершения работ по ним.</p>
                        <?php endif;?>
                    </div>
                <?php endif;?>

            </div>
        </section>
    </div>
</main>


<?php

    $this->load->view('desktop/requests/html_block__model__cancel_author');
    $this->load->view('desktop/requests/html_block__model__cancel_executor');

    $this->load->view('desktop/requests/mustache_template__loop__block');

    $this->load->view('desktop/misc/js/partners__open_chat');

    $this->load->view('desktop/requests/js/search');

    $this->load->view('desktop/requests/js/list_functions');
    $this->load->view('desktop/requests/js/list_filter_employers');
    $this->load->view('desktop/requests/js/list_filter_equipment');
    $this->load->view('desktop/requests/js/list_filter');

    $this->load->view('desktop/requests/js/in_process_author_denied');
    $this->load->view('desktop/requests/js/in_process_partner_denied');
    $this->load->view('desktop/requests/js/in_process_copy');
    $this->load->view('desktop/requests/js/in_process_send_to_archive');
?>