<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.06.2018
 * Time: 16:40
 */
?>

<div class="modal__head">
    <div class="modal__head__section">
        <div class="modal__head__close">
            <a href="" class="modal__close-btn"><i class="fa fa-times"></i>
                <span class="m-hide">Закрыть</span>
            </a>
        </div>
    </div>
    <div class="modal__head__section">
        <div class="modal__title">Сортировка</div>
    </div>

    <div class="modal__head__section">
        <div class="modal__head__submit">
            <button class="ajax__filter_offers__submit">
                <span class="m-hide">Готово</span> <i class="fa fa-check"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal__body scrollbar-inner">

    <div class="advpost__form-sidebar">
        <form action="">
            <input type="hidden" name="filter__type" value="<?php echo $offers_type;?>">
            <input type="hidden" name="" value="" class="ajax__adv_filter_input ajax__filter_hidden_field_trigger" >
            <input type="hidden" name="" value="<?php echo $last_loaded_offer;?>" id="ajax__last_loaded_ads">


            <div class="offers-add__inputs   form-input-group">


                <?php /* if( $offer_categories ):?>

                    <div class="advpost__radio--line clear     form-input-group__container">
                        <div class="form-input-group__label">
                            Рубрики
                        </div>
                        <div class="advpost__radio--cover     form-input-group__input-block">
                            <?php foreach( $offer_categories as $offer_cat ):?>
                                <div>
                                    <input type="checkbox" name="filter__category[]" value="<?php echo $offer_cat->id;?>" class="ajax__adv_filter_input advpost__checkbox" id="filter_category_<?php echo $offer_cat->id;?>" <?php if(in_array( $offer_cat->id, $filter['category'])):?>checked<?php endif;?>>
                                    <label class="advpost__label-c" for="filter_category_<?php echo $offer_cat->id;?>"><?php echo $offer_cat->value;?></label>
                                </div>

                            <?php endforeach;?>
                        </div>
                    </div>

                <?php endif; */?>

                <div class="advpost__radio--line clear    form-input-group__container">
                    <div class="form-input-group__label">
                        Сортировка
                    </div>
                    <div class="advpost__radio--cover     form-input-group__input-block">
                        <select id="advpost-filter" name="filter__sort_by" class="ajax__adv_filter_input  select select-box">
                            <option value="id">Сначала свежие</option>
                            <option value="views">Популярные</option>
                            <!-- <option value="category">По рубрикам</option> -->
                            <option value="low_price">По возрастанию цены</option>
                            <option value="high_price">По убыванию цены</option>
                        </select>
                    </div>
                </div>



                <?php if ($brands):?>

                    <div class="advpost__radio--line clear     form-input-group__container">
                        <div class="form-input-group__label">
                            По технике
                        </div>
                        <div class="advpost__radio--cover     form-input-group__input-block">
                            <?php foreach ($brands as $brand):?>
                                <div>
                                    <input type="checkbox" name="filter__brand[]" value="<?php echo $brand->id;?>" class="ajax__adv_filter_input advpost__checkbox" id="brand_<?php echo $brand->id;?>" <?php if(in_array( $brand->id, $filter['brand'])):?>checked<?php endif;?>>
                                    <label class="advpost__label-c" for="brand_<?php echo $brand->id;?>"><?php echo $brand->value;?></label>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>

                <?php endif;?>


                <?php if( isset($filter__barter_disable) && !$filter__barter_disable):?>

                <div class="advpost__radio--line clear     form-input-group__container">
                    <div class="form-input-group__label">
                        Дополнительно
                    </div>
                    <div class="advpost__radio--cover     form-input-group__input-block">
                        <input type="checkbox" name="filter__barter" value="yes" class="ajax__adv_filter_input advpost__checkbox" id="filter__barter" <?php if( array_key_exists( 'barter', $filter ) && $filter['barter'] == 'yes' ):?>checked<?php endif;?>>
                        <label class="advpost__label-c" for="filter__barter">Бартер</label>
                    </div>
                </div>


                <?php endif;?>


                <div class="advpost__radio--line clear     form-input-group__container">
                    <div class="form-input-group__label">
                        Сумма от
                    </div>
                    <div class="advpost__radio--cover     form-input-group__input-block">
                        <input type="number" inputmode="numeric" name="filter__price" class="ajax__adv_filter_input advpost__summ-sidebar  input__type-text" placeholder="в руб." pattern="[0-9]{2}" value="<?php if( $filter['price'] ): echo $filter['price']; endif;?>">
                    </div>
                </div>


                <div class="advpost__radio--line clear     form-input-group__container">
                    <div class="form-input-group__label">
                        Сумма до
                    </div>
                    <div class="advpost__radio--cover     form-input-group__input-block">
                        <input type="number" inputmode="numeric" name="filter__max_price" class="ajax__adv_filter_input advpost__summ-sidebar advpost__summ-sidebar--r input__type-text" placeholder="в руб." pattern="[0-9]{2}" value="<?php if( $filter['max_price'] ): echo $filter['max_price']; endif;?>">
                    </div>
                </div>

            </div>




        </form>
    </div>

</div>