<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.12.16
 * Time: 13:35
 */

    $classes     = '';
    $classes    .= 'message-id-'.$id;

    if( $unread )
        $classes    .= ' message__unread';


?>

<tr class="conversation__row <?php echo $classes ;?>">
    <td class="conversation__action">

        <a title="Удалить" class="ajax-remove-message is-red-text" data-message-id="<?php echo $id;?>" data-chatroom-id="<?php echo $chatroom;?>" onclick=""><i class="fas fa-trash-alt"></i></a>

        <?php if ( $editable ):?>
            <a title="Редактировать" class="ajax-edit-message is-blue-text" data-message-id="<?php echo $id;?>" data-chatroom-id="<?php echo $chatroom;?>" onclick=""><i class="fas fa-pen"></i></a>
        <?php endif;?>

    </td>
    <td class="conversation__author">
        <a href="/partners/<?php echo $author_id;?>" class="is-rounded">
            <?php if( $avatar ):?>
                <img src="/uploads/users/<?php echo $author_id;?>/avatar/80x80_<?php echo $avatar;?>" style="height: 60px; width: 60px;" alt="">
            <?php else:?>
                <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
            <?php endif;?>
        </a>
    </td>
    <td class="conversation__body">
        <div class="conversation__author-name">
            <a href="/partners/<?php echo $author_id;?>" class="is-blue-link">
                <span><?php echo $name;?> <?php echo $last_name;?></span>
            </a>
        </div>
        <div class="conversation__text" contenteditable="false" data-message-id="<?php echo $id;?>">
            <?php echo $message;?>
        </div>
        <?php if($images):?>
            <div class="conversation__images">
                <?php foreach ($images as $m_img):?>
                    <a href="/uploads/messages/<?php echo $chatroom;?>/lg1000_<?php echo $m_img;?>" class="fancybox-thumb" data-fancybox="fancy-rel-<?php echo $id;?>">
                        <img src="/uploads/messages/<?php echo $chatroom;?>/lg1000_<?php echo $m_img;?>" class="img-responsive">
                    </a>
                <?php endforeach;?>
            </div>
        <?php endif;?>
        <a class="ajax__restore_message after_removing_background is-or-link" data-message-id="<?php echo $id;?>" data-chatroom-id="<?php echo $chatroom;?>">
            <div class="like_table">
                <div class="like_td">
                    <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                    <p><span>Восстановить</span></p>
                </div>
            </div>
        </a>
    </td>
    <td class="conversation__date"><?php echo $date;?></td>
    <td class="conversation__rspace"></td>
</tr>
