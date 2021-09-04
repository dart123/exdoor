<?php
/**
 * Created by developer with PhpStorm.
 * Date: 02/10/2018 12:16
 *
 *
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
                Объявление
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

<div class="content ">


        <?php
            if( isset($page_content['offer']) && is_object( $page_content['offer'] )):
                $this->load->view('mobile/offers/loop__single', $page_content['offer']);
            endif;
        ?>

</div>



<?php
    $this->load->view('mobile/offers/mustache_template__loop');
    $this->load->view('mobile/offers/mustache_template__loop_modal');
    $this->load->view('mobile/offers/mustache_template__loop_full_width');

    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/offers/js/functions');
    $this->load->view('mobile/offers/js/get_item');
    $this->load->view('mobile/offers/js/add_item', array('page' => 'offers'));
    $this->load->view('mobile/offers/js/edit_item');
    $this->load->view('mobile/offers/js/remove_item');
    $this->load->view('mobile/offers/js/filter');
    $this->load->view('mobile/offers/js/load_items');



