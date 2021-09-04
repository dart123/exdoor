<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.07.2018
 * Time: 13:29
 */
?>

<section class="menu-links">
    <?php foreach ($footer_menu as $link):?>
        <a href="<?php echo $link["slug"];?>" class="menu-links__item">
            <?php echo $link["title"];?>
        </a>
    <?php endforeach;?>
</section>