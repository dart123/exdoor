<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 15:59
 */
?>





<span class="current"><i class="fa fa-bars"></i><span><?php echo $this->lang->line('menu');?></span></span>
<li>
    <a href="<?php echo $this->lang->line('url_lang_prefix');?>/page/about" class="is-first-item btn ripple-effect btn-primary">
        <?php echo $this->lang->line('about');?>
    </a>
</li>
<li>
    <a href="<?php echo $this->lang->line('url_lang_prefix');?>/news" class="<?php if($selected == 'news'):?>active<?php endif;?> btn ripple-effect">
        <?php echo $this->lang->line('news');?>
    </a>
</li>
<li>
    <a href="<?php echo $this->lang->line('url_lang_prefix');?>/offers" class="<?php if($selected == 'offers'):?>active<?php endif;?>  is-last-item  btn ripple-effect">
        <?php echo $this->lang->line('offers');?>
    </a>
</li>

