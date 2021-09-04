<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.07.17
 * Time: 13:12
 */

?>


<script type="text/html" id="change_login__new_phone">

    <div class="modal__content send-code__block ajax__change_login__container">
        <div class="change_login__description">
            <h2>Отлично! Введите новый номер</h2>
            <p>На него будет отправлено смс сообщение с Вашим новым паролем для доступа к сети exdor.</p>
        </div>
        <form class="ajax__change_login__new_phone" >
            <label for="" class="send-code__line-label">

                <div class="change_login__country_code">
                    <select class="user-city" id="input__change_login__new_phone__code" name="phone-code">
                        <option value="+994">+994 (Азербайджан)</option>
                        <option value="+374">+374 (Армения)</option>
                        <option value="+375">+375 (Белоруссия)</option>
                        <option value="+7">+7 (Казахстан)</option>
                        <option value="+996">+996 (Киргизия)</option>
                        <option value="+373">+373 (Молдавия)</option>
                        <option selected="" value="+7">+7 (Россия)</option>
                        <option value="+992">+992 (Таджикистан)</option>
                        <option value="+993">+993 (Туркмения)</option>
                        <option value="+998">+998 (Узбекистан)</option>
                        <option value="+380">+380 (Украина)</option>
                    </select>
                    <select id="tmp-select">
                        <option id="tmp-option"></option>
                    </select>

                    <input type="text" class="send-code__input" id="input__change_login__new_phone" name="input__change_login__new_phone" placeholder="Новый номер телефона" >
                </div>

            </label>
            <div class="change_login__button">
                <input type="submit" class="send-code__submit or-btn btn btn-info is-rounded" value="Подтвердить">
            </div>
        </form>

    </div>

</script>

