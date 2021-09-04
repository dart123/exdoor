<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.07.17
 * Time: 12:59
 */

?>

<script type="text/html" id="change_login__place_code">

    <div class="modal__content send-code__block ajax__change_login__container">
        <div class="change_login__description">
            <h2>Подтвердите доступ к аккаунту</h2>
            <p>В целях безопасности мы отправили Вам четырехзначный код по смс на текущий номер телефона. Пожалуйста, введите его в поле ниже.</p>
        </div>
        <form class="ajax__change_login__check_code" >
            <label for="" class="send-code__line-label">
                <input type="text" class="send-code__input" id="input__change_login__code" name="input__change_login__code" placeholder="Проверочный код" >
            </label>
            <input type="submit" class="send-code__submit or-btn btn btn-info is-rounded" value="Далее">
        </form>
    </div>

</script>
