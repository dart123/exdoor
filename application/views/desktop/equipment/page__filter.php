<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.11.16
 * Time: 15:44
 */
?>
<div class="eq__form-sidebar">
    <form action="">
        <input type="hidden" name="" value="" class="ajax__equipment_filter_input ajax__filter_hidden_field_trigger" >
        <?php if ($filter_brands):?>
            <div class="advpost__check-block" id="eq-group-01">
                <div class="eq__form-title"><b>Производители</b></div>

                <?php foreach ($filter_brands as $f_brand):?>
                    <input type="checkbox" name="filter__brand[]" value="<?php echo $f_brand['id'];?>" class="ajax__equipment_filter_input advpost__checkbox" id="brand_<?php echo $f_brand['id'];?>" <?php if(in_array( $f_brand['id'], $filter['brand'])):?>checked<?php endif;?>>
                    <label class="advpost__label-c" for="brand_<?php echo $f_brand['id'];?>"><?php if($f_brand['id'] == 0) echo 'Не указан'; else echo $f_brand['name'];?> <span>(<?php echo $f_brand['count'];?>)</span></label>
                <?php endforeach;?>
                <a href=""  class="eq__check-none is-blue-link <?php if( empty($filter['brand'])):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>

            </div>
        <?php endif;?>
    </form>
</div>
