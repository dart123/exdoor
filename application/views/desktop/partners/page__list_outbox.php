<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.16
 * Time: 12:54
 */
?>

<main>
<div class="container">
<!-- Левый сайдбар -->
<div class="main-features">
    <?php $this->load->view('desktop/user/menu_user', $menu);?>
</div>
<!-- Правый сайдбар -->
<section class="additional-features">
    <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
</section>
<!-- Контент -->
<section class="page-content">
    <?php $this->load->view('desktop/user/menu_partners', $sub_menu);?>

<!--  Блок Мои партнеры  -->
<div class="my-partners is-mtop-20">
    <!-- Список партнеров -->

    <?php if ($partners):?>
        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__outbox__requests">
            <?php
                foreach ($partners as $partner):
                    $this->load->view('desktop/partners/loop__request_outbox', $partner);
                endforeach;
            ?>
        </div>
    <?php else:?>
        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__outbox__requests"></div>
        <div class="my-partners__last is-no-select">Нет исходящих заявок на добавление в партнеры</div>
    <?php endif;?>
    <!-- -->

    <?php if( $potencial_partners ):?>
        <div class="my-partners__rec is-rounded is-box-shadow is-mtop-20">
            <div class="rec__head is-first-item">
                <div class="rec__title">Рекомендации</div>
            </div>
            <div class="rec__body">

                <?php foreach ($potencial_partners  as $p_partner ):
                    $this->load->view('desktop/partners/loop__partner__potencial', $p_partner);
                endforeach;
                ?>

            </div>
        </div>
    <?php endif;?>
</div>
<!-- Кнопка Подгружаю еще -->

</section>
<!-- Кнопка Наверх -->
</div>
</main>

<?php
    $this->load->view('desktop/partners/js__list_scripts');
    $this->load->view('desktop/user/js/search');