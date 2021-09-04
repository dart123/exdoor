<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.05.16
 * Time: 16:33
 */

?>

<div class="row" style="margin-top: 30px">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <form class="well" method="post" action="/backend/">
            <input type="hidden" name="action" value="login">


            <div class="form-group">
                <label for="InputEmail">Логин</label>
                <div class="input-group">
                    <span class="input-group-addon" id="input-group-addon-login"><i class="fa fa-user"></i></span>
                    <input type="text" name="user_name" class="form-control" id="input-user-name" placeholder="Имя пользователя" aria-describedby="input-group-addon-login">
                </div>
            </div>

            <div class="form-group">
                <label for="InputPassword">Пароль</label>
                <div class="input-group">
                    <span class="input-group-addon" id="input-group-addon-password"><i class="fa fa-key"></i></span>
                    <input type="password" name="password" class="form-control" id="input-user-password" placeholder="Password" aria-describedby="input-group-addon-password">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <a href="<?=$this->config->item('base_url');?>" class="btn btn-block btn-primary"><i class="fas fa-undo" aria-hidden="true"></i> На сайт</a>
                </div>
                <div class="col-xs-6">
                    <button type="submit" class="btn btn-block btn-success"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Войти</button>
                </div>
            </div>
        </form>
    </div>
</div>
