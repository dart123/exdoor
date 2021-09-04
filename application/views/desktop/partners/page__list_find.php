<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.07.16
 * Time: 10:32
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
    <?php /* $this->load->view('desktop/user/menu_partners', $sub_menu); */ ?>




    <?php if( $friends ):?>
        <div class="my-partners__search-rslt">

            Найдено партнеров: <span><?php echo $found__friends;?></span>

        </div>
        <div class="my-partners__block is-box-shadow is-rounded is-mtop-20">
            <?php foreach( $friends as $u ):
                $this->load->view('desktop/partners/loop__partner', $u);
            endforeach;?>
        </div>
    <?php endif;?>




    <?php if( $users ):?>
        <div class="my-partners__search-rslt">

            Найдено потенциальных партнеров: <span><?php echo $found__users;?></span>

        </div>
        <div class="my-partners__block is-box-shadow is-rounded is-mtop-20">
            <?php foreach( $users as $u ):
                $this->load->view('desktop/partners/loop__partner__potencial', $u);
            endforeach;?>
        </div>
    <?php endif;?>





    <?php if( $companies ):?>
        <div class="my-partners__search-rslt is-mtop-10">
            Найдено компаний: <span><?php echo $found__companies;?></span>
        </div>
        <div class="my-partners__block is-box-shadow is-rounded is-mtop-20">
            <?php foreach( $companies as $c ):
                $this->load->view('desktop/partners/loop__companies__potencial', $c);
            endforeach;?>
        </div>
    <?php endif;?>



    <div class="my-partners__last is-no-select">Больше совпадений нет</div>
<!-- Кнопка Подгружаю еще -->
</section>
<!-- Кнопка Наверх -->
</div>
</main>

<?php
    $this->load->view('desktop/misc/js/partners__open_chat');

    $this->load->view('desktop/partners/js/partner_company_add_all');
    $this->load->view('desktop/partners/js__list_scripts');
    $this->load->view('desktop/requests/js/search');
    $this->load->view('desktop/user/js/search');