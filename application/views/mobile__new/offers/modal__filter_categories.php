<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 20/10/2018
 * Time: 22:39
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
        <div class="modal__title">Категории</div>
    </div>

    <div class="modal__head__section">
        <div class="modal__head__submit">
            <button class="ajax__filter_offers__submit-categories">
                <span class="m-hide">Готово</span> <i class="fa fa-check"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal__body scrollbar-inner">

    <div class="advpost__form-sidebar">
        <form action="">

            <div class="offers-add__inputs   form-input-group">

                <?php if( $offer_categories ):?>

                    <div class="advpost__radio--line clear     form-input-group__container">
                        <div class="form-input-group__label">
                            Рубрики
                        </div>
                        <div class="advpost__radio--cover     form-input-group__input-block">
                            <?php foreach( $offer_categories as $offer_cat ):?>
                                <div>
                                    <input type="checkbox" name="filter_light_category[]" value="<?php echo $offer_cat->id;?>" class="ajax__adv_filter_input advpost__checkbox" id="filter_light_category_<?php echo $offer_cat->id;?>" <?php if(in_array( $offer_cat->id, $filter['category'])):?>checked<?php endif;?>>
                                    <label class="advpost__label-c" for="filter_light_category_<?php echo $offer_cat->id;?>"><?php echo $offer_cat->value;?></label>
                                </div>

                            <?php endforeach;?>
                        </div>
                    </div>

                <?php endif;?>

            </div>

        </form>
    </div>

</div>
