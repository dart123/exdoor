<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.07.17
 * Time: 23:58
 */
?>


<!--  Сообщить об ошибке  -->
<div id="report" class="modal modal__block is-rounded">
    <div class="modal__head is-rounded">
        <div class="modal__title">Сообщить об ошибке на сайте</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>
    <form action="" id="user__bug_reporter">
        <div class="modal__body">
            <div class="textarea--pre">
                <textarea id="bug_reporter__description" class="add-news__area is-rounded limit-1000" placeholder="Опишите проблему" maxlength="1000"></textarea>
                <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
            </div>

            <div class="clear"></div>
            <?php /*
            <!-- загрузка фото -->

            <div class="clear">
                <input type="file" accept="image/jpeg,image/png*" id="fileElem" multiple=""  style="display:none" onchange="handleFiles(this.files);">
                <a href="#" id="fileSelect" class="is-blue-link add-requests__label" onClick="uploadImg(event);">
                    <i class="fa fa-paperclip i-left-20"></i>
                    <span>Прикрепить фото</span>
                </a>
                <ul id="filelist" class="сlear"></ul>
            </div>
            <!-- -->
            */;?>
        </div>
        <div class="modal__footer">
            <span class="bug_reporter__send pointer add-news__submit--wrap is-last-item btn ripple-effect btn-primary2">
                <i class="fas fa-check"></i>
                <input type="button" class="add-news__submit " value="Отправить">
            </span>
        </div>
    </form>
</div>
<!-- end Сообщить об ошибке -->
