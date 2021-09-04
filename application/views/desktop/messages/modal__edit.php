<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.12.16
 * Time: 16:50
 */
?>

<div class="modal__head is-rounded">
    <div class="modal__title">Изменить сообщение</div>
    <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
</div>
<form action="" method="POST">
    <input type="hidden" name="action"      id="ajax__input__action"        value="edit_message">
    <input type="hidden" name="chatroom_id" id="ajax__input__chatroom_id"   value="<?php echo $chatroom;?>">
    <input type="hidden" name="message_id"  id="ajax__input__message_id"    value="">
    <input type="hidden" name="author_id"   id="ajax__input__author_id"     value="<?php echo $user->id;?>">

    <div class="modal__body">
        <div class="textarea--pre">
            <textarea class="add-news__area is-rounded limit-1000" name="message" id="ajax__input_edit_message_content"  placeholder="Текст Вашей новости" maxlength="1000"></textarea>
            <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
        </div>
        <div class="clear">
            <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_msg_modal" multiple="" style="display:none" onchange="handleFiles_msg_modal(this.files);" class="active">
            <a href="#" id="fileSelect_msg_modal" class="is-blue-link add-requests__label" onclick="uploadImg_msg_modal(event);">
                <i class="fa fa-paperclip i-left-20"></i>
                <span>Прикрепить фото</span>
            </a>
            <ul id="filelist_msg_modal" class="сlear"></ul>
        </div>
        <ul class="filelist__clone_modal"></ul>
    </div>
    <div class="modal__footer">
        <span id="ajax__submit__edit_message" class="add-news__submit--wrap is-last-item btn ripple-effect btn-primary2">
            <i class="fas fa-check"></i>
            <input type="submit" class="add-news__submit" value="Сохранить">
        </span>
    </div>
</form>

