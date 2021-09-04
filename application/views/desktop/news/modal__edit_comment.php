<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.12.16
 * Time: 21:55
 */
?>


<div class="modal__head is-rounded">
    <div class="modal__title">Изменить комментарий</div>
</div>
<form action="" method="POST">
    <input type="hidden" name="news_comment_id" id="ajax__input__news_comment_id"   value="">
    <input type="hidden" name="author_id"       id="ajax__comment_input__author_id" value="<?= $user->id;?>">

    <div class="modal__body">
        <div class="textarea--pre">
            <textarea class="add-news__area is-rounded limit-1000"
                      name="content"
                      id="ajax__input_edit_news_comment_content"
                      placeholder="Текст Вашей новости" maxlength="1000"></textarea>
            <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
        </div>
        <div class="clear"></div>
    </div>
    <div class="modal__footer">
        <button type="button"
                id="ajax__submit__edit_news_comment"
                class="add-news__submit is-last-item btn ripple-effect btn-primary2">
            <i class="fas fa-check"></i> Сохранить
        </button>
    </div>
</form>
