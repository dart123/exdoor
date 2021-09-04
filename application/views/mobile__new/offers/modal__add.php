<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 14:41
 */
?>
<div class="modal__head">

    <div class="modal__head__section">

        <div class="modal__head__close">
            <a href="" class="modal__close-btn"><i class="fa fa-times"></i>
                <span class="m-hide">Отменить</span>
            </a>
        </div>

    </div>

    <div class="modal__head__section">

        <div class="modal__head__title">Новое объявление</div>

    </div>

    <div class="modal__head__section">

        <div class="modal__head__submit">

            <button class="add-equipment__submit        ajax__offer_add">
                <span class="m-hide">Добавить</span>
                <i class="fa fa-check"></i>
            </button>
        </div>

    </div>





<!--

    <span class="add-equipment__submit--wrap is-last-item btn ripple-effect btn-primary2 ajax__offer_add pointer">
        <i class="fa fa-check"></i>
        <input type="submit" class="" value="Опубликовать">
    </span> -->
</div>
<form action="" method="POST" class="modal-form">
    <input type="hidden" id="ajax-input-author_id" value="<?php echo $this->session->user;?>">
    <input type="hidden" id="ajax-input-action" value="add">
    <input type="hidden" id="ajax-input-edit_id" value="">

    <div class="modal__body scrollbar-inner">
        <div class="advpost__form                      form-inputs offers-add">

            <div class="modal__block__color-white">

                <div class="form-input-group">

                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Категория</span></div>
                        <div class="form-input-group__input-block">

                            <input type="radio" class="radio" name="offers__type" value="sell" id="advpost__sell" checked/>
                            <label for="advpost__sell" class="radio__label">Продать</label>

                            <input type="radio" class="radio" name="offers__type" value="buy" id="advpost__buy"/>
                            <label for="advpost__buy" class="radio__label">Купить</label>

                            <input type="radio" class="radio" name="offers__type" value="service" id="advpost__services" />
                            <label for="advpost__services" class="radio__label">Услуги</label>
                        </div>
                    </div>

                    <?php if( $all__offer_categories ):?>
                        <div class="form-input-group__container">
                            <div class="form-input-group__label"><span>Рубрика<sup>*</sup></span></div>
                            <div class="form-input-group__input-block">
                                <select id="advpost__theme-name" name="offers__category" class="select input__size-full        select-box is-placeholder">
                                    <option value="none">Выберите рубрику</option>
                                    <?php foreach( $all__offer_categories as $offer_cat ):?>
                                        <option value="<?php echo $offer_cat->id;?>">
                                            <?php echo $offer_cat->value;?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if($all__brands):?>
                        <div class="form-input-group__container">
                            <div class="form-input-group__label"><span>Производители<sup>*</sup></span></div>
                            <div class="form-input-group__input-block">
                                <select id="advpos__brand" name="offers__brand" class="select input__size-full                 select-box is-placeholder">
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
                            </div>
                        </div>
                    <?php endif;?>

                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Заголовок<sup>*</sup></span></div>
                        <div class="form-input-group__input-block">
                            <input type="text" id="advpost__ta-title" name="offers__title" class="input__type-text input__size-full        advpost__ta-title limit-100" maxlength="100" placeholder="Не используйте слова «продам», «куплю»">
                            <span class="textarea-count-label is-or-text">100</span>
                        </div>
                    </div>



                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Ключевые слова</span></div>
                        <div class="form-input-group__input-block">
                            <input type="text" id="advpost__ta-keywords" name="offers__keywords" class="input__type-text input__size-full       advpost__ta-keywords" placeholder="Артикул, модель, важные характеристики">
                        </div>
                    </div>


                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Стоимость</span></div>

                        <div class="form-input-group__input-block">
                            <input type="number" inputmode="numeric" class="input__type-text input__size-60       advpost__input" name="offers__price" id="" placeholder="от в руб." pattern="[0-9]{2}">
                            <i>&mdash;</i>
                            <input type="number" inputmode="numeric" class="input__type-text input__size-60       advpost__input range-input " name="offers__max_price" id="" placeholder="до в руб." pattern="[0-9]{2}">
                        </div>
                    </div>


                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Бартер</span></div>
                        <div class="form-input-group__input-block">
                            <input name="offers__barter" type="checkbox" class="show__checkbox" id="input__barter" value="1">
                            <label class="show__label-c" for="input__barter">Обмен возможен</label>
                        </div>
                    </div>


                    <div class="form-input-group__container">
                        <div class="form-input-group__label"><span>Условия обмена</span></div>
                        <div class="form-input-group__input-block">
                            <input type="text" id="advpost__ta-bartertext" class="input__type-text input__size-full        advpost__ta-title limit-100" name="offers__barter_text" maxlength="100" placeholder="На что? В каком состоянии? С доплатой или без?">
                        </div>
                    </div>

                </div>

            </div>


            <div class="textarea--pre">
                <textarea id="advpost__ta-posttext" class="advpost__ta-posttext    offers-add__textarea limit-400" name="offers__content" maxlength="400" placeholder="Описание Вашего предложения"></textarea>
                <span class="textarea-count-label is-or-text">400</span>
            </div>



        </div>

        <div class="clear"></div>

        <div class="attachment">

            <a href="#" id="fileSelect_offers" class="attachment__button    is-blue-link add-requests__label" onClick="uploadImg_offers(event);">
                <i class="fa fa-paperclip i-left-20"></i>
                <span>Прикрепить фото</span>
            </a>

            <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_offers" class="" multiple="" style="display:none" onchange="handleFiles_offers(this.files);" >

            <ul id="filelist_offers" class="attachment__list   clear"></ul>

        </div>

        <ul class="filelist__clone filelist__clone_offers"></ul>


        <!-- -->
    </div>

</form>
