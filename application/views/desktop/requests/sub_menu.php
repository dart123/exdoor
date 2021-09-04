<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 20.02.2017
 * Time: 18:26
 */

?>

<div class="sub-menu sub-menu--wide-n">
    <ul class="sub-menu__list">
        <li><a id="js-top-menu__requests__outbox"   href="/requests" class="<?php if($selected == 'outbox'):?>active <?php endif;?>is-fade">Исходящие <span><?php if($outbox_count != 0):?>(<?php echo $outbox_count;?>)<?php endif;?></span></a></li>
        <li><a id="js-top-menu__requests__inbox"    href="/requests/inbox" class="<?php if($selected == 'inbox'):?>active <?php endif;?>is-fade">Входящие <span><?php if($inbox_count != 0):?>(<?php echo $inbox_count;?>)<?php endif;?></span></a></li>
        <li><a id="js-top-menu__requests__archive"  href="/requests/archive" class="<?php if($selected == 'archive'):?>active <?php endif;?>is-fade">Архив</a></li>
    </ul>
</div>