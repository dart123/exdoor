<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.09.16
 * Time: 22:14
 */
?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li class="active">Новости</li>
</ol>



<div class="row">
    <div class="col-xs-8">
        <h1>
            Новости проекта <small><a href="/backend/news_settings"><i class="fa fa-cog"></i> </a></small>
        </h1>
    </div>
    <div class="col-xs-4">
        <br>
        <form method="post" action="/backend/news">
            <div class="input-group">
                <input type="text" name="keywords" class="form-control" placeholder="Поиск по новостям" value="<?php echo $this->session->backend__search_news;?>">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Поиск</button>
                </span>
                <span class="input-group-btn">
                     <button type="submit" name="clear" value="clear_keywords" class="btn btn-danger">Сбросить</button>
                </span>
            </div><!-- /input-group -->
        </form>

    </div>
</div>


<a href="/backend/add_news/" class="btn btn-success btn-circle">
    <span class="glyphicon glyphicon-plus"></span> Добавить новость
</a>
<br>
<br>
<div class="row">
    <div class="col-xs-6">
        <p>
            Данные по новостям пользователей<br>
            <span class="badge">
                <i class="glyphicon glyphicon-list"></i>
                <?php echo $count_all_news['active'];?>/<?php echo $count_all_news['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-comment"></i>
                <?php echo $count_all_comments['active'];?>/<?php echo $count_all_comments['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-heart"></i>
                <?php echo $count_all_likes['active'];?>/<?php echo $count_all_likes['all'];?>
            </span>

        </p>
    </div>
    <div class="col-xs-6">
        <p>
            Данные по новостям проекта<br>
            <span class="badge">
                <i class="glyphicon glyphicon-list"></i>
                <?php echo $count_project_news['active'];?>/<?php echo $count_project_news['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-comment"></i>
                <?php echo $count_project_comments['active'];?>/<?php echo $count_project_comments['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-heart"></i>
                <?php echo $count_project_likes['active'];?>/<?php echo $count_project_likes['all'];?>
            </span>



        </p>
    </div>
</div>






<br>
<?php if($news):?>
    <table class="table table-striped table-bordered">
        <?php $this->load->view('backend/news/list_header');

        foreach ($news as $news_item):
            $this->load->view('backend/news/list_item', $news_item);
        endforeach;?>

    </table>

    <?php echo $pagination;?>

<?php endif;?>