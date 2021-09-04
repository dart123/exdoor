<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 22/10/2018
 * Time: 11:51
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
        <div class="header__page-title t-hide">Моя компания</div>

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


    <section class="profile">
        <div class="profile__info profile-info">

            <!-- если профиль заполнен -->
            <div class="container">
                <div class="profile-info__main-container flex-row">

                    <div class="profile-info__img-container">

                        <div class="profile-info__img is-rounded has-avatar">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>

                    </div>
                    <div class="profile-info__data-container pr-data-container">
                        <div class="pr-data-container__name">
                            <?php echo $page_content["company"]->short_name;?>
                        </div>



                        <div class="pr-data-container__title is-red-text">
                            <span class="">
                                Компания временно деактивирована
                            </span>
                        </div>


                    </div>

                </div>

            </div>


        </div>






    </section>




</div>
