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


<div class="content">

    <?php
    if ( array_key_exists("news", $page_content) ):
        $last_loaded_news   = $page_content['news']->id;
        $this->load->view('mobile/news/loop__single', $page_content['news']);
    else:
        ?>

        Указанная новость удалена, либо еще не создана

    <?php
    endif;
    ?>

</div>

<div id="edit-news-comment" tabindex="-1" class="modal">
    <?php $this->load->view('mobile/news/modal__edit_comment');?>
</div>


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


    $this->load->view('desktop/news/js/search');

