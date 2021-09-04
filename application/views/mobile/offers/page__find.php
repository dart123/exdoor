<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-26
 * Time: 14:53
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
                <a href="#add-advpost" class="add_menu__actions__link    fancybox js__trigger_add-content fancybox__add_news    advpost__add-btn">Добавить объявление</a>
            </li>
            <li>
                <a href="/requests/add" class="add_menu__actions__link">Добавить заявку</a>
            </li>
        </ul>
    </div>



    <div class="content ">

        <section class="offers-submenu flex-row">
            <a href="/offers" class="offers-submenu__item">Продать</a>
            <a href="/offers/buy" class="offers-submenu__item">Купить</a>
            <a href="/offers/service" class="offers-submenu__item">Услуги</a>
        </section>


        <div class="news__search-result-title">

            Результаты поиска <?php if( $page_content['keyword'] ) echo "<b>".$page_content['keyword']."</b>";?>

        </div>

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
    $this->load->view('mobile/offers/js/search');
    $this->load->view('mobile/offers/js/search_load_items');




