<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.11.2017
 * Time: 21:42
 */
?>

<tr>
    <td><?php echo $id;?></td>
    <td>
        <span class="label label-success"><?php echo $date;?></span>

        <?php if($comments_count):?>
            <span class="badge">
                <i class="glyphicon glyphicon-comment"></i> <?php echo $comments_count;?>
            </span>

        <?php else:?>
            <span class="badge">
                <i class="glyphicon glyphicon-comment"></i> 0
            </span>

        <?php endif;?>
        <?php if($likes):?>
            <span class="badge">
                <i class="glyphicon glyphicon-heart"></i> <?php echo $likes;?>
            </span>

        <?php else:?>
            <span class="badge">
                <i class="glyphicon glyphicon-heart-empty"></i> 0
            </span>

        <?php endif;?>
        <br>
        <?php echo strip_tags( htmlspecialchars_decode( $content )  );?>
    </td>
    <td>
        <?php if( $author_id == 1 ):
            switch( $taxonomy ) {
                case "user":
                    echo "Новости проекта";
                    break;
                case "technology":
                    echo "Технологии";
                    break;
                case "money":
                    echo "Финансы";
                    break;
                case "interview":
                    echo "Интервью";
                    break;
                case "review":
                    echo "Обзор";
                    break;
                case "humor":
                    echo "Юмор";
                    break;
                default:
                    echo "Новости проекта";
                    break;
            }
        else:?>
            Новость пользователя
        <?php endif;?>
    </td>
    <td>
        <div class="text-right">

            <?php if( $removed == '0' ):?>

                <a href="/news/<?php echo $id;?>" target="_blank" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                </a>

                <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActiveNewsModal_<?php echo $id;?>">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                </button>
            <?php else:?>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActiveNewsModal_<?php echo $id;?>">
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                </button>
            <?php endif;?>

            <a href="/backend/news/<?php echo $id;?>" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>

            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteNewsModal_<?php echo $id;?>">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
        </div>


        <!-- Модальное окно для Активации/деактивации страницы -->
        <div class="modal fade" id="switchActiveNewsModal_<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
            <div class="modal-dialog" role="document">
                <form method="post">
                    <input type="hidden" name="action" value="news_switch_active">
                    <input type="hidden" name="newsID" value="<?php echo $id;?>">
                    <?php if($removed == '1'):?>
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
                    <?php elseif($removed == '0'):?>
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
        <div class="modal fade" id="deleteNewsModal_<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModal">
            <div class="modal-dialog" role="document">
                <form method="post" action="/backend/news/">
                    <input type="hidden" name="action" value="news_delete">
                    <input type="hidden" name="newsID" value="<?php echo $id;?>">
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
    </td>
</tr>
