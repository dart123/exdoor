<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.2018
 * Time: 17:03
 */

?>


<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <!-- Контент -->
        <section class="page-content">

            <div class="section-user-info is-rounded is-box-shadow">
                <div class="section-user-info__portrait user-portrait is-b-left">

                    <div class="user-portrait__img">
                        <div class="my-pers-profile__helpers">
                            <div class="helpers-signs__content is-blue-link">
                                <div class="helpers-signs__icons">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="my-partners__last is-no-select">
                    Пользователь деактивирован
                </div>
                
            </div>

        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>

    </div>
</main>

<?php
    $this->load->view('desktop/news/mustache_template__loop');
    $this->load->view('desktop/news/mustache_template__loop_modal');
    $this->load->view('desktop/news/mustache_template__loop_comments');
    $this->load->view('desktop/news/mustache_template__loop__news_only');

    $this->load->view('desktop/offers/mustache_template__loop');
    $this->load->view('desktop/offers/mustache_template__loop_full_width');
    $this->load->view('desktop/offers/mustache_template__loop_modal');

    $this->load->view('desktop/misc/js/partners__open_chat');

    $this->load->view('desktop/partners/js/partner_functions');
    $this->load->view('desktop/partners/js/partner_accept');
    $this->load->view('desktop/partners/js/partner_add');
    $this->load->view('desktop/partners/js/partner_cancel');
    $this->load->view('desktop/partners/js/partner_messages');
    //$this->load->view('desktop/partners/js/partner_remove');
    $this->load->view('desktop/user/js/search');

    $this->load->view('desktop/user/js/functions');
    $this->load->view('desktop/user/js/load_user_content');

    $this->load->view('desktop/offers/js/functions');
    $this->load->view('desktop/offers/js/get_item');
