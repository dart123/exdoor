<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2018-12-02
 * Time: 19:08
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

            <div class="ajax__offers_container">
                <?php if ( $page_content["offer"] ):
                        $this->load->view('mobile/offers/guest__loop', $page_content["offer"] );
                    endif;
                ?>
            </div>

        </section>


    </div>


<?php
    $this->load->view('mobile/offers/guest__js__scripts');


