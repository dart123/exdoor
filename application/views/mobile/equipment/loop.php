<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 12:17
 */

?>



<li class="eq__item is-box-shadow is-rounded item-equipment-<?php echo $id;?>">

    <a class="ajax__undo_remove_equipment after_removing_background is-rounded is-or-link" data-equipment-id="<?php echo $id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fa fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>


    <!-- Текст карточки -->
    <div class="eq-desrc__text">
        <p>
            <?php if( $model != ""):?>
                <b><?php echo $model;?></b>,
            <?php endif;?>
            <?php echo $brand_name;?>
        </p>
        <p><?php echo $appointment_name;?></p>
        <?php if( $serial_number || $year):?>
            <p>
                <?php if( $serial_number):?>
                    SN — <b><?php echo $serial_number;?></b> |
                <?php endif;?>

                <?php if($year != 0):?>
                    <?php echo $year;?> г.в.
                <?php endif;?>
            </p>
        <?php endif;?>
 
        <?php if ($engine && $engine != ""):?>
            <p>Двигатель — <?php echo $engine;?></p>
        <?php endif;?>

        <?php if ($section && $section != ""):?>
            <p class="is-grey-text"><i class="fa fa-thumb-tack"></i><?php echo $section;?></p>
        <?php endif;?>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">
                <li class="is-first-item ajax__edit_equipment" data-equipment-id="<?php echo $id;?>">
                    Редактировать
                </li>
                <li class="is-last-item ajax__remove_equipment" data-equipment-id="<?php echo $id;?>">
                    Удалить
                </li>
            </ul>
        </div>
    </div>


    <!-- Картинка карточки -->
    <?php if( $thumbnail && $thumbnail_out ):?>
        <div class="eq-desrc__image">
            <img src="/uploads/equipment/<?php echo $id;?>/medium_<?php echo $thumbnail_out;?>" class="img-responsive" data-thumbnail="<?php echo $thumbnail;?>" data-thumbnail-url="/uploads/equipment/<?php echo $id;?>/medium_<?php echo $thumbnail;?>">
        </div>
    <?php endif;?>



    <div class="eq-desrc__create">
        <a href="/requests/add/?action=create_request_from_park&equipment_id=<?php echo $id;?>" class="create__request is-blue-link">
            <i class="fa fa-plus"></i><i class="fa fa-list-alt"></i>
            <span>Создать заявку</span>
        </a>
    </div>
</li>

