<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:35
 */
?>

<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>


<div class="content">

    <section class="page-content">

        <section class="offers-submenu flex-row">
            <a href="/offers" class="offers-submenu__item <?php if($page_content["menu"]['ads_filter_type'] == 'sell'):?>active<?php endif;?> is-fade">Продать</a>
            <a href="/offers/buy" class="offers-submenu__item <?php if($page_content["menu"]['ads_filter_type'] == 'buy'):?>active<?php endif;?> is-fade">Купить</a>
            <a href="/offers/service" class="offers-submenu__item <?php if($page_content["menu"]['ads_filter_type'] == 'service'):?>active<?php endif;?> is-fade">Услуги</a>
        </section>

        <section class="offers-sorting-submenu flex-row">
            <a href="#sorting-offers-categories" class="fancybox offers-sorting-submenu__item -active">Все категории <i class="fa fa-caret-down"></i> </a>
            <a href="#sorting-offers" class="fancybox offers-sorting-submenu__item"><i class="fa fa-filter"></i> Сортировка</a>
        </section>

        <div class="ajax__offers_container">
            <?php if ( $page_content["ads"] ):
                foreach ( $page_content["ads"] as $ad ):
                    $this->load->view('mobile/offers/guest__loop', $ad);
                endforeach;
            endif;
            ?>
        </div>

    </section>


</div>


<div id="sorting-offers" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/offers/modal__filter', $page_content);?>
</div>


<div id="sorting-offers-categories" class="modal" tabindex="-1" role="dialog">
    <?php $this->load->view('mobile/offers/modal__filter_categories', $page_content);?>
</div>


<?php
    $this->load->view('mobile/offers/guest__mustache_template__loop');
    $this->load->view('mobile/offers/guest__js__scripts');

