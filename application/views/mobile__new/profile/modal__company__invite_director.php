<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.07.17
 * Time: 11:11
 */

?>

<!-- Отправить письмо директору -->
<div id="send-mail" class="modal modal__block">

    <form action="" method="POST" id="company__invite-manager-form" class="modal-form">


        <div class="modal__head">
            <div class="modal__head__section">

                <div class="modal__head__close">
                    <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
                </div>

            </div>

            <div class="modal__head__section">

                <div class="modal__head__title">Пригласить</div>

            </div>

            <div class="modal__head__section">

                <div class="modal__head__submit">

                    <button class="send-mail__submit       js__invite_director pointer send-mail__submit--wrap is-last-item btn ripple-effect">
                        <span class="m-hide">Сохранить</span> <i class="fa fa-check"></i>
                    </button>

                </div>

            </div>
        </div>


        <div class="modal__body">

                <div class="textarea--pre block_25_vh">
                    <textarea maxlength="400" id="company__invite-manager__message" class="limit-400" data-sms-msg="Ваши сотрудники приглашают Вас в сеть exdor.ru" placeholder="Введите текст сообщения">Здравствуйте, <?php echo $page_content["company"]['manager'];?>! Приглашаю Вас присоединиться к сети exdor.ru! С Вашей помощью мы сможем достойно представлять нашу компанию на этой активно-развивающейся площадке для профессионалов в сфере дорожно-строительного бизнеса.</textarea>
                    <span class="textarea-count textarea-count-label is-lblue-text">400</span>
                </div>

                <div style="padding: 20px 10px; 10px;">

                    <label for="" class="my-company-profile__line-label my-company-profile__chk"><span>Отправить </span>
                        <div class="my-pers-profile__input profile-form__checkbox_container  send-mail__radio--cover">
                            <div>
                                <input type="radio" name="send-inv" id="send-inv__email" class="radio" checked/>
                                <label for="send-inv__email" class="radio__label" id="">В виде письма на email</label>
                            </div>
                            <div>
                                <input type="radio" name="send-inv" id="send-inv__sms" class="radio"/>
                                <label for="send-inv__sms" class="radio__label">В виде SMS</label>
                            </div>
                        </div>
                    </label>


                    <div class="send-mail__radio--line clear">
                        <label for="" class="send-invite__label clear      my-pers-profile__line-label" id="mail-line"><span>Email</span>
                            <input type="email" class="input__type-text send-mail__input       my-pers-profile__input" id="company__invite-manager__email" placeholder="domain@email.com" />
                        </label>

                        <label for="" class="send-invite__label clear      my-pers-profile__line-label" id="sms-line" style="display: none;"><span>Телефон</span>
                            <input type="tel" class="input__type-text send-mail__input phone-mask      my-pers-profile__input" id="company__invite-manager__phone" placeholder="Укажите номер директора" />
                        </label>
                    </div>
                </div>


        </div>


    <!--
        <div class="modal__head modal__head--high is-rounded">
            <div class="modal__title modal__title--high">
                <img src="/assets__old/img/or-logo-sm.png" alt="">
                <span>Приглашение зарегистрироваться в сети Exdor<br>для руководителя компании <b><?php echo $page_content["company"]['short_name'];?></b></span>
                <i class="fa fa-user-plus modal__title--icon"></i>
            </div>
            <a href="" class="modal__close-btn"><i class="fa fa-times"></i></a>
        </div>


        <div class="modal__footer">
            <span class="js__invite_director pointer send-mail__submit--wrap is-last-item btn ripple-effect btn-primary2 ">
                <i class="fa fa-check"></i>
                <input type="button" class="send-mail__submit " value="Отправить">
            </span>
        </div>

        -->
    </form>
</div>
