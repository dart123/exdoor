<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.07.17
 * Time: 13:12
 */

?>


<script type="text/html" id="change_login__new_phone">

    <div class="modal-body  ajax__change_login__container">
        <div class="change_login__description">
            <p class="bold">Отлично! Введите новый номер</p>
            <p class="is-mtop-5">На него будет отправлено смс сообщение с Вашим новым паролем для доступа к сети exdor.</p>
        </div>
        <form class="ajax__change_login__new_phone is-mtop-10" >
            <label for="" class="send-code__line-label">

                <div class="change_login__country_code">
                    <select class="user-city" id="input__change_login__new_phone__code" name="phone-code">
                        <option value="+994">+994</option>
                        <option value="+374">+374</option>
                        <option value="+375">+375</option>
                        <option value="+996">+996</option>
                        <option value="+373">+373</option>
                        <option selected="" value="+7">+7</option>
                        <option value="+992">+992</option>
                        <option value="+993">+993</option>
                        <option value="+998">+998</option>
                        <option value="+380">+380</option>
                    </select>
                    <select id="tmp-select">
                        <option id="tmp-option"></option>
                    </select>

                    <input type="text" class="send-code__input" id="input__change_login__new_phone" name="input__change_login__new_phone" placeholder="Новый номер телефона" >
                </div>

            </label>
            <div class="text-center is-mtop-10">
                <input type="submit" class="change_login__button       send-code__submit or-btn btn btn-info is-rounded " value="Подтвердить">
            </div>
        </form>

    </div>

</script>

