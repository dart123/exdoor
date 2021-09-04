<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 23/10/2018
 * Time: 14:30
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
            <div class="header__page-title t-hide">Партнеры</div>

            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
        </div>
    </header>

    <div class="content">

        <div class="my-partners__last is-no-select">
            Пользователь деактивирован
        </div>

    </div>


<?php

    $this->load->view('mobile/user/js/search');