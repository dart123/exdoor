<?php



?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/news">Новости</a></li>
    <li class="active">Настройки</li>
</ol>

<h1>
    Настройки новостей
</h1>

<div class="row">
    <div class="col-xs-12 col-sm-8">
        <h3>Мета-данные главной страницы новостей</h3>

        <?php if( $post_result ):?>
            <?php if( $post_result == 'success'):?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Отлично!</strong> Настройки успешно сохранены!
                </div>
            <?php endif;?>
        <?php endif;?>

        <hr>
        <form class="form-horizontal" method="POST">
            <div class="row">
                <div class="col-xs-12 col-sm-8">

                        <input type="hidden" name="action" value="news__meta_update">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="meta__news_title" value="<?php echo $title;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keywords</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="meta__news_keywords" value="<?php echo $keywords;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="meta__news_description"><?php echo $description;?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <input type="submit" class="btn btn-success" value="Сохранить">
                            </div>
                        </div>

                </div>
            </div>


            <h3>Мета-данные страницы новостей проекта</h3>

            <hr>

            <div class="row">
                <div class="col-xs-12 col-sm-8">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="meta__project_news_title" value="<?php echo $project_title;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Keywords</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="meta__project_news_keywords" value="<?php echo $project_keywords;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="meta__project_news_description"><?php echo $project_description;?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <input type="submit" class="btn btn-success" value="Сохранить">
                        </div>
                    </div>
                </div>
            </div>
        </form>








    </div>
    <div class="col-xs-12 col-sm-4">
        <?php $this->load->view('backend/news/sidebar__add_button');?>
        <?php $this->load->view('backend/news/sidebar');?>
    </div>
</div>
