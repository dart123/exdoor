<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 12:20
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
        <div class="header__page-title t-hide">Объявления</div>
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
            <a  href="/news/?action=add" class="add_menu__actions__link">Добавить новость</a>
        </li>
        <li>
            <a href="#add-advpost" class="add_menu__actions__link   fancybox js__trigger_add-content fancybox__add_news    advpost__add-btn">Добавить объявление</a>
        </li>
        <li>
            <a href="/requests/add" class="add_menu__actions__link">Добавить заявку</a>
        </li>
    </ul>
</div>



<div class="content ">

    <section class="offers-submenu flex-row">
        <a href="/offers" class="offers-submenu__item <?php if($page_content['menu']['offers_filter_type'] == 'sell'):?>-active<?php endif;?>">Продать</a>
        <a href="/offers/buy" class="offers-submenu__item <?php if($page_content['menu']['offers_filter_type'] == 'buy'):?>-active<?php endif;?>">Купить</a>
        <a href="/offers/service" class="offers-submenu__item <?php if($page_content['menu']['offers_filter_type'] == 'service'):?>-active<?php endif;?>">Услуги</a>
    </section>

    <section class="offers-sorting-submenu flex-row">
        <a href="#sorting-offers-categories" class="fancybox offers-sorting-submenu__item -active">Все категории <i class="fa fa-caret-down"></i> </a>
        <a href="#sorting-offers" class="fancybox offers-sorting-submenu__item"><i class="fa fa-filter"></i> Сортировка</a>
    </section>

    <div class="ajax__offers_container">
        <?php
            if ( array_key_exists("offers", $page_content ) && is_array( $page_content['offers'] ) ):
                foreach ($page_content['offers'] as $offer_item):
                    $last_loaded_offer  = $offer_item->id;
                    $this->load->view('mobile/offers/loop', $offer_item);
                endforeach;
            else:
                ?>
                <div class="my-partners__last is-no-select">Не найдено объявлений по заданным Вами параметрам</div>
            <?php
            endif;
        ?>
    </div>

    <?php if ( count($page_content['offers']) > 9 ):?>
        <!-- Кнопка Подгружаю еще -->
        <div class="load-more">
            <div class="cssload-container">
                <div class="cssload-whirlpool"></div>
            </div>
            <span>Подгружаю еще</span>
        </div>
    <?php endif;?>

</div>


<script>
    $(window).load( function (){

        <?php if( isset($offer__added) ):?>
        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
            .attr('data-notifyText',  'Ваше объявление успешно добавлено!')
            .click();
        <?php endif;?>


        <?php if( isset($offer__edited) ):?>
        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
            .attr('data-notifyText',  'Ваше объявление успешно изменено!')
            .click();
        <?php endif;?>

    });

    <?php if( isset($_GET['action']) && $_GET['action'] == 'add' ):?>
        $(document).ready( function () {
            $(".js__trigger_add-content").trigger('click');
        });
    <?php endif;?>

</script>


<div id="add-advpost" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/offers/modal__add', $page_content);?>
</div>


<div id="sorting-offers" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/offers/modal__filter', $page_content);?>
</div>


<div id="sorting-offers-categories" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/offers/modal__filter_categories', $page_content);?>
</div>


<?php
    $this->load->view('mobile/offers/mustache_template__loop');
    $this->load->view('mobile/offers/mustache_template__loop_modal');
    $this->load->view('mobile/offers/mustache_template__loop_full_width');

    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/offers/js/functions');
    $this->load->view('mobile/offers/js/navigation');
    $this->load->view('mobile/offers/js/get_item');
    $this->load->view('mobile/offers/js/add_item', array('page' => 'offers'));
    $this->load->view('mobile/offers/js/edit_item');
    $this->load->view('mobile/offers/js/remove_item');
    $this->load->view('mobile/offers/js/filter');
    $this->load->view('mobile/offers/js/load_items');
    $this->load->view('mobile/offers/js/search');



