<?php
/**
 * Created by developer with PhpStorm.
 * Date: 10.09.2018 10:44
 *
 *
 */

$classes     = '';
$classes    .= 'message-id-'.$id;

if( $unread )
    $classes    .= ' message__unread';


?>

<tr class="conversation__row <?php echo $classes ;?>">
    <td class="conversation__author">
        <a href="/partners/<?php echo $author_id;?>" class="is-rounded">
            <?php if( $avatar ):?>
                <img src="/uploads/users/<?php echo $author_id;?>/avatar/80x80_<?php echo $avatar;?>" style="height: 60px; width: 60px;" alt="">
            <?php else:?>
                <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
            <?php endif;?>
        </a>
    </td>
    <td class="conversation__body">

        <div class="conversation__date" style="position:relative;">
            <?php echo $date;?>
            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="ajax-remove-message is-last-item"data-message-id="<?php echo $id;?>" data-chatroom-id="<?php echo $page_content["chatroom"];?>">Удалить</li>
                    <?php if ( $editable ):?>
                        <li class="ajax-edit-message is-blue-text" data-message-id="<?php echo $id;?>" data-chatroom-id="<?php echo $page_content["chatroom"];?>">Редактировать</li>
                    <?php endif;?>
                </ul>
            </div>
        </div>

        <div class="conversation__author-name">
            <a href="/partners/<?php echo $author_id;?>" class="is-blue-link">
                <span><?php echo $name;?></span>
            </a>
        </div>



        <div class="conversation__rspace"></div>

        <div class="conversation__text" contenteditable="false" data-message-id="<?php echo $id;?>">
            <?php echo $message;?>
        </div>

        <?php if($images):?>
            <div class="conversation__images">
                <?php foreach ($images as $m_img):?>
                    <a href="/uploads/messages/<?php echo $page_content["chatroom"];?>/lg1000_<?php echo $m_img;?>" class="fancybox-thumb" rel="fancy-rel-<?php echo $id;?>">
                        <img src="/uploads/messages/<?php echo $page_content["chatroom"];?>/lg1000_<?php echo $m_img;?>" class="img-responsive">
                    </a>
                <?php endforeach;?>
            </div>
        <?php endif;?>
        <a class="ajax__restore_message after_removing_background is-or-link" data-message-id="<?php echo $id;?>" data-chatroom-id="<?php echo $page_content["chatroom"];?>">
            <div class="like_table">
                <div class="like_td">
                    <p><i class="fa fa-undo" aria-hidden="true"></i> <span>Восстановить</span></p>
                </div>
            </div>
        </a>
    </td>

</tr>
