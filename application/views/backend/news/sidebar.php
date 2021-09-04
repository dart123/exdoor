<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.12.16
 * Time: 14:24
 */
?>

<h3>Статистика по новостям</h3>

<ul class="list-group">
    <li class="list-group-item">
        <span class="badge"><?php echo $count_all_news['active'];?> из <?php echo $count_all_news['all'];?></span>
        Всего новостей
    </li>
    <li class="list-group-item">
        <span class="badge"><?php echo $count_all_likes['active'];?> из <?php echo $count_all_likes['all'];?></span>
        Кол-во лайков к новостям
    </li>
    <li class="list-group-item">
        <span class="badge"><?php echo $count_all_comments['active'];?> из <?php echo $count_all_comments['all'];?></span>
        Всего комментариев
    </li>

    <li class="list-group-item">
        <span class="badge"><?php echo $count_project_news['active'];?> из <?php echo $count_project_news['all'];?></span>
        Всего новостей проекта Exdor
    </li>
    <li class="list-group-item">
        <span class="badge"><?php echo $count_project_likes['active'];?> из <?php echo $count_project_likes['all'];?></span>
        Кол-во лайков к новостям Exdor
    </li>
    <li class="list-group-item">
        <span class="badge"><?php echo $count_project_comments['active'];?> из <?php echo $count_project_comments['all'];?></span>
        Всего комментариев к новостям Exdor
    </li>

</ul>