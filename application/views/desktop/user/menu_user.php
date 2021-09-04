<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 13:31
 */
?>


<ul class="main-menu__list no-print">
    <span class="current"><i class="fa fa-bars"></i><span>Меню</span></span>
    <li>
        <a href="<?php echo base_url('id'.$this->session->user);?>" class="<?php if($selected == 'main'):?>active<?php endif;?> is-first-item btn ripple-effect btn-primary">
            Моя страница
        </a>
    </li>

    <li>
        <a href="<?php echo site_url( array('company') );?>" class="<?php if($selected == 'company'):?>active<?php endif;?> btn ripple-effect" id="js-left-sidebar-menu__employers">
            Моя компания
            <?php if( isset($new_employers) && $new_employers > 0 ):?>
                <span class="msg-counter">
                    <span class="msg-counter__item"><?php echo $new_employers;?></span>
                </span>
            <?php endif;?>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url( array('news') );?>" class="<?php if($selected == 'news'):?>active<?php endif;?> btn ripple-effect">
            Новости
        </a>
    </li>
    <li>
        <a href="<?php echo site_url( array('messages') );?>" class="<?php if($selected == 'messages'):?>active<?php endif;?> btn ripple-effect" id="js-left-sidebar-menu__messages">
            <?php if($new_messages):?>
                <span class="msg-counter">
                    <span class="msg-counter__item"><?php echo $new_messages;?></span>
                </span>
            <?php endif;?>
            Сообщения
        </a>
    </li>
    <li>
        <?php
            if( $this->Partner_model->get_inbox_partners_count($this->session->user) > 0)
                $partners_url = '/partners/inbox';
            else
                $partners_url = '/partners/';
        ?>
        <a href="<?php echo $partners_url;?>" class="<?php if($selected == 'partners'):?>active<?php endif;?> btn ripple-effect" id="js-left-sidebar-menu__partners">
            <?php if($new_partners):?>
                <span class="msg-counter">
                    <span class="msg-counter__item"><?php echo $new_partners;?></span>
                </span>
            <?php endif;?>
            Партнеры
        </a>
    </li>
    <li>
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
        <a href="<?php echo $requests_url;?>" class="<?php if($selected == 'requests'):?>active<?php endif;?> btn ripple-effect" id="js-left-sidebar-menu__requests">
            <?php if($active_requests):?>
                <span class="msg-counter">
                    <span class="msg-counter__item"><?php echo $active_requests;?></span>
                </span>
            <?php endif;?>
            Заявки
        </a>
    </li>
    <li>
        <a href="<?php echo site_url( array('offers') );?>" class="<?php if($selected == 'offers'):?>active<?php endif;?> btn ripple-effect">
            Объявления
        </a>
    </li>
    <li>
        <a href="<?php echo site_url( array('equipment') );?>" class="<?php if($selected == 'equipment'):?>active<?php endif;?> btn ripple-effect">
            Парк техники
        </a>
    </li>
    <li>
        <a href="/profile" class="<?php if($selected == 'profile'):?>active<?php endif;?> is-last-item btn ripple-effect">
            Профиль
        </a>
    </li>
</ul>