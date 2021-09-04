<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.17
 * Time: 15:02
 */

?>


<!--  Блок заявки -->
<div class="requests-info__block is-rounded is-box-shadow is-mtop-20">
    <div class="requests-info__photo">
        <?php if ($request_data->eq_thumbnail != false):?>
            <a href="/uploads/equipment/<?php echo $request_data->eq_id;?>/<?php echo $request_data->eq_thumbnail;?>" class="fancybox-thumb-w" rel="fancybox-thumb-<?php echo $request_data->eq_id;?>">
                <img src="/uploads/equipment/<?php echo $request_data->eq_id;?>/small_<?php echo $request_data->eq_thumbnail;?>" class="img-responsive">
            </a>
        <?php endif;?>
    </div>
    <div class="requests-info__content">

        <?php if( $request_data->eq_brand_name ):?>
            <p>
                <span class="requests-ind is-grey-text">Производитель:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_brand_name;?>&nbsp;</span>
            </p>
        <?php endif;?>
        <?php if( $request_data->eq_appointment_name ):?>
            <p>
                <span class="requests-ind is-grey-text">Назначение:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_appointment_name;?>&nbsp;</span>
            </p>
        <?php endif;?>
        <?php if( $request_data->eq_model ):?>
            <p>
                <span class="requests-ind is-grey-text">Модель:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_model;?>&nbsp;</span>
            </p>
        <?php endif;?>
        <?php if( $request_data->eq_serial_number ):?>
            <p>
                <span class="requests-ind is-grey-text">Серийный номер:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_serial_number;?>&nbsp;</span>
            </p>
        <?php endif;?>
        <?php if( $request_data->eq_engine ):?>
            <p>
                <span class="requests-ind is-grey-text">Двигатель:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_engine;?>&nbsp;</span>
            </p>
        <?php endif;?>
        <?php if( $request_data->eq_year ):?>
            <p>
                <span class="requests-ind is-grey-text">Год выпуска:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_year;?>&nbsp;</span>
            </p>
        <?php endif;?>
        <?php if( $request_data->eq_section ):?>
            <p>
                <span class="requests-ind is-grey-text">Подразделение:</span>
                <span class="requests-descr is-long-row"><?php echo $request_data->eq_section;?>&nbsp;</span>
            </p>
        <?php endif;?>
    </div>
</div>
