<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.12.16
 * Time: 16:38
 */
?>

<a class="js-partner__open_chat my-companion__row is-first-item is-fade my-dialogs__row--active" data-user-id="<?php echo $user_id;?>" data-partner-id="<?php echo $id;?>">
    <?php if ($avatar):?>
        <div class="my-companion__image clear is-rounded">
            <img src="/uploads/users/<?php echo $id;?>/avatar/80x80_<?php echo $avatar;?>" class="img-responsive" alt="">
        </div>
    <?php else :?>
        <div class="my-companion__image clear is-rounded">
            <img src="/assets/img/news-advpost-head__photo--empty.jpg" style="width: 100%; height: auto" alt="">
        </div>
    <?php endif;?>
    <div class="my-companion__content">
        <div class="my-companion__name"><?php echo $name;?> <?php echo $second_name;?> <?php echo $last_name;?></div>
    </div>
</a>