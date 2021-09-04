<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 18:05
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
    <div class="my-partners is-mtop-20 ">

        <div class="my-partners__block is-rounded is-box-shadow ajax__partners__partners__list" >
            <?php if ($partners):
                foreach ($partners as $partner):
                    $this->load->view('desktop/partners/loop__partner', $partner);
                endforeach;
                endif;
            ?>
        </div>

        <!-- Кнопка Найти больше партнеров -->
        <div class="my-partners__more">
            <a class="js__open__potencial_partners is-blue-link pointer">
                <span>Найти больше партнеров</span>
            </a>
        </div>
        <!-- -->



        <?php if( $potencial_partners ):?>
            <div class="my-partners__rec is-rounded is-box-shadow is-mtop-20 js__block__potencial_partners is-hidden">
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
<script>
    $(document).ready( function () {
        $('.js__open__potencial_partners').click( function() {
            $(this).hide();
            $('.js__block__potencial_partners').removeClass('is-hidden');
        })
    });
</script>
<?php
    $this->load->view('desktop/partners/mustache_template__loop__partner');
    $this->load->view('desktop/partners/js__list_scripts');
    $this->load->view('desktop/misc/js/partners__open_chat');
    $this->load->view('desktop/user/js/search');
?>