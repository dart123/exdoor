<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 14:41
 */
?>
<div class="modal__head is-rounded">
    <div class="modal__title">Новое объявление</div>
    <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
</div>
<form action="" method="POST">
    <input type="hidden" id="ajax-input-author_id" value="<?php echo $this->session->user;?>">
    <input type="hidden" id="ajax-input-action" value="add">
    <input type="hidden" id="ajax-input-edit_id" value="">

    <div class="modal__body">
        <div class="advpost__form">
            <div class="advpost__radio--line clear"><b>Категория объявления</b>
                <div class="advpost__radio--cover">

                    <input type="radio" class="radio" name="offers__type" value="sell" id="advpost__sell" checked/>
                    <label for="advpost__sell" class="radio__label">Продать</label>

                    <input type="radio" class="radio" name="offers__type" value="buy" id="advpost__buy"/>
                    <label for="advpost__buy" class="radio__label">Купить</label>

                    <input type="radio" class="radio" name="offers__type" value="service" id="advpost__services" />
                    <label for="advpost__services" class="radio__label">Услуги</label>
                </div>
            </div>



            <?php if( $all__offer_categories ):?>
                <label for="advpost__theme-name" class="advpost__line-label clear"><span>Рубрика<sup>*</sup></span>
                    <select id="advpost__theme-name" name="offers__category" class="select-box is-placeholder">
                        <option value="none">Выберите рубрику</option>
                        <?php foreach( $all__offer_categories as $offer_cat ):?>
                            <option value="<?php echo $offer_cat->id;?>">
                                <?php echo $offer_cat->value;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </label>
            <?php endif;?>
            <?php if($all__brands):?>
                <label for="advpos__brand" class="advpost__line-label clear"><span>Производители<sup>*</sup></span>
                    <select id="advpos__brand" name="offers__brand" class="select-box is-placeholder">
                        <option value="none">Выберите производителя</option>
                        <?php
                        $i = 0;
                        foreach( $all__brands as $brand ):
                            $i++;
                            ?>
                            <option value="<?php echo $brand->id;?>">
                                <?php echo $brand->value;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </label>
            <?php endif;?>

            <label for="advpost__ta-title" class="advpost__line-label clear"><span>Заголовок<sup>*</sup></span>
                <textarea id="advpost__ta-title" name="offers__title" class="advpost__ta-title limit-100" maxlength="100" placeholder="Не используйте слова «продам», «куплю»"></textarea>

                <span class="textarea-count-label is-or-text">100</span>
            </label>

            <label for="" class="advpost__line-label clear"><span>Ключевые слова<br>(через запятую)</span>
                <textarea id="advpost__ta-keywords" name="offers__keywords" class="advpost__ta-keywords" placeholder="Артикул, модель, важные характеристики"></textarea>
            </label>

            <label for="" class="advpost__line-label clear"><span>Стоимость</span>
                <input type="text" class="advpost__input" name="offers__price" id="" placeholder="Цена от в руб." pattern="[0-9]{2}">

                <span class="advpost__new-input">или
                    <a href="" class="is-or-link show-range">
                        <span>Указать ценовой диапазон</span>
                    </a>
                </span>

                <span class="range-block" style="display: none">
                    <i>&mdash;</i>
                    <input type="text" class="advpost__input range-input " name="offers__max_price" id="" placeholder="Цена до в руб." pattern="[0-9]{2}">
                </span>

            </label>

            <label for="" class="advpost__line-label clear"><span>Бартер</span>
                <div class="advpost__checkbox__barter">
                    <input name="offers__barter" type="checkbox" class="show__checkbox" id="input__barter" value="1">
                    <label class="show__label-c" for="input__barter">Обмен возможен</label>
                </div>
            </label>
            <label for="advpost__ta-bartertext" class="js__barter_avalible advpost__line-label clear" style="display: none"><span>Условия обмена</span>
                <textarea id="advpost__ta-bartertext" class="advpost__ta-title limit-100" name="offers__barter_text" maxlength="100" placeholder="На что? В каком состоянии? С доплатой или без?"></textarea>
                <span class="textarea-count-label is-or-text">100</span>
            </label>

            <label for="advpost__ta-posttext" class="advpost__line-label clear"><span>Текст объявления</span>
                <textarea id="advpost__ta-posttext" class="advpost__ta-posttext limit-400" name="offers__content" maxlength="400" placeholder="Описание Вашего предложения"></textarea>
                <span class="textarea-count-label is-or-text">400</span>
            </label>
        </div>

        <!-- загрузка фото -->
        <div class="add-advpost__file--wrap">
            <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_offers" class="" multiple="" style="display:none" onchange="handleFiles_offers(this.files);" >
            <a href="#" id="fileSelect_offers" class="is-blue-link add-requests__label" onClick="uploadImg_offers(event);">
                <i class="fa fa-paperclip i-left-20"></i>
                <span>Прикрепить фото</span>
            </a>
        </div>
        <ul id="filelist_offers" class="clear"></ul>
        <!-- -->
    </div>
    <div class="modal__footer">
        <button type="submit" class="add-equipment__submit is-last-item btn ripple-effect btn-primary2 ajax__offer_add pointer">
            <i class="fas fa-check"></i>
            Опубликовать
        </button>
    </div>
    <ul class="filelist__clone filelist__clone_offers"></ul>
</form>
