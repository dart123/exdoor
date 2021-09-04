<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 15:12
 */

?>
<div class="reply news__comment-<?php echo $comment->id;?>">
    <a class="ajax__undo_remove_news_comment after_removing_background is-or-link" data-comment-id="<?php echo $comment->id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>
    <!-- нижний слой для клика по всему блоку   -->
    <a class="lower-layer" data-name="<?php echo $comment->name;?>, " data-news-id="<?php echo $news_id;?>" data-author-id="<?php echo $comment->user_id;?>"></a>
    <?php if($comment->avatar):?>
        <a href="/partners/<?php echo $comment->user_id;?>" class="reply__image is-rounded">
            <img src="/uploads/users/<?php echo $comment->user_id;?>/avatar/80x80_<?php echo $comment->avatar;?>" class="img-responsive">
        </a>
    <?php else:?>
        <a href="/partners/<?php echo $comment->user_id;?>" class="reply__image is-rounded">
            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
        </a>
    <?php endif;?>
    <div class="reply__content">
        <a href="/partners/<?php echo $comment->user_id;?>" class="is-blue-link"><span><b><?php echo $comment->name;?> <?php echo $comment->last_name;?></b></span></a>
        <div class="reply__text"><?php echo $comment->comment;?></div>
    </div>
    <div class="reply__date">
        <?php if ( $comment->is_author ):?>
            <?php if( $comment->editable):?>
                <a title="Редактировать" class="ajax-edit-message pointer is-blue-text" data-message-id="<?php echo $comment->id;?>" onclick=""><i class="fas fa-pen"></i></a> |
            <?php endif;?>
        <?php endif;?>
        <?php if( $comment->removable ):?>
            <a title="Удалить" class="ajax-remove-message pointer is-red-text" data-message-id="<?php echo $comment->id;?>" onclick=""><i class="fas fa-trash-alt"></i></a> |
        <?php endif;?>
        <?php echo $comment->date;?>
    </div>
</div>
