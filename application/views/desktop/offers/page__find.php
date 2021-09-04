<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 31.10.2017
 * Time: 13:23
 */
?>



<main>

    <div class="container">
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <section class="page-content">
            <div class="my-partners__search-rslt">

                Результаты поиска

            </div>

            <!--  Пост от Exdor  -->

            <div class="ajax__news_container is-mtop-20">
                <?php
                if( isset($ads) && !empty($ads)):
                    foreach ($ads as $offer):
                        $this->load->view('desktop/offers/loop__full_width', $offer);
                    endforeach;
                else:
                    $last_loaded_news = false;  ?>

                    <div class="my-partners__last is-no-select">
                        Объявления не найдены
                    </div>


                    <?php
                endif;
                ?>
            </div>

            <div class="load-more">
                <div class="cssload-container">
                    <div class="cssload-whirlpool"></div>
                </div>
                <span>Подгружаю ещё</span>
            </div>
        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>



        <div class="ajax__news_modal_container">

            <?php
            if( isset($ads) && !empty($ads)):
                foreach ($ads as $offer):
                    $this->load->view('desktop/offers/loop__modal', $offer);
                endforeach;
            endif;
            ?>
        </div>
    </div>
</main>



<?php
$this->load->view('desktop/offers/mustache_template__loop');
$this->load->view('desktop/offers/mustache_template__loop_modal');
$this->load->view('desktop/offers/mustache_template__loop_full_width');

$this->load->view('desktop/misc/js/partners__open_chat');
$this->load->view('desktop/offers/js/functions');
$this->load->view('desktop/offers/js/navigation');
$this->load->view('desktop/offers/js/get_item');
$this->load->view('desktop/offers/js/edit_item');
$this->load->view('desktop/offers/js/remove_item');
$this->load->view('desktop/offers/js/search');
$this->load->view('desktop/offers/js/search_load_items');
