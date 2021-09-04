<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 12:45
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
        <div class="header__page-title t-hide">Заявки</div>
        <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
    </div>
</header>



<div class="add_menu__actions">
    <i class="fa fa-plus add_menu__actions__i" aria-hidden="true"></i>
    <ul class="add_menu__actions__item is-box-shadow-bold">
        <li>
            <a href="/news/?action=add" class="add_menu__actions__link">Добавить новость</a>
        </li>
        <li>
            <a href="/offers/?action=add" class="add_menu__actions__link">Добавить объявление</a>
        </li>
        <li>
            <a href="/requests/add" class="add_menu__actions__link">Добавить заявку</a>
        </li>
    </ul>
</div>


<div class="content">

    <section class="request-submenu flex-row">
        <a href="/requests" class="request-submenu__item <?php if($page_content['sub_menu']['selected'] == 'outbox'):?>-active<?php endif;?>">Исходящие</a>
        <a href="/requests/inbox" class="request-submenu__item <?php if($page_content['sub_menu']['selected'] == 'inbox'):?>-active<?php endif;?>">Входящие</a>
        <a href="/requests/archive" class="request-submenu__item <?php if($page_content['sub_menu']['selected'] == 'archive'):?>-active<?php endif;?>">Архив</a>
    </section>

    <section class="request-sorting-submenu flex-row">
        <a href="#filter-requests" class="fancybox request-sorting-submenu__item -active">Во всех статусах <i class="fa fa-caret-down"></i> </a>
        <a href="#sorting-requests" class="fancybox request-sorting-submenu__item"><i class="fa fa-filter"></i> Сортировка</a>
    </section>

    <?php if ( $page_content["user"]->requests || $page_content["employers"] ):

        $this->load->view('mobile/requests/loop__user', $page_content["user"]);

        if ( $page_content["employers"] ):
            foreach ($page_content["employers"] as $employer):
                $this->load->view('mobile/requests/loop__user', $employer);
            endforeach;
        endif;?>

    <?php else: ?>

        <div class="requests__last is-no-select">
            <p>В настоящее время заявки отсутствуют.</p>
            <?php if ( $page_content["sub_menu"]['selected'] != 'archive' ):?>
                <p>Вы можете <a href="/requests/add" class="is-blue-link"><span>создать заявку</span></a> прямо сейчас!</p>
            <?php else:?>
                <p>Завки в архиве появятся автоматически после завершения работ по ним.</p>
            <?php endif;?>
        </div>

    <?php endif;?>


    <div id="filter-requests" class="modal" tabindex="-1" role="dialog">
        <?php $this->load->view('mobile/requests/modal__filter', $page_content);?>
    </div>


    <div id="sorting-requests" class="modal" tabindex="-1" role="dialog">
        <?php $this->load->view('mobile/requests/modal__filter_sorting', $page_content);?>
    </div>

</div>




<?php

    $this->load->view('mobile/requests/html_block__modal__cancel_author');
    $this->load->view('mobile/requests/html_block__modal__cancel_executor');

    $this->load->view('mobile/requests/mustache_template__loop__block');

    $this->load->view('mobile/misc/js/partners__open_chat');

    $this->load->view('mobile/requests/js/search');

    $this->load->view('mobile/requests/js/list_functions');
    $this->load->view('mobile/requests/js/list_filter_employers');
    $this->load->view('mobile/requests/js/list_filter_equipment');
    $this->load->view('mobile/requests/js/list_filter');

    $this->load->view('mobile/requests/js/in_process_author_denied');
    $this->load->view('mobile/requests/js/in_process_partner_denied');
    $this->load->view('mobile/requests/js/in_process_copy');
    $this->load->view('mobile/requests/js/in_process_send_to_archive');
