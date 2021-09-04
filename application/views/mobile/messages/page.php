<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 13:24
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
        <div class="header__page-title t-hide">Сообщения</div>
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


<?php
/*
    <div class="sub-menu">
        <ul class="sub-menu__list">
            <li><a class="active is-fade" id="js__messages__top_menu__new-messages">Мои переписки <span><?php if($page_content['menu']['new_messages']):?>(<?php echo $page_content['menu']['new_messages'];?>)<?php endif;?></span></a></li>
            <li><a href="/messages/partners" class="is-fade">Мои собеседники</a></li>
        </ul>
        <a href="#write-new-msg" class="fancybox clear sub-menu__add-news or-btn btn btn-info ripple-effect">
            <i class="fa fa-plus"></i>
            Написать сообщение
        </a>
    </div>
*/
?>
    <!--  Блок Мои переписки  -->
    <div class="my-dialogs">
        <!-- Отображать фон , если диалогов нет -->
        <?php if( $page_content['dialogs'] ):?>
            <!-- Список диалогов -->
            <div class="my-dialogs__block is-rounded  is-box-shadow js__dialogs_page__dialogs_list">
                <?php
                foreach ($page_content['dialogs'] as $dialog):
                    $this->load->view('mobile/messages/loop__dialog', $dialog);
                endforeach;
                ?>
            </div>

            <div class="my-dialogs__last is-no-select">Больше вы ни с кем не переписывались...</div>
        <?php else:?>
            <div class="my-dialogs--empty">
                <span class="no-dialogs">
                    <i class="fa fa-envelope-o"></i>
                    <div class="is-no-select">Вы еще ни с кем не переписывались...</div>
                </span>
                <i class="fa fa-long-arrow-up"></i>
            </div>
        <?php endif;?>

    </div>




</div>



<?php

$this->load->view('mobile/messages/mustache_template__loop_dialog');

$this->load->view('mobile/misc/js/partners__open_chat');