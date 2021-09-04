<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.07.2018
 * Time: 13:06
 */
?>

<div class="content">
    <div style="background: #f2f5f6; min-height: 100%">
        <div style="padding: 5px">

            <div class="is-rounded is-box-shadow" style="background: white">
                <div style="padding: 10px 10px 30px">
                    <h1><?php echo $content["title"] ;?></h1>
                    <?php echo $content["content"] ;?>
                </div>

            </div>

        </div>

    </div>

</div>


<!--  Триггер-ссылки нотификации -->
<a href="#" class="notify-trigger notify-trigger--success" data-notifyStyle="success" data-notifyDuration="3000" data-notifyTitle="Спасибо!" data-notifyText="Данные отправлены, действие выполнено" style="height: 0; width: 0; font-size: 0"></a>

<a href="#" class="notify-trigger notify-trigger--alert" data-notifyStyle="alert" data-notifyDuration="5000" data-notifyTitle="Ошибка!" data-notifyText="Данное действие не подтверждено и не выполнено" style="height: 0; width: 0; font-size: 0"></a>
