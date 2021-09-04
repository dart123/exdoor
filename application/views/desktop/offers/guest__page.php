<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:35
 */
?>

<div class="preloader preloader__show">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img preloader__show">
</div>



<main>
    <div class="container">
        <div class="main-features">
            <ul class="main-menu__list">
                <?php $this->load->view('desktop/misc/guest__html__menu', $menu);?>
            </ul>
        </div>
        <section class="additional-features">
            <div style="margin-top: 60px;"></div>
            <div class="advpost__wrap is-rounded is-box-shadow">
                <?php $this->load->view('desktop/offers/page__filter');?>
            </div>
            <div class="is-mtop-20">
                <?php $this->load->view('desktop/user/template__right-sidebar-offers');?>
            </div>
        </section>
        <section class="page-content-masonry">
            <div class="sub-menu sub-menu--wide">
                <ul class="sub-menu__list">
                    <li><a href="/offers" class="<?php if($menu['ads_filter_type'] == 'sell'):?>active<?php endif;?> is-fade">Продать</a></li>
                    <li><a href="/offers/buy" class="<?php if($menu['ads_filter_type'] == 'buy'):?>active<?php endif;?> is-fade">Купить</a></li>
                    <li><a href="/offers/service" class="<?php if($menu['ads_filter_type'] == 'service'):?>active<?php endif;?> is-fade">Услуги</a></li>
                </ul>
            </div>

            <div class="advpost__block eq__block clear is-mtop-20 ajax__offers_container">
                <?php if ( $ads ):
                    foreach ( $ads as $ad ):
                        $this->load->view('desktop/offers/guest__loop', $ad);
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

        <div class="ajax__modal_fancy_ads ajax__offers_modal_container">

            <?php if($current_offer && $current_offer_id):
                $this->load->view('desktop/offers/guest__loop__modal', $current_offer);
                ?>
                <a href="#adv-post<?php echo $current_offer_id;?>" data-fancybox="adv-group" id="js__current_offer_opener" class="fancybox__adv-news"></a>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#js__current_offer_opener").fancybox().trigger('click');
                    });
                </script>
            <?php endif;?>
            <?php if ( $ads ):?>
                <?php foreach ( $ads as $ad ):?>
                    <?php $this->load->view('desktop/offers/guest__loop__modal', $ad);?>
                <?php endforeach;?>
            <?php endif;?>

        </div>
    </div>
</main>

<?php
    $this->load->view('desktop/offers/guest__mustache_template__loop');
    $this->load->view('desktop/offers/guest__mustache_template__loop_modal');


    $this->load->view('desktop/offers/guest__js__scripts');
?>
