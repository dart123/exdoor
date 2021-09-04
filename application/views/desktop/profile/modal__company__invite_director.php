<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.07.17
 * Time: 11:11
 */

?>

<!-- Отправить письмо директору -->
<div id="send-mail" class="modal is-rounded">
    <div class="modal__head modal__head--high is-rounded">
        <div class="modal__title modal__title--high">
            <img src="/assets/img/or-logo-sm.png" alt="">
            <span>Приглашение зарегистрироваться в сети Exdor<br>для руководителя компании <b><?php echo $company['short_name'];?></b></span>
            <i class="fa fa-user-plus modal__title--icon"></i>
        </div>
        <a href="" class="modal__close-btn"><i class="fas fa-times"></i></a>
    </div>
    <form action="" method="POST" id="company__invite-manager-form">
        <div class="modal__body">
            <div class="send-mail__form">
                <div class="textarea--pre">
                    <textarea maxlength="400" id="company__invite-manager__message" class="limit-400" data-sms-msg="Ваши сотрудники приглашают Вас в сеть exdor.ru" placeholder="Введите текст сообщения">Здравствуйте, <?php echo $company['manager'];?>! Приглашаю Вас присоединиться к сети exdor.ru! С Вашей помощью мы сможем достойно представлять нашу компанию на этой активно-развивающейся площадке для профессионалов в сфере дорожно-строительного бизнеса.</textarea>
                    <span class="textarea-count textarea-count-label is-lblue-text">400</span>
                </div>

                <div class="send-mail__radio--line clear">Отправить
                    <div class="send-mail__radio--cover">
                        <input type="radio" name="send-inv" id="send-inv__email" class="radio" checked/>
                        <label for="send-inv__email" class="radio__label" id="">В виде письма на email</label>

                        <input type="radio" name="send-inv" id="send-inv__sms" class="radio"/>
                        <label for="send-inv__sms" class="radio__label">В виде SMS</label>
                    </div>

                    <label for="" class="send-invite__label clear" id="mail-line"><span>Введите адрес почты</span>
                        <input type="email" class="send-mail__input" id="company__invite-manager__email" placeholder="domain@email.com" />
                    </label>

                    <label for="" class="send-invite__label clear" id="sms-line" style="display: none;"><span>Номер телефона</span>
                        <input type="tel" class="send-mail__input phone-mask" id="company__invite-manager__phone" placeholder="Укажите номер директора" />
                    </label>
                </div>
            </div>
        </div>
        <div class="modal__footer">
            <span class="js__invite_director pointer send-mail__submit--wrap is-last-item btn ripple-effect btn-primary2 ">
                <i class="fas fa-check"></i>
                <input type="button" class="send-mail__submit " value="Отправить">
            </span>
        </div>
    </form>
</div>
