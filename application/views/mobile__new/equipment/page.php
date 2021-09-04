<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 12:10
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
        <div class="header__page-title t-hide">Парк техники</div>

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
    <section class="equipment-sorting-submenu flex-row">
        <a href="#filter-equipment" class="equipment-sorting-submenu__item -active       fancybox fancybox__add_news">Все производители <i class="fa fa-caret-down"></i> </a>
    </section>
    <ul class="ajax__equipment_container">
        <?php
            if ( $page_content["equipment"] ):
                foreach ( $page_content["equipment"] as $eq):
                    $this->load->view('mobile/equipment/loop', $eq);
                endforeach;
            endif;
        ?>
    </ul>

</div>

<div class="add_menu__actions">
    <a href="#add-equipment" class="fancybox eq__add-btn">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</div>



<div id="add-equipment" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/equipment/modal__add');?>
</div>

<div id="filter-equipment" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/equipment/page__filter', $page_content);?>
</div>

<?php
    $this->load->view('mobile/equipment/mustache_template__loop');
    $this->load->view('mobile/equipment/js/scripts');

    $this->load->view('desktop/misc/js/pixie2');