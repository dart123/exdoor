<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.11.16
 * Time: 13:38
 */

?>

<div class="modal__head is-rounded">
    <div class="modal__title">Новая техника</div>
    <?php if ($equipment != false):?>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    <?php endif;?>
</div>
<form action="" method="POST">
    <input type="hidden" name="action" value="add_new_item">
    <input type="hidden" id="eq__id" name="id" value="">
    <input type="hidden" name="owner" value="<?php echo $this->session->user;?>" >
    <div class="modal__body">

        <div class="modal__filled">
            Заполнено
            <div id="eq__progressbar">
                <span class="eq__progressval"><i>0%</i></span>
            </div>
        </div>
        <div class="eq__form">

            <?php if ( $brands ):?>
                <label for="eq__brand" class="eq__line-label clear"><span>Производитель</span>
                    <select id="eq__brand" name="brand" class="eq__val select-box is-placeholder">
                        <option value="none" selected>Выберите производителя</option>
                        <?php foreach ( $brands as $brand ):?>
                            <option value="<?php echo $brand->id;?>">
                                <?php echo $brand->value;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </label>
            <?php endif;?>

            <?php if ( $equipment_appointment ):?>
                <label for="eq__type" class="eq__line-label clear"><span>Назначение</span>
                    <select id="eq__type" name="appointment" class="eq__val select-box is-placeholder">
                        <option value="none" selected>Выберите назначение</option>
                        <?php foreach ( $equipment_appointment as $eq_app ):?>
                            <option value="<?php echo $eq_app->id;?>" selected>
                                <?php echo $eq_app->value;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </label>
            <?php endif;?>

            <label for="eq__model" class="eq__line-label clear"><span>Модель</span>
                <input type="text" name="model" id="eq__model" class="eq__val" placeholder="В соответствии с техпаспортом" required>
            </label>

            <label for="eq__sn" class="eq__line-label clear"><span>Серийный номер</span>
                <input type="text" name="serial_number" id="eq__sn" class="eq__val" placeholder="SN">
            </label>

            <label for="eq__motor" class="eq__line-label clear"><span>Двигатель</span>
                <input type="text" name="engine" id="eq__motor" class="eq__val" placeholder="Код">
            </label>

            <label for="eq__year" class="eq__line-label clear"><span>Год выпуска</span>
                <input type="text" name="year" id="eq__year" class="eq__val" placeholder="ГГГГ" min="1900" max="2020">
            </label>

            <label for="eq__unit" class="eq__line-label clear"><span>Подразделение</span>
                <input type="text" name="section" id="eq__unit" class="eq__val" placeholder="Например, автобаза №15">
                <div class="tooltip">
                    <i class="fa fa-question"></i>
                    <div class="tooltip__msg is-rounded is-box-shadow is-fade">Подсказка с текстом, описывающая информацию, которая полезна будет для заполнения поля.</div>
                </div>
            </label>

            <div class="add-equipment__file--wrap">
                <!-- загрузка фото -->
                <div class="add-advpost__file--wrap">
                    <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_equipment" multiple="" style="display:none" onchange="handleFiles_equipment(this.files);" >
                    <a href="#" id="fileSelect_equipment" class="is-blue-link add-requests__label" onClick="uploadImg_equipment(event);">
                        <i class="fa fa-paperclip i-left-20"></i>
                        <span>Прикрепить фото</span>
                    </a>
                </div>
            </div>
            <ul id="filelist_equipment" class="clear"></ul>
            <!-- -->
        </div>
    </div>
    <div class="modal__footer">
        <button type="submit" class="add-equipment__submit ajax__equipment_add is-last-item btn ripple-effect btn-primary2">
            <i class="fas fa-check"></i>
            Добавить в парк
        </button>
    </div>
    <ul class="filelist__clone"></ul>
</form>

