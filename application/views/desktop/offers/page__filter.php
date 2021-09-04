<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 14:38
 */
?>

<div class="advpost__form-sidebar">
    <form action="">
        <input type="hidden" name="filter__type" value="<?php echo $offers_type;?>">
        <input type="hidden" name="" value="" class="ajax__adv_filter_input ajax__filter_hidden_field_trigger" >
        <input type="hidden" name="" value="<?php echo $last_loaded_offer;?>" id="ajax__last_loaded_ads">
        <div class="advpost__btn-block">
            <span class="advpost__reset-btn--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="button" class="advpost__reset-btn is-rounded" value="Сбросить фильтры">
            </span>
        </div>

        <?php if( $offer_categories ):?>
            <div class="advpost__check-block is-mtop-10" id="adv-group-01">
                <div class="advpost__form-title"><b>Рубрики</b></div>

                <?php foreach( $offer_categories as $offer_cat ):?>
                    <input type="checkbox" name="filter__category[]" value="<?php echo $offer_cat->id;?>" class="ajax__adv_filter_input advpost__checkbox" id="filter_category_<?php echo $offer_cat->id;?>" <?php if(in_array( $offer_cat->id, $filter['category'])):?>checked<?php endif;?>>
                    <label class="advpost__label-c" for="filter_category_<?php echo $offer_cat->id;?>"><?php echo $offer_cat->value;?></label>
                <?php endforeach;?>

                <a href="" data-fancybox="adv-group-01" class="advpost__check-none is-blue-link <?php if( !array_key_exists('category', $filter) || count( $filter['category']  ) == 0 ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
            </div>
        <?php endif;?>

        <label for="advpost-filter" class="advpost__select-sidebar--wrap"><b>Сортировка</b>
            <select id="advpost-filter" name="filter__sort_by" class="ajax__adv_filter_input advpost__select-sidebar">
                <option value="id">Сначала свежие</option>
                <option value="views">Популярные</option>
                <!-- <option value="category">По рубрикам</option> -->
                <option value="low_price">По возрастанию цены</option>
                <option value="high_price">По убыванию цены</option>
            </select>
        </label>

        <?php if ($brands):?>
            <div class="advpost__check-block" id="adv-group-02">
                <div class="advpost__form-title"><b>По технике</b></div>
                <?php foreach ($brands as $brand):?>
                    <input type="checkbox" name="filter__brand[]" value="<?php echo $brand->id;?>" class="ajax__adv_filter_input advpost__checkbox" id="brand_<?php echo $brand->id;?>" <?php if(in_array( $brand->id, $filter['brand'])):?>checked<?php endif;?>>
                    <label class="advpost__label-c" for="brand_<?php echo $brand->id;?>"><?php echo $brand->value;?></label>
                <?php endforeach;?>
                <a href="" data-fancybox="adv-group-02" class="advpost__check-none is-blue-link <?php if( !array_key_exists('brand', $filter) || count( $filter['brand']  ) == 0 ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
            </div>
        <?php endif;?>

        <?php if( isset($filter__barter_disable) && !$filter__barter_disable):?>
        <div class="advpost__check-block is-mtop-30" id="adv-group-03">
            <div class="advpost__form-title"><b>Дополнительно</b></div>
                <input type="checkbox" name="filter__barter" value="yes" class="ajax__adv_filter_input advpost__checkbox" id="filter__barter" <?php if( array_key_exists( 'barter', $filter ) && $filter['barter'] == 'yes' ):?>checked<?php endif;?>>
                <label class="advpost__label-c" for="filter__barter">Возможен бартер</label>
            <a href="" data-fancybox="adv-group-03" class="advpost__check-none is-blue-link slide-hidden"><span>Сбросить</span></a>
        </div>
        <?php endif;?>

        <div class="advpost__summ-sidebar--lowwrap"><b>Суммы</b>
            <div>
                <input type="text" name="filter__price" class="ajax__adv_filter_input advpost__summ-sidebar" placeholder="от в руб." pattern="[0-9]{2}" value="<?php if( $filter['price'] ): echo $filter['price']; endif;?>"> - <input type="text" name="filter__max_price" class="ajax__adv_filter_input advpost__summ-sidebar advpost__summ-sidebar--r" placeholder="до в руб." pattern="[0-9]{2}" value="<?php if( $filter['max_price'] ): echo $filter['max_price']; endif;?>">
            </div>
        </div>
    </form>
</div>
