<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 15:47
 */
?>




<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>



<div class="content ">

    <div class="ajax__news_container">
        <?php
            foreach ($page_content['news'] as $news_item):
                $last_loaded_news   = $news_item->id;
                $this->load->view('mobile/news/guest__loop', $news_item);
            endforeach;
        ?>
    </div>
</div>



<input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">


<?php

    $this->load->view('mobile/news/guest__mustache_template__loop');
    $this->load->view('mobile/news/guest__mustache_template__loop_modal');

    $this->load->view('mobile/news/guest__js__scripts');