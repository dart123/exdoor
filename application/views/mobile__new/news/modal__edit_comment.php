<?php
/**
 * Created by developer with PhpStorm.
 * Date: 28.08.2018 18:27
 *
 *
 */

?>

<form action="" method="POST">

    <div class="modal__head">

        <div class="modal__head__section">

            <div class="modal__head__close">
                <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
            </div>

        </div>

        <div class="modal__head__section">

            <div class="modal__head__title">Изменить комментарий</div>

        </div>

        <div class="modal__head__section">

            <div class="modal__head__submit">

                <button type="button" id="ajax__submit__edit_news_comment" class="add-news__submit">
                    <span class="m-hide">Готово</span> <i class="fa fa-check"></i>
                </button>
            </div>

        </div>
    </div>




    <input type="hidden" name="news_comment_id" id="ajax__input__news_comment_id"   value="">
    <input type="hidden" name="author_id"       id="ajax__comment_input__author_id" value="<?php echo $page_content["user"]->id;?>">

    <div class="modal__body scrollbar-inner">
        <div class="textarea--pre">
            <textarea class="add-news__area is-rounded limit-1000" name="content" id="ajax__input_edit_news_comment_content"  placeholder="Текст Вашей новости" maxlength="1000"></textarea>
            <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
        </div>
        <div class="clear"></div>
    </div>

</form>

