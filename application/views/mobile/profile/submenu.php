<?php
/**
 * Created by developer with PhpStorm.
 * Date: 08.09.2018 18:59
 *
 *
 */
?>

<section class="profile-submenu flex-row">

    <a href="/profile/" class="profile-submenu__item <?php if($active == "main"):?>-active<?php endif;?>">Анкета</a>
    <a href="/profile/company" class="profile-submenu__item <?php if($active == "company"):?>-active<?php endif;?>">Компания</a>
    <a href="/profile/security" class="profile-submenu__item <?php if($active == "security"):?>-active<?php endif;?>">Доступ</a>
    <a href="/profile/plan" class="profile-submenu__item <?php if($active == "plan"):?>-active<?php endif;?>">Тариф</a>

</section>
