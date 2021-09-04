<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.05.16
 * Time: 18:02
 */
?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/page">Страницы</a></li>
    <li class="active">Новая страница</li>
</ol>

<h1>Добавить новую страницу</h1>


<form method="post">
    <input type="hidden" name="action" value="page_add">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <label for="basic-url">URL страницы</label>
            <br>
            <div class="input-group">
                <span class="input-group-addon"><?=$this->config->item('base_url');?>/page/</span>
                <input type="text" class="form-control js-url-input" name="slug" value="">
            </div>
            <br>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="public" value="1"> Показывать страницу на сайте
                </label>
            </div>
            <br>
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="basic-url">Дата публикации</label>
            <br>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" name="date_add" id="date_add_input" value="" >
            </div>
            <br>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">

            <div class="input-group">
                <span class="input-group-addon">Meta Title</span>
                <input type="text" class="form-control" name="meta_title_ru" value="">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Keywords</span>
                <input type="text" class="form-control" name="meta_keywords_ru" value="">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Description</span>
                <input type="text" class="form-control" name="meta_description_ru" value="">
            </div>
            <br>

            <label>
                Заголовок
            </label>
            <input class="form-control" name="title_ru" value="">
            <br>
            <label>
                Содержание
            </label>
            <textarea class="form-control js-tinymce" name="content_ru" style="height: 350px"></textarea>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">

            <div class="input-group">
                <span class="input-group-addon">Meta Title</span>
                <input type="text" class="form-control" name="meta_title_en" value="">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Keywords</span>
                <input type="text" class="form-control" name="meta_keywords_en" value="">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Description</span>
                <input type="text" class="form-control" name="meta_description_en" value="">
            </div>
            <br>

            <label>
                Title
            </label>
            <input class="form-control" name="title_en" value="">
            <br>
            <label>
                Content
            </label>
            <textarea class="form-control js-tinymce" name="content_en" style="height: 350px"></textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-12 text-right">
            <button type="submit" class="btn btn-success">Добавить страницу</button>
        </div>
    </div>
</form>


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