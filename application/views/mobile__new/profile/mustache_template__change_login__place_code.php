<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.07.17
 * Time: 12:59
 */

?>

<script type="text/html" id="change_login__place_code">

    <div class="modal-body  ajax__change_login__container">
        <div class="change_login__description">
            <p class="bold">Подтвердите доступ к аккаунту</p>
            <p class="is-mtop-5">В целях безопасности мы отправили Вам четырехзначный код по смс на текущий номер телефона. Пожалуйста, введите его в поле ниже.</p>
        </div>
        <form class="ajax__change_login__check_code is-mtop-10" >
            <label for="" class="send-code__line-label">
                <input type="text" class="send-code__input" id="input__change_login__code" name="input__change_login__code" placeholder="Проверочный код" >
            </label>
            <div class="text-center is-mtop-10">
                <input type="submit" class="change_login__button        send-code__submit or-btn btn btn-info is-rounded " value="Далее">
            </div>
        </form>
    </div>

</script>
