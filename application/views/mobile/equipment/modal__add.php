<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.11.16
 * Time: 13:38
 */

?>

<div class="modal__head">
    <div class="modal__head__section">

        <?php if ($page_content["equipment"] != false):?>
            <div class="modal__head__close">
                <a href="" class="modal__close-btn"><i class="fa fa-times"></i>
                    <span class="m-hide">Отменить</span>
                </a>
            </div>
        <?php endif;?>

    </div>
    <div class="modal__head__section">

        <div class="modal__title">Новая техника</div>

    </div>

    <div class="modal__head__section">

        <div class="modal__head__submit">

            <button class="add-equipment__submit ajax__equipment_add">
                <span class="m-hide">Добавить</span> <i class="fa fa-check"></i>
            </button>

        </div>

    </div>


</div>
<div class="modal__body scrollbar-inner">

    <form action="" method="POST">
        <input type="hidden" name="action" value="add_new_item">
        <input type="hidden" id="eq__id" name="id" value="">
        <input type="hidden" name="owner" value="<?php echo $this->session->user;?>" >

        <div class="modal__block__color-white no-padding">

            <div class="form-input-group">

                <div class="form-input-group__container">
                    <div class="form-input-group__label"><span>Заполнено</span></div>
                    <div class="form-input-group__input-block" style="overflow: hidden;">
                        <div id="eq__progressbar">
                            <span class="eq__progressval"><i>0%</i></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="modal__block__color-grey">

            <div class="form-input-group">

                <?php if ( $page_content["brands"] ):?>
                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Производитель</span></div>
                        <div class="form-input-group__input-block">
                            <select id="eq__brand" name="brand" class="select input__size-full               eq__val select-box is-placeholder">
                                <option value="none">Выберите производителя</option>
                                <?php foreach ( $page_content["brands"] as $brand ):?>
                                    <?php if( $brand->id != 0 ): /* Не указан */?>
                                        <option value="<?php echo $brand->id;?>">
                                            <?php echo $brand->value;?>
                                        </option>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                <?php endif;?>



                <?php if ( $page_content["equipment_appointment"] ):?>
                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Назначение</span></div>
                        <div class="form-input-group__input-block">
                            <select id="eq__type" name="appointment" class="select input__size-full            eq__val select-box is-placeholder">
                                <option value="none">Выберите назначение</option>
                                <?php foreach ( $page_content["equipment_appointment"] as $eq_app ):?>
                                    <option value="<?php echo $eq_app->id;?>" selected>
                                        <?php echo $eq_app->value;?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                <?php endif;?>


                <div class="form-input-group__container">
                    <div class="form-input-group__label"><span>Модель</span></div>
                    <div class="form-input-group__input-block">
                        <input type="text" name="model" id="eq__model" class="input__type-text input__size-full      eq__val" placeholder="В соответствии с техпаспортом" required>
                    </div>
                </div>

                <div class="form-input-group__container">
                    <div class="form-input-group__label"><span>Серийный номер</span></div>
                    <div class="form-input-group__input-block">
                        <input type="text" name="serial_number" id="eq__sn" class="input__type-text input__size-full     eq__val" placeholder="SN">
                    </div>
                </div>

                <div class="form-input-group__container">
                    <div class="form-input-group__label"><span>Двигатель</span></div>
                    <div class="form-input-group__input-block">
                        <input type="text" name="engine" id="eq__motor" class="input__type-text input__size-full       eq__val" placeholder="Код">
                    </div>
                </div>

                <div class="form-input-group__container">
                    <div class="form-input-group__label"><span>Год выпуска</span></div>
                    <div class="form-input-group__input-block">
                        <input type="text" inputmode="numeric" pattern="\d*" maxlength="4" name="year" id="eq__year" class="input__type-text input__size-full        eq__val" placeholder="ГГГГ" min="1900" max="2020">
                    </div>
                </div>

                <div class="form-input-group__container">
                    <div class="form-input-group__label"><span>Подразделение</span></div>
                    <div class="form-input-group__input-block">
                        <input type="text" name="section" id="eq__unit" class="input__type-text input__size-full        eq__val" placeholder="Например, автобаза №15">
                    </div>
                </div>


            </div>

        </div>

        <div class="clear"></div>

        <div class="attachment">

            <a href="#" id="fileSelect_equipment" class="attachment__button    is-blue-link add-requests__label" onClick="uploadImg_equipment(event);">
                <i class="fa fa-paperclip i-left-20"></i>
                <span>Прикрепить фото</span>
            </a>

            <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_equipment" multiple="" style="display:none" onchange="handleFiles_equipment(this.files);" >

            <ul id="filelist_equipment" class="attachment__list   clear"></ul>

        </div>

        <ul class="filelist__clone"></ul>
    </form>
</div>

