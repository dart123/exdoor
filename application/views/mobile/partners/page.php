<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 13:13
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
        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__partners__list" >
            <?php foreach ($page_content["partners"] as $partner):
                $this->load->view('mobile/partners/loop__partner', $partner);
            endforeach;?>
        </div>
    <?php else:?>
        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__partners__list"></div>
        <div class="my-partners__last is-no-select">У вас пока что нет партнеров</div>
    <?php endif;?>


    <!-- Кнопка Найти больше партнеров -->
    <div class="my-partners__more">
        <a href="#" class="js__open__potencial_partners is-blue-link ">
            <span>Найти больше партнеров</span>
        </a>
    </div>
    <!-- -->



    <?php if( $page_content["potencial_partners"] ):?>
        <div class="my-partners__rec is-rounded is-box-shadow is-mtop-20 js__block__potencial_partners is-hidden">
            <div class="rec__head is-first-item">
                <div class="rec__title">Рекомендации</div>
            </div>
            <div class="rec__body">

                <?php foreach ($page_content["potencial_partners"] as $p_partner ):
                    $this->load->view('mobile/partners/loop__partner__potencial', $p_partner);
                endforeach; ?>

            </div>
        </div>
    <?php endif;?>


</div>

<script>
    $(document).ready( function () {
        $('.js__open__potencial_partners').click( function() {
            $(this).hide();
            $('.js__block__potencial_partners').removeClass('is-hidden');
        })
    });
</script>

<?php
    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/partners/js__list_scripts');
    $this->load->view('mobile/user/js/search');
