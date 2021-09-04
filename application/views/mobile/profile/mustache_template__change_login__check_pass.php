<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.07.17
 * Time: 13:12
 */
?>

<script type="text/html" id="change_login__check_pass">

    <div class="modal-body  ajax__change_login__container">
        <div class="change_login__description">
            <p class="bold">Почти готово! Введите пароль из смс</p>
            <p class="is-mtop-5">Мы отправили Ваш новый пароль для авторизации в виде смс на новый номер телефона. Пожалуйста подтвердите его и используйте для доступа к сети exdor.</p>
        </div>
        <form class="ajax__change_login__check_pass  is-mtop-10" >
            <label for="" class="send-code__line-label">
                <input type="text" class="send-code__input" id="input__change_login__check_pass" name="input__change_login__check_pass" placeholder="Новый пароль" >
            </label>
            <div class="text-center is-mtop-10">
                <input type="submit" class="change_login__button       send-code__submit or-btn btn btn-info is-rounded" value="Готово">
            </div>
        </form>
    </div>

</script>
