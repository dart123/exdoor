<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.09.17
 * Time: 15:20
 */
?>



<section class="information">
    <div class="information__content is-box-shadow">
        <!-- Кнопка Назад -->
        <a href="<?=$this->config->item('base_url');?>/<?=$this->lang->line('url_home_page');?>" class='information__go-back is-blue-link'>
            <i class='fa fa-caret-left'></i>
            <span><?php echo $this->lang->line('go_home');?></span>
        </a>
        <div>
            <h2><?php echo $this->lang->line('error_404__title');?></h2>
            <?php echo $this->lang->line('error_404__content');?>
            <div class="clear"></div>
        </div>
    </div>
</section>
