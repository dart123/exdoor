<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.09.16
 * Time: 22:44
 */
?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/news">Новости</a></li>
    <li class="active">Добавить новость</li>
</ol>


<h1>Добавить новость</h1>

<div class="row">
    <div class="col-xs-12 col-sm-8">
        <form method="POST" >
            <input type="hidden" name="action" value="add_news">
            <input type="hidden" name="author_id" value="1">
            <div id="hidden__images_upload_area">

            </div>

            <div class="row">
                <div class="col-xs-6">
                    <select name="taxonomy" class="form-control">
                        <option value="user">Новости проекта</option>
                        <option value="technology">Технологии</option>
                        <option value="money">Финансы</option>
                        <option value="interview">Интервью</option>
                        <option value="review">Обзоры</option>
                        <option value="humor">Юмор</option>
                    </select>
                    <br>
                </div>
            </div>
            <textarea class="form-control js-tinymce" name="content" style="height: 150px"></textarea>

            <hr>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Сохранить
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php $this->load->view('backend/news/sidebar');?>
    </div>
</div>


<script>
    $(function () {
        $('#date_add_input').datetimepicker({
            locale: 'ru',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });
    $(".js-url-input").keyup(function() {
        this.value = this.value.replace(/[^a-z0-9-_]/i, "");
    });

</script>