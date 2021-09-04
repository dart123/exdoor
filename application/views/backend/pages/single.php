<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.05.16
 * Time: 16:24
 */

?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/page">Страницы</a></li>
    <li class="active"><?php echo $page->title_ru;?> <?php if( $page->title_en ):?>(<?php echo $page->title_en;?>)<?php endif;?></li>
</ol>


<h1>Изменить страницу</h1>


<form method="post">
    <input type="hidden" name="action" value="page_update">
    <input type="hidden" name="pageID" value="<?php echo $page->id;?>">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <label for="basic-url">URL страницы</label>
            <br>
            <div class="input-group">
                <span class="input-group-addon"><?=$this->config->item('base_url');?>/page/</span>
                <input type="text" class="form-control js-url-input" name="slug" value="<?php echo $page->slug;?>">
            </div>
            <br>
            <a href="<?=$this->config->item('base_url');?>/page/<?=$page->slug;?>" class="btn btn-sm btn-info" target="_blank">Показать на сайте</a>
            <a href="<?=$this->config->item('base_url');?>/en/page/<?=$page->slug;?>" class="btn btn-sm btn-info" target="_blank">Show on website</a>


        </div>
        <div class="col-xs-12 col-md-6">
            <label for="basic-url">Дата публикации</label>
            <br>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" name="date_add" id="date_add_input" value="<?php echo $page->date_add;?>">
            </div>
            <br>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="public" value="1" <?php if($page->public == '1') echo 'checked';?>> Показывать страницу на сайте
                </label>
            </div>


        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">

            <div class="input-group">
                <span class="input-group-addon">Meta Title</span>
                <input type="text" class="form-control" name="meta_title_ru" value="<?php echo $page->meta_title_ru;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Keywords</span>
                <input type="text" class="form-control" name="meta_keywords_ru" value="<?php echo $page->meta_keywords_ru;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Description</span>
                <input type="text" class="form-control" name="meta_description_ru" value="<?php echo $page->meta_description_ru;?>">
            </div>
            <br>

            <label>
                Заголовок
            </label>
            <input class="form-control" name="title_ru" value="<?php echo $page->title_ru;?>">
            <br>
            <label>
                Содержание
            </label>
            <textarea class="form-control js-tinymce" name="content_ru" style="height: 350px"><?php echo $page->content_ru;?></textarea>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">

            <div class="input-group">
                <span class="input-group-addon">Meta Title</span>
                <input type="text" class="form-control" name="meta_title_en" value="<?php echo $page->meta_title_en;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Keywords</span>
                <input type="text" class="form-control" name="meta_keywords_en" value="<?php echo $page->meta_keywords_en;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Description</span>
                <input type="text" class="form-control" name="meta_description_en" value="<?php echo $page->meta_description_en;?>">
            </div>
            <br>

            <label>
                Title
            </label>
            <input class="form-control" name="title_en" value="<?php echo $page->title_en;?>">
            <br>
            <label>
                Content
            </label>
            <textarea class="form-control js-tinymce" name="content_en" style="height: 350px"><?php echo $page->content_en;?></textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-6">
            <a href="<?=$this->config->item('base_url');?>/page/<?=$page->slug;?>" class="btn btn-info" target="_blank">Показать на сайте</a>
            <a href="<?=$this->config->item('base_url');?>/en/page/<?=$page->slug;?>" class="btn btn-info" target="_blank">Show on website</a>
        </div>
        <div class="col-xs-6 text-right">
            <button type="submit" class="btn btn-success">Обновить</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePageModal">
                Удалить
            </button>
        </div>
    </div>
</form>

<!-- Модальное окно для удаления страницы -->
<div class="modal fade" id="deletePageModal" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
    <div class="modal-dialog" role="document">
        <form method="post" action="/backend/page/">
            <input type="hidden" name="action" value="page_delete">
            <input type="hidden" name="pageID" value="<?php echo $page->id;?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Подтверждение удаления страницы</h4>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить страницу "<?php echo $page->title_ru;?>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-danger">Да, я хочу удалить страницу</button>
                </div>
            </div>
        </form>
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