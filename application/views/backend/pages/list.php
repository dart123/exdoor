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
    <li class="active">Страницы</li>
</ol>

<h1>Страницы</h1>

<a href="/backend/add_page" class="btn btn-success btn-circle">
    <span class="glyphicon glyphicon-plus"></span> Добавить страницу
</a>
<br>
<br>
<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Страница</th>
        <th>Дата публикации</th>
        <th class="text-right">Управление</th>
    </tr>
    <?php foreach( $pages as $page ):?>
    <tr>
        <td><?php echo $page->id;?></td>
        <td>
            <?php echo $page->title_ru;?><br>
            <small><?php echo $page->title_en;?></small>
        </td>
        <td>
            <?php
                $page->date_add = new DateTime( $page->date_add );
                echo $page->date_add->format('d.m.Y');
            ?>
        </td>
        <td>
            <div class="text-right">
                <a href="/page/<?php echo $page->slug;?>" target="_blank" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                </a>

                <?php if($page->public == '1'):?>
                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActivePageModal_<?php echo $page->id;?>">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    </button>
                <?php else:?>
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActivePageModal_<?php echo $page->id;?>">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </button>
                <?php endif;?>
                <a href="/backend/page/<?php echo $page->id;?>" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletePageModal_<?php echo $page->id;?>">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>

            <!-- Модальное окно для удаления страницы -->
            <div class="modal fade" id="deletePageModal_<?php echo $page->id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
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

            <!-- Модальное окно для Активации/деактивации страницы -->
            <div class="modal fade" id="switchActivePageModal_<?php echo $page->id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
                <div class="modal-dialog" role="document">
                    <form method="post" action="/backend/page/">
                        <input type="hidden" name="action" value="page_switch_active">
                        <input type="hidden" name="pageID" value="<?php echo $page->id;?>">
                        <?php if($page->public == '1'):?>
                            <input type="hidden" name="sub_action" value="deactivate">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Снять страницу с публикации</h4>
                                </div>
                                <div class="modal-body">
                                    Вы действительно хотите снять с публикации страницу "<?php echo $page->title_ru;?>"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-danger">Снять с публикации</button>
                                </div>
                            </div>
                        <?php elseif($page->public == '0'):?>
                            <input type="hidden" name="sub_action" value="activate">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Опубликовать страницу</h4>
                                </div>
                                <div class="modal-body">
                                    Вы действительно хотите опубликовать страницу "<?php echo $page->title_ru;?>"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-success">Опубликовать страницу</button>
                                </div>
                            </div>
                        <?php endif;?>

                    </form>
                </div>
            </div>

        </td>
    </tr>
    <?php endforeach;?>
</table>

<?php echo $pagination;?>