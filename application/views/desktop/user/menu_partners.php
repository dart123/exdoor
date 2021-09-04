<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.16
 * Time: 12:58
 */
?>

<div class="sub-menu">
    <ul class="sub-menu__list">
        <li><a href="/partners" class="<?php if($selected == 'partners'):?>active <?php endif;?>is-fade">Мои партнеры</a></li>
        <li><a href="/partners/inbox" id="js-top-menu__partners__inbox" class="<?php if($selected == 'inbox'):?>active<?php endif;?> is-fade">Входящие заявки <?php if($inbox_count != 0):?>(<?php echo $inbox_count;?>)<?php endif;?></a></li>
        <li><a href="/partners/outbox" id="js-top-menu__partners__outbox" class="<?php if($selected == 'outbox'):?>active<?php endif;?> is-fade">Исходящие заявки <?php if($outbox_count != 0):?>(<?php echo $outbox_count;?>)<?php endif;?></a></li>
    </ul>
</div>