<?php
/**
 * Created by developer with PhpStorm.
 * Date: 26.08.2018 18:41
 *
 *
 */

?>


<div class="modal__head">
    <div class="modal__head__section">

        <?php if ($page_content["equipment"] != false):?>
            <div class="modal__head__close">
                <a href="" class="modal__close-btn"><i class="fa fa-times"></i>
                    <span class="m-hide">Закрыть</span>
                </a>
            </div>
        <?php endif;?>

    </div>
    <div class="modal__head__section">

        <div class="modal__title">Производители</div>

    </div>

    <div class="modal__head__section">

        <div class="modal__head__submit">

            <button class="ajax__equipment_filter_submit">
                <span class="m-hide">Готово</span> <i class="fa fa-check"></i>
            </button>

        </div>

    </div>


</div>
<div class="modal__body scrollbar-inner">

    <div class="modal__block__color-white">

        <div class="eq__form-sidebar" style="padding: 10px 5px;">
            <form action="">
                <input type="hidden" name="" value="" class="ajax__equipment_filter_input ajax__filter_hidden_field_trigger" >
                <?php if ($filter_brands):?>

                    <div class="form-input-group">

                        <div class="form-input-group__container">

                            <div class="form-input-group__input-block">

                                <?php foreach ($filter_brands as $f_brand):?>
                                    <input type="checkbox" name="filter__brand[]" value="<?php echo $f_brand['id'];?>" class="ajax__equipment_filter_input advpost__checkbox" id="brand_<?php echo $f_brand['id'];?>" <?php if(in_array( $f_brand['id'], $filter['brand'])):?>checked<?php endif;?>>
                                    <label class="advpost__label-c" for="brand_<?php echo $f_brand['id'];?>"><?php if($f_brand['id'] == 0) echo 'Не указан'; else echo $f_brand['name'];?> <span>(<?php echo $f_brand['count'];?>)</span></label>
                                    <br>
                                <?php endforeach;?>
                                <br>
                                <br>
                                <br>
                                <a href="" rel="adv-group-02" class="eq__check-none is-blue-link <?php if( empty($filter['brand'])):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
                            </div>
                        </div>

                    </div>

                <?php endif;?>
            </form>
        </div>


    </div>

</div>


