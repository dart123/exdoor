<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.04.2018
 * Time: 18:24
 */
?>



<section class="menu-links">

    <a href="<?php echo base_url('id'.$this->session->user);?>" class="<?php if($selected == 'main'):?>active<?php endif;?> menu-links__item">
        <i class="fa fa-male"></i> Моя страница
    </a>

    <a href="<?php echo site_url( array('company') );?>" class="<?php if($selected == 'company'):?>active<?php endif;?> menu-links__item" id="js-left-sidebar-menu__employers">
        <i class="fa fa-home"></i> Моя компания
        <?php if( isset($new_employers) && $new_employers > 0 ):?>
            <span class="msg-counter">
                <span class="msg-counter__item"><?php echo $new_employers;?></span>
            </span>
        <?php endif;?>
    </a>

    <a href="<?php echo site_url( array('news') );?>" class="<?php if($selected == 'news'):?>active<?php endif;?> menu-links__item">
        <i class="fa fa-newspaper-o"></i> Новости
    </a>

    <a href="<?php echo site_url( array('messages') );?>" class="<?php if($selected == 'messages'):?>active<?php endif;?> menu-links__item" id="js-left-sidebar-menu__messages">
        <i class="fa fa-envelope-o"></i> Сообщения
        <?php if($new_messages):?>
            <span class="msg-counter">
                <span class="msg-counter__item"><?php echo $new_messages;?></span>
            </span>
        <?php endif;?>
    </a>

    <?php
        if( $this->Partner_model->get_inbox_partners_count($this->session->user) > 0)
            $partners_url = '/partners/inbox';
        else
            $partners_url = '/partners/';
    ?>
    <a href="<?php echo $partners_url;?>" class="<?php if($selected == 'partners'):?>active<?php endif;?> menu-links__item" id="js-left-sidebar-menu__partners">
        <i class="fa fa-users"></i> Партнеры
        <?php if($new_partners):?>
            <span class="msg-counter">
                <span class="msg-counter__item"><?php echo $new_partners;?></span>
            </span>
        <?php endif;?>
    </a>

    <?php

        $outbox_count   = $this->Request_model->count_outbox_active_requests($this->session->user);
        $inbox_count    = $this->Request_model->count_inbox_active_requests($this->session->user);

        $requests_url   = '/requests';


        if( $inbox_count > 0 && $outbox_count < $inbox_count ) {
            $requests_url = '/requests/inbox';
        }

        if( $outbox_count > 0 && $inbox_count < $outbox_count ) {
            $requests_url = '/requests';
        }

        if( isset($menu__inbox_page_link) || isset($menu__outbox_page_link) || isset($menu__archive_page_link) ) {
            if ( isset($menu__inbox_page_link) )
                $requests_url = '/requests/inbox';

            if ( isset($menu__outbox_page_link) )
                $requests_url = '/requests';

            if( isset($menu__archive_page_link) )
                $requests_url = '/requests/archive';

        } else {
            if( $outbox_count == $inbox_count) {
                if ( isset($menu__inbox_link) )
                    $requests_url = '/requests/inbox';

                if ( isset($menu__outbox_link) )
                    $requests_url = '/requests/';

                if ( isset($menu__archive_link) )
                    $requests_url = '/requests/archive';
            }
        }

    ?>

    <a href="<?php echo $requests_url;?>" class="<?php if($selected == 'requests'):?>active<?php endif;?> menu-links__item" id="js-left-sidebar-menu__requests">
        <i class="fa fa-list-alt"></i> <span>Заявки</span>
        <?php if($active_requests):?>
            <span class="msg-counter">
                <span class="msg-counter__item"><?php echo $active_requests;?></span>
            </span>
        <?php endif;?>
    </a>

    <a href="<?php echo site_url( array('offers') );?>" class="<?php if($selected == 'offers'):?>active<?php endif;?> menu-links__item">
        <i class="fa fa-bullhorn"></i> Объявления
    </a>

    <a href="<?php echo site_url( array('equipment') );?>" class="<?php if($selected == 'equipment'):?>active<?php endif;?> menu-links__item">
        <i class="fa fa-truck"></i> Парк техники
    </a>

    <a href="<?php echo site_url( array('profile') );?>" class="menu-links__item menu-links__item--gray"><i class="fa fa-cog"></i> Профиль</a>
    <a href="#" class="js__set_pc_version   menu-links__item menu-links__item--gray"><i class="fa fa-globe"></i> Полная версия</a>
    <a href="/?logout=true" class="menu-links__item menu-links__item--gray"><i class="fa fa-sign-out"></i> Выход</a>

    <div class="menu-links__copyright menu-links__item--gray t-hide">Exdor.ru &copy; 2019</div>
</section>