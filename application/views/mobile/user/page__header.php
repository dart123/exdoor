<?php
/**
 * Created by developer with PhpStorm.
 * Date: 25.08.2018 12:34
 *
 *
 */

?>


<header class="header__widget header-widget t-hide">
    <div class="header-widget__user" >
        <a href="#header__calc"  class="widget__calc  header-widget__calc">
            <i class="fa fa-calculator"></i>
        </a>
        <a href="#header__converter" class="widget__convert     header-widget__convert">
            <div class="header-widget__convert-icon">
                <div><i class="fa fa-eur"></i><i class="fa fa-gbp"></i></div>
                <div><i class="fa fa-usd"></i><i class="fa fa-rub"></i></div>
            </div>
        </a>
        <div class="header-widget__exchange-value">
            <span class="">$ — <span class="exchange-value__dollar"><?php echo $page_header['usd'];?></span></span>
            <span class="">€ — <span class="exchange-value__euro"><?php echo $page_header['eur'];?></span></span>
        </div>
    </div>
</header>

