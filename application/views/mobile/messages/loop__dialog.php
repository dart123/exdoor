<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.12.16
 * Time: 13:35
 */
?>

<a href="/messages/<?php echo $id;?>" class="my-dialogs__row is-fade <?php if($unread):?>my-dialogs__row__unread<?php endif;?> js__dialog_<?php echo $id;?>">
    <div href="" class="my-dialogs__image is-rounded">
        <?php if ($member->avatar):?>
            <img src="/uploads/users/<?php echo $member->id;?>/avatar/80x80_<?php echo $member->avatar;?>" class="img-responsive" alt="">
        <?php else:?>
            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
        <?php endif;?>
    </div>
    <div class="my-dialogs__content">
        <?php if ($last_message):?>

            <div class="my-dialogs__name">
                <?php echo $member->name;?> <?php echo $member->last_name;?>

                <?php if( $last_message->is_author == true && $last_message->unread == true ):?>
                    <small class="dialog__list__unread"><i>(Не прочитано)</i></small>
                <?php endif;?>

            </div>
            <div class="my-dialogs__text">
                <?php if( $last_message_id != 0 ):?>
                    <?php if( $last_message->author_id == $this->session->user):?>
                        Вы:
                    <?php endif;?>

                    <?php echo $last_message->message_preview;?>
                    
                <?php endif;?>
            </div>

        <?php else:?>
            <div class="my-dialogs__name">
                <?php echo $member->name;?> <?php echo $member->last_name;?>
            </div>
            <div class="my-dialogs__text">
                Последнее сообщение было удалено!
            </div>
        <?php endif;?>
        <div class="my-dialogs__text__typing is-hidden">
            <?php echo $typing_text;?>
        </div>
    </div>
    <div class="my-dialogs__date"><?php if($last_message) echo $last_message->date;?></div>
</a>
