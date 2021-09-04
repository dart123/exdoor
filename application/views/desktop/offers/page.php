<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 18:08
 */
?>

<div class="preloader preloader__show">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img preloader__show">
</div>



<main>
    <div class="container">
        <div class="main-features">
             <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <section class="additional-features">
            <div class="advpost__add-new is-rounded is-box-shadow">
                <a href="#add-advpost" class="advpost__add-btn or-btn btn btn-info ripple-effect">
                    <i class="fas fa-plus"></i>
                    Создать объявление
                </a>
            </div>
            <div class="advpost__wrap is-rounded is-box-shadow is-mtop-20">
                <?php $this->load->view('desktop/offers/page__filter');?>
            </div>
            <div class="is-mtop-20">
                <?php $this->load->view('desktop/user/template__right-sidebar-offers');?>
            </div>
        </section>
        <section class="page-content-masonry">
            <div class="sub-menu sub-menu--wide">
                <ul class="sub-menu__list">
                    <li><a href="/offers" class="<?php if($menu['offers_filter_type'] == 'sell'):?>active<?php endif;?> is-fade">Продать</a></li>
                    <li><a href="/offers/buy" class="<?php if($menu['offers_filter_type'] == 'buy'):?>active<?php endif;?> is-fade">Купить</a></li>
                    <li><a href="/offers/service" class="<?php if($menu['offers_filter_type'] == 'service'):?>active<?php endif;?> is-fade">Услуги</a></li>
                </ul>
            </div>

            <div class="advpost__block eq__block clear is-mtop-20 ajax__offers_container">
                <?php if ( $offers ):
                    foreach ( $offers as $offer ):
                        $this->load->view('desktop/offers/loop', $offer);
                    endforeach;
                endif;
                ?>
            </div>
            <div class="load-more">
                <div class="cssload-container">
                    <div class="cssload-whirlpool"></div>
                </div>
                <span>Подгружаю еще</span>
            </div>
        </section>
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>
        <div id="add-advpost" class="modal is-rounded">
            <?php $this->load->view('desktop/offers/modal__add');?>
        </div>
        <div class="ajax__modal_fancy_ads ajax__offers_modal_container">

            <?php if ( $offers ):?>
                <?php foreach ( $offers as $offer ):?>
                    <?php $this->load->view('desktop/offers/loop__modal', $offer);?>
                <?php endforeach;?>
            <?php endif;?>

        </div>
    </div>
</main>


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

</script>

<?php
    $this->load->view('desktop/offers/mustache_template__loop');
    $this->load->view('desktop/offers/mustache_template__loop_modal');
    $this->load->view('desktop/offers/mustache_template__loop_full_width');

    $this->load->view('desktop/misc/js/partners__open_chat');
    $this->load->view('desktop/offers/js/functions');
    $this->load->view('desktop/offers/js/navigation');
    $this->load->view('desktop/offers/js/get_item');
    $this->load->view('desktop/offers/js/add_item', array('page' => 'offers'));
    $this->load->view('desktop/offers/js/edit_item');
    $this->load->view('desktop/offers/js/remove_item');
    $this->load->view('desktop/offers/js/filter');
    $this->load->view('desktop/offers/js/load_items');
    $this->load->view('desktop/offers/js/search');
?>