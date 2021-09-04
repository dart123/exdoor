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
    <li><a href="/backend/news">Новости</a></li>
    <li class="active">Новость от <?php echo $news->date;?></li>
</ol>

<h1>
    Новость от <?php echo $news->date;?>
</h1>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <form method="POST">
            <input type="hidden" name="action" value="update_news">
            <input type="hidden" name="news_id" value="<?php echo $news->id;?>">
            <div class="row h4">
                <div class="col-xs-6">
                    <span class="label label-success"><?php echo $news->date;?></span>

                    <?php if($news->comments_count):?>
                        <span class="badge">
                            <i class="glyphicon glyphicon-comment"></i> <?php echo $news->comments_count;?>
                        </span>

                    <?php else:?>
                        <span class="badge">
                            <i class="glyphicon glyphicon-comment"></i> 0
                        </span>

                    <?php endif;?>

                    <?php if($news->likes):?>
                        <span class="badge">
                            <i class="glyphicon glyphicon-heart"></i> <?php echo $news->likes;?>
                        </span>

                    <?php else:?>
                        <span class="badge">
                            <i class="glyphicon glyphicon-heart-empty"></i> 0
                        </span>
                    <?php endif;?>

                </div>

                <div class="col-xs-6 text-right">

                    <?php if( $news->removed == '0' ):?>

                        <a href="/news/<?php echo $news->id;?>" target="_blank" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                        </a>

                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActiveNewsModal_<?php echo $news->id;?>">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </button>
                    <?php else:?>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActiveNewsModal_<?php echo $news->id;?>">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </button>
                    <?php endif;?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <select name="taxonomy" class="form-control">
                        <option value="user" <?php if($news->taxonomy == 'user'):?>selected<?php endif;?>>Новости проекта</option>
                        <option value="technology" <?php if($news->taxonomy == 'technology'):?>selected<?php endif;?>>Технологии</option>
                        <option value="money" <?php if($news->taxonomy == 'money'):?>selected<?php endif;?>>Финансы</option>
                        <option value="interview" <?php if($news->taxonomy == 'interview'):?>selected<?php endif;?>>Интервью</option>
                        <option value="review" <?php if($news->taxonomy == 'review'):?>selected<?php endif;?>>Обзоры</option>
                        <option value="humor" <?php if($news->taxonomy == 'humor'):?>selected<?php endif;?>>Юмор</option>
                    </select>
                </div>
            </div>
            <br>
            <textarea name="content" class="form-control js-tinymce"><?php echo $news->content_html;?></textarea>

            <hr>
            <div class="text-right">
                <input type="submit" class="btn btn-success" value="Сохранить">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteNewsModal">
                    Удалить
                </button>
            </div>
        </form>

        <?php if( $news->comments ):?>
            <h3>Комментарии ( <?php echo $news->comments_count;?> )</h3>

            <ul class="list-group">
                <?php foreach ($news->comments as $comment):?>
                    <li class="list-group-item">

                        <div class="media">
                            <div class="media-left">
                                <a href="/backend/users/<?php echo $comment->user_id;?>">
                                    <img class="media-object" style="width: 60px" src="/uploads/users/<?php echo $comment->user_id;?>/avatar/80x80_<?php echo $comment->avatar;?>" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading"><?php echo $comment->name.' '.$comment->last_name;?></h5>
                                <?php echo $comment->comment;?>
                                <p class="text-right">
                                    <small><?php echo $comment->date;?></small>
                                </p>
                            </div>
                        </div>

                    </li>
                <?php endforeach;?>
            </ul>
        <?php else:?>


        <?php endif;?>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php $this->load->view('backend/news/sidebar');?>
    </div>
</div>





<!-- Модальное окно для Активации/деактивации страницы -->
<div class="modal fade" id="switchActiveNewsModal_<?php echo $news->id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
    <div class="modal-dialog" role="document">
        <form method="post">
            <input type="hidden" name="action" value="news_switch_active">
            <input type="hidden" name="newsID" value="<?php echo $news->id;?>">
            <?php if($news->removed == '1'):?>
                <input type="hidden" name="sub_action" value="activate">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Опубликовать новость</h4>
                    </div>
                    <div class="modal-body">
                        Вы действительно хотите опубликовать эту новость?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success">Опубликовать</button>
                    </div>
                </div>
            <?php elseif($news->removed == '0'):?>
                <input type="hidden" name="sub_action" value="deactivate">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Скрыть новость</h4>
                    </div>
                    <div class="modal-body">
                        Вы действительно хотите скрыть эту новость?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">Скрыть</button>
                    </div>
                </div>
            <?php endif;?>

        </form>
    </div>
</div>



<!-- Модальное окно для удаления страницы -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModal">
    <div class="modal-dialog" role="document">
        <form method="post" action="/backend/news/">
            <input type="hidden" name="action" value="news_delete">
            <input type="hidden" name="newsID" value="<?php echo $news->id;?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Подтверждение удаления новости</h4>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить эту новость безвозвратно?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-danger">Да, удалить новость</button>
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