<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 15:13
 */
?>
<div class="modal__head is-rounded">
    <div class="modal__title">Добавить новость</div>
</div>
<form action="" method="POST">
    <input type="hidden" name="action"          id="ajax__input__action"        value="add_news">
    <input type="hidden" name="news_id"         id="ajax__input__news_id"       value="">

    <?php if( isset($news_from_company) && $news_from_company && isset($company) && is_object($company) ):?>
        <input type="hidden" name="author_id"       id="ajax__input__author_id"     value="<?= $company->id;?>">
        <input type="hidden" name="company_news"    id="ajax__input__company_new"   value="1">
    <?php else:?>
        <input type="hidden" name="author_id"       id="ajax__input__author_id"     value="<?= $user->id;?>">
        <input type="hidden" name="company_news"    id="ajax__input__company_new"   value="0">
    <?php endif;?>

    <div class="modal__body">
        <div class="textarea--pre">
            <textarea
                    class="add-news__area is-rounded limit-1000"
                    name="content" id="ajax__input__news_content"
                    placeholder="Текст Вашей новости" maxlength="1000"></textarea>
            <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
        </div>
        <div class="clear">
            <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp"
                   id="fileElem_news"
                   multiple=""
                   style="display:none"
                   onchange="handleFiles_news(this.files);" class="active">
            <a href="javascript:void(0);"
               id="fileSelect_news"
               class="is-blue-link add-requests__label" onclick="uploadImg_news(event);">
                <i class="fa fa-paperclip i-left-20"></i>
                <span>Прикрепить фото</span>
            </a>
            <ul id="filelist_news" class="сlear"></ul>
        </div>

    </div>
    <div class="modal__footer">
        <button type="button"
                id="ajax__submit__add_edit_news"
                class="add-news__submit is-last-item btn ripple-effect btn-primary2 pointer">
            <i class="fas fa-check"></i> Опубликовать
        </button>
    </div>
    <ul class="filelist__clone filelist__clone_news"></ul>
</form>
