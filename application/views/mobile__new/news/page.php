<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 13.04.2018
 * Time: 20:21
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
        <div class="header__page-title t-hide">
            <?php if( $page_header["search_or_link"]['type'] == 'link' ):?>
                <a href="<?php echo $page_header["search_or_link"]['url'];?>" class="js--header__go-back   header__go-back is-white-link">
                    <i class="fa fa-caret-left"></i> <span>Назад</span>
                </a>
            <?php else:?>
                Новости
            <?php endif;?>
        </div>

        <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
    </div>
</header>

<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>

<div class="add_menu__actions">
    <i class="fa fa-plus add_menu__actions__i" aria-hidden="true"></i>
    <ul class="add_menu__actions__item is-box-shadow-bold">
        <li>
            <a href="#add-news" class="add_menu__actions__link  fancybox js__trigger_add-content fancybox__add_news">Добавить новость</a>
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

    <?php if( !array_key_exists("taxonomy", $page_content ) || !$page_content["taxonomy"]["page"] ):?>
        <section class="news-submenu flex-row">
            <a href="/news" class="news-submenu__item <?php if( !$page_content['project_news'] ):?>-active<?php endif;?>">Все Новости</a>
            <a href="/news/exdor" class="news-submenu__item <?php if( $page_content['project_news'] ):?>-active<?php endif;?>">Новости проекта</a>
        </section>
    <?php endif;?>

    <div class="ajax__news_container">
        <?php
            foreach ($page_content['news'] as $news_item):
                $last_loaded_news   = $news_item->id;
                $this->load->view('mobile/news/loop', $news_item);
            endforeach;
        ?>
    </div>

    <?php if ( count($page_content['news']) > 9 ):?>
        <!-- Кнопка Подгружаю еще -->
        <div class="load-more">
            <div class="cssload-container">
                <div class="cssload-whirlpool"></div>
            </div>
            <span>Подгружаю еще</span>
        </div>
    <?php endif;?>


</div>


<div id="add-news" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/news/modal__add');?>
</div>


<input type="hidden" id="ajax__news-user_id" value="<?php echo $page_content["user"]->id;?>">
<input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">


<?php if( isset($_GET['action']) && $_GET['action'] == 'add' ):?>
    <script>
        $(document).ready( function () {
            $(".js__trigger_add-content").trigger('click');
        });
    </script>
<?php endif;?>


<?php

    $this->load->view('mobile/news/mustache_template__loop');
    $this->load->view('mobile/news/mustache_template__loop_comments');
    $this->load->view('mobile/news/mustache_template__loop_modal');
    $this->load->view('mobile/news/mustache_template__loop__news_only');


    $this->load->view('mobile/news/js/functions');
    $this->load->view('mobile/news/js/navigation');
    $this->load->view('mobile/news/js/add_item');
    $this->load->view('mobile/news/js/get_item');
    $this->load->view('mobile/news/js/remove_item');

    $this->load->view('mobile/news/js/load_items');

    $this->load->view('mobile/news/js/comments');
    $this->load->view('mobile/news/js/likes');


    $this->load->view('mobile/news/js/search');
