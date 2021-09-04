<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.12.16
 * Time: 16:50
 */
?>
<div class="modal-form">

    <form action="" method="POST">
        <div class="modal__head">
            <div class="modal__head__section">

                <div class="modal__head__close">
                    <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
                </div>

            </div>

            <div class="modal__head__section">

                <div class="modal__head__title">Редактирование</div>

            </div>

            <div class="modal__head__section">

                <div class="modal__head__submit">

                    <button id="ajax__submit__edit_message" class="add-news__submit" type="submit">
                        <span class="m-hide">Сохранить</span> <i class="fa fa-check"></i>
                    </button>
                </div>

            </div>
        </div>


        <div class="modal__body">
            <input type="hidden" name="action"      id="ajax__input__action"        value="edit_message">
            <input type="hidden" name="chatroom_id" id="ajax__input__chatroom_id"   value="<?php echo $page_content["chatroom"];?>">
            <input type="hidden" name="message_id"  id="ajax__input__message_id"    value="">
            <input type="hidden" name="author_id"   id="ajax__input__author_id"     value="<?php echo $page_content["user"]->id;?>">


            <div class="textarea--pre modal__height_50">
                <textarea class="add-news__area is-rounded limit-1000" name="message" id="ajax__input_edit_message_content"  placeholder="Ваше сообщение" maxlength="1000"></textarea>
                <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
            </div>
            <!--
            <div class="clear">
                <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_msg_modal" multiple="" style="display:none" onchange="handleFiles_msg_modal(this.files);" class="active">
                <a href="#" id="fileSelect_msg_modal" class="is-blue-link add-requests__label" onclick="uploadImg_msg_modal(event);">
                    <i class="fa fa-paperclip i-left-20"></i>
                    <span>Прикрепить фото</span>
                </a>
                <ul id="filelist_msg_modal" class="сlear"></ul>
            </div>
            <ul class="filelist__clone_modal"></ul>
            -->
        </div>

    </form>

</div>
