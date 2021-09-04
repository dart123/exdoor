<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 23/10/2018
 * Time: 14:33
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

<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>

<div class="content">

    <?php $this->load->view('mobile/user/menu_partners', $page_content["sub_menu"] );?>


    <?php if ($page_content["partners"]):?>
        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__inbox__requests">
            <?php foreach ($page_content["partners"] as $partner):
                $this->load->view('mobile/partners/loop__request_inbox', $partner);
            endforeach;?>
        </div>
    <?php else:?>
        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__inbox__requests"></div>
        <div class="my-partners__last is-no-select">Нет входящих заявок на добавление в партнеры</div>
    <?php endif;?>


</div>

<?php
    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/partners/js__list_scripts');
    $this->load->view('mobile/user/js/search');