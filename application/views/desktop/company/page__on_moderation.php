<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.07.17
 * Time: 10:16
 */
?>


<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>


<main>
    <div class="container">
        <div class="main-features">
            <?php
                $this->load->view('desktop/user/menu_user', $menu);
            ?>
        </div>

        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <section class="page-content">

            <div class="requests__last is-no-select">
                <p>
                    Компания находится на модерации.
                </p>
            </div>

        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>


    </div>
</main>