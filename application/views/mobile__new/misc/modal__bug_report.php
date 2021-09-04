<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.07.17
 * Time: 23:58
 */
?>


<!--  Сообщить об ошибке  -->
<div id="report" class="modal modal__block">
    <form action="" id="user__bug_reporter" class="modal-form">

        <div class="modal__head">
            <div class="modal__head__section">

                <div class="modal__head__close">
                    <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
                </div>

            </div>

            <div class="modal__head__section">

                <div class="modal__head__title">Сообщить об ошибке</div>

            </div>

            <div class="modal__head__section">

                <div class="modal__head__submit">

                    <button id="ajax__submit__edit_message" class="bug_reporter__send" type="submit">
                        <span class="m-hide">Сохранить</span> <i class="fa fa-check"></i>
                    </button>
                </div>

            </div>
        </div>


        <div class="modal__body">
            <div class="textarea--pre block_50_vh">
                <textarea id="bug_reporter__description" class="add-news__area is-rounded limit-1000" placeholder="Опишите проблему" maxlength="1000"></textarea>
                <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
            </div>
        </div>

    </form>

</div>
<!-- end Сообщить об ошибке -->
