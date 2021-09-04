<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.05.16
 * Time: 15:57
 */
?>
<section class="information">
    <div class="information__content is-box-shadow">

        <?php if( $go_back_url): echo $go_back_url; endif;?>

        <div>
            <h2><?php echo $content['title'];?></h2>
            <?php echo $content['content'];?>
            <div class="clear"></div>
        </div>
        <!-- Кнопка Наверх -->
        <a href="#" class="information__back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>
    </div>
</section>

<script>
    $(document).ready( function () {
        console.log( up_link() );
        if( up_link() )
            $(".information__back-to-top").hide();
    })
</script>