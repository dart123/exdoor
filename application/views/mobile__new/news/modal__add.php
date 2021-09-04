<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.05.2018
 * Time: 15:31
 */

?>
<form action="" method="POST" class="modal-form">
    <div class="modal__head">

        <div class="modal__head__section">

            <div class="modal__head__close">
                <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
            </div>

        </div>

        <div class="modal__head__section">

            <div class="modal__head__title">Добавить новость</div>

        </div>

        <div class="modal__head__section">

            <div class="modal__head__submit">

                <button id="ajax__submit__add_edit_news" class="add-news__submit">
                    <span class="m-hide">Добавить</span> <i class="fa fa-check"></i>
                </button>
            </div>

        </div>
    </div>

    <input type="hidden" name="action"          id="ajax__input__action"        value="add_news">
    <input type="hidden" name="news_id"         id="ajax__input__news_id"       value="">

    <?php if( isset( $page_content['news_from_company'] ) && $page_content['news_from_company'] && isset($page_content['company']) && is_object($page_content['company']) ):?>
        <input type="hidden" name="author_id"       id="ajax__input__author_id"     value="<?php echo $page_content['company']->id;?>">
        <input type="hidden" name="company_news"    id="ajax__input__company_new"   value="1">
    <?php else:?>
        <input type="hidden" name="author_id"       id="ajax__input__author_id"     value="<?php echo $page_content['user']->id;?>">
        <input type="hidden" name="company_news"    id="ajax__input__company_new"   value="0">
    <?php endif;?>

    <div class="modal__body">
        <div class="scrollbar-inner">

            <div class="textarea--pre">
                <textarea class="add-news__area is-rounded limit-1000" name="content" id="ajax__input__news_content"  placeholder="Текст Вашей новости" maxlength="1000"></textarea>
                <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
            </div>

            <div class="clear"></div>

            <div class="attachment">

                <a href="#" id="fileSelect_news" class="attachment__button        is-blue-link add-requests__label" onclick="uploadImg_news(event);">
                    <i class="fa fa-paperclip i-left-20"></i>
                    <span>Прикрепить фото</span>
                </a>

                <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_news" multiple="" style="display:none" onchange="handleFiles_news(this.files);" class="active">

                <ul id="filelist_news" class="attachment__list сlear"></ul>

            </div>
            <ul class="filelist__clone"></ul>

        </div>




    </div>

    <ul class="filelist__clone filelist__clone_news"></ul>
</form>
