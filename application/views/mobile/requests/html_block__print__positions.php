<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-02-01
 * Time: 18:38
 */
?>

<div class="print">
    <div class="print__logo">
        <img src="/assets__old/img/header__company--logo_backend.png">
    </div>
    <p class="print__h1">Список позиций для заявки <?php echo $page_content["request_positions"][0]->request_id;?></p>

    <table>
        <tr>
            <th>№</th>
            <th>Деталь</th>
            <th>Номер в каталогах</th>
            <th>Количество</th>
            <th>Для пометок</th>
        </tr>
        <?php $r_i = 1;?>
        <?php foreach ($page_content["request_positions"] as $r_position):  ?>
            <tr>
                <td>
                    <?php echo $r_i;?>
                </td>
                <td>
                    <?php if( $r_position->detail ) echo $r_position->detail; ?>
                </td>
                <td>
                    <?php if( $r_position->catalog_num ) echo $r_position->catalog_num; ?>
                </td>
                <td>
                    <?php echo $r_position->amount;?> шт.
                </td>
                <td>

                </td>
            </tr>
            <?php $r_i++; ?>
        <?php endforeach; ?>
    </table>
</div>
