<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.2018
 * Time: 18:41
 */

?>


<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>


<main>
    <div class="container">
        <div class="main-features">
            <?php
            $this->load->view('desktop/user/menu_user', $menu); ?>
        </div>

        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <section class="page-content">

            <div class="section-user-info is-rounded is-box-shadow">
                <div class="section-user-info__portrait user-portrait is-b-left">

                    <div class="user-portrait__img">
                        <div class="my-pers-profile__helpers">
                            <div class="helpers-signs__content is-blue-link">
                                <div class="helpers-signs__icons">
                                    <i class="fa fa-home"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="my-partners__last is-no-select">
                    Компания деактивирована
                </div>

            </div>

        </section>
    </div>
</main>


<?php

$this->load->view('desktop/requests/html_block__model__cancel_author');
$this->load->view('desktop/requests/html_block__model__cancel_executor');

$this->load->view('desktop/company/modal__add_employer');
$this->load->view('desktop/company/modal__no_employer');



$this->load->view('desktop/news/mustache_template__loop');
$this->load->view('desktop/news/mustache_template__loop_comments');
$this->load->view('desktop/news/mustache_template__loop_modal');
$this->load->view('desktop/news/mustache_template__loop__news_only');

$this->load->view('desktop/company/mustache_template__new_employer');
$this->load->view('desktop/company/mustache_template__new_employer__modal');
$this->load->view('desktop/company/mustache_template__new_employer__edit_page');

$this->load->view('desktop/requests/mustache_template__loop__block');

$this->load->view('desktop/user/js/search');

$this->load->view('desktop/company/js/news_loader');

$this->load->view('desktop/requests/js/list_functions');
$this->load->view('desktop/requests/js/in_process_author_denied');
$this->load->view('desktop/requests/js/in_process_partner_denied');
$this->load->view('desktop/requests/js/in_process_copy');
$this->load->view('desktop/requests/js/in_process_send_to_archive');

$this->load->view('desktop/company/js__scripts');

$this->load->view('desktop/company/js/modal__add_employer');
$this->load->view('desktop/company/js/modal__no_employer');

