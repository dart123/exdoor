<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 23/10/2018
 * Time: 14:34
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
            <div class="header__page-title t-hide">Партнеры</div>
            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>

        </div>
    </header>

    <style>
        .content img {
            width: 100%;
            height: auto;
        }
    </style>

    <div class="content">


        <?php if( $page_content["friends"] ):?>
            <div class="my-partners__search-rslt">

                Найдено партнеров: <span><?php echo $page_content["found__friends"];?></span>

            </div>
            <div class="my-partners__block is-box-shadow">
                <?php foreach( $page_content["friends"] as $u ):
                    $this->load->view('mobile/partners/loop__partner', $u);
                endforeach;?>
            </div>
        <?php endif;?>




        <?php if( $page_content["users"]  ):?>
            <div class="my-partners__search-rslt">
                <?php if( $page_content['keyword'] ) echo "Поиск по фразе <b>".$page_content['keyword']."</b><br>";?>
                Найдено потенциальных партнеров: <span><?php echo $page_content["found__users"];?></span>

            </div>
            <div class="my-partners__block is-box-shadow">
                <?php foreach( $page_content["users"]  as $u ):
                    $this->load->view('mobile/partners/loop__partner__potencial', $u);
                endforeach;?>
            </div>
        <?php endif;?>





        <?php if( $page_content["companies"]  ):?>
            <div class="my-partners__search-rslt is-mtop-10">
                Найдено компаний: <span><?php echo $page_content["found__companies"];?></span>
            </div>
            <div class="my-partners__block is-box-shadow">
                <?php foreach( $page_content["companies"] as $c ):
                    $this->load->view('mobile/partners/loop__companies__potencial', $c);
                endforeach;?>
            </div>
        <?php endif;?>



    </div>


<?php
    $this->load->view('mobile/misc/js/partners__open_chat');

    $this->load->view('mobile/partners/js__list_scripts');
    $this->load->view('mobile/user/js/search');
