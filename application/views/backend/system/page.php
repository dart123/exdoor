<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.03.17
 * Time: 18:50
 */
?>

<h1>Системные настройки</h1>



<div class="row">
    <div class="col-xs-12 col-sm-6">
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="system_email" placeholder="email для уведомлений" value="<?php echo $system_email;?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
