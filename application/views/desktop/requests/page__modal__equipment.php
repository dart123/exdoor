<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.11.16
 * Time: 18:16
 */
?>

<!-- Выбрать технику -->
<div id="requests__choose-eq" class="new-msg__modal">

    <div class="modal__head modal__head--blue is-first-item">
        <div class="modal__title">Выберите технику</div>
        <a href="" class="modal__close-btn">Закрыть <i class="fas fa-times"></i></a>
    </div>

    <?php /*?>
    <div class="new-msg__top-line">
        <div class="new-msg__title">Выберите технику из парка</div>


        <div class="submit--rcover">
            <form action="">
                <input type="submit" class="new-msg__submit" value="" title="Начать поиск">
                <input type="search" class="new-msg__search is-rounded" placeholder="Поиск по технике в парке">
            </form>
        </div>

        <a href="" class="new-msg__close-btn"><i class="fas fa-times"></i></a>
    </div>
    */ ?>
    <div class="is-rounded is-box-shadow" style="background: #fff">
        <!-- строка с оборудованием -->
        <form method="POST" action="">

            <div class="requests__model__equipment_scroll-wrapper scrollbar-inner scroll-content scroll-scrolly_visible">


                <?php foreach ($equipment as $eq):?>

                    <div class="requests-info__block is-rounded is-mtop-10 js__equipment__new_request is-box-shadow" data-equipment_id="<?php echo $eq->id;?>">
                        <div class="requests-info__photo">
                            <?php if ($eq->thumbnail != false):?>
                                <img src="/uploads/equipment/<?php echo $eq->id;?>/158x158_<?php echo $eq->thumbnail;?>" class="img-responsive">
                            <?php endif;?>
                        </div>
                        <div class="requests-info__content">
                            <p>
                                <span class="requests-ind is-grey-text">Производитель:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->brand_name;?>&nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Назначение:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->appointment_name;?>&nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Модель:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->model;?>&nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Серийный номер:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->serial_number;?>&nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Двигатель:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->engine;?>&nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Год выпуска:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->year;?>&nbsp;</span>
                            </p>
                            <p>
                                <span class="requests-ind is-grey-text">Подразделение:</span>
                                <span class="requests-descr is-long-row"><?php echo $eq->section;?>&nbsp;</span>
                            </p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </form>
    </div>
</div>
