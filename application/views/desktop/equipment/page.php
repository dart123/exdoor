<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.11.16
 * Time: 15:43
 */
?>

<div class="preloader preloader__show">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img preloader__show">
</div>

<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <div class="eq__add-new is-rounded is-box-shadow">
                <a href="#add-equipment" class="eq__add-btn or-btn btn btn-info ripple-effect">
                    <i class="fas fa-plus"></i>
                    Добавить технику
                </a>
            </div>

            <?php if ($equipment):?>
                <div class="advpost__wrap is-rounded is-box-shadow is-mtop-20 ajax__filter_brands">
                    <?php $this->load->view('desktop/equipment/page__filter');?>
                </div>
            <?php endif;?>

            <div class="is-mtop-20">
                <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
            </div>

        </section>
        <!-- Контент -->
        <section class="page-content-masonry">
            <!-- Блок списка техники -->

                <ul class="eq__block ajax__equipment_container">
                    <?php
                        if ($equipment):
                            foreach ( $equipment as $eq):
                                $this->load->view('desktop/equipment/loop', $eq);
                            endforeach;
                        endif;
                    ?>
                </ul>

            <?php if( !$equipment ):?>
                <script>
                    $(window).load(function () {
                        $('.eq__add-btn').trigger('click');
                    })
                </script>
            <?php endif;?>

            <!-- Кнопка Подгружаю еще -->
            <div class="load-more">
                <div class="cssload-container">
                    <div class="cssload-whirlpool"></div>
                </div>
                <span>Подгружаю еще</span>
            </div>
        </section>
        <!-- Кнопка Наверх -->

        <!-- Добавить технику -->
        <div id="add-equipment" class="modal is-rounded">
            <?php $this->load->view('desktop/equipment/modal__add');?>
        </div>
    </div>
</main>

<?php
    $this->load->view('desktop/equipment/mustache_template__loop');
    $this->load->view('desktop/equipment/js__scripts');

    $this->load->view('desktop/user/js/search');

    $this->load->view('desktop/misc/js/pixie2');
