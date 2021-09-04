<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 21/10/2018
 * Time: 11:45
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
        <div class="modal__title">Статусы</div>
    </div>

    <div class="modal__head__section">
        <div class="modal__head__submit">
            <button class="ajax__requests_filter_input__submit">
                <span class="m-hide">Готово</span> <i class="fa fa-check"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal__body scrollbar-inner">

    <form action="">
        <input type="hidden" class="ajax__requests_filter_input" id="js__filter_input_trigger">


        <div class="offers-add__inputs form-input-group">


            <div class="advpost__radio--line clear     form-input-group__container is-mtop-10">
                <div class="form-input-group__label">
                    Статус
                </div>
                <div class="advpost__radio--cover     form-input-group__input-block">
                    <?php if( $filter__avalible_options['formed']):?>
                        <input type="checkbox" name="filter__status[]" value="formed" class="request__checkbox ajax__requests_filter_input" id="request-status-01" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('send', $filter_saved->status) ):?>checked<?php endif;?>>
                        <label class="request__label-c" for="request-status-01">Сформирована</label><br>
                    <?php endif;?>

                    <?php if( $filter__avalible_options['in_proccess']):?>
                        <input type="checkbox" name="filter__status[]" value="in_proccess" class="request__checkbox ajax__requests_filter_input" id="request-status-02" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('payed', $filter_saved->status) ):?>checked<?php endif;?>>
                        <label class="request__label-c" for="request-status-02">В работе</label><br>
                    <?php endif;?>

                    <?php if( $filter__avalible_options['done']):?>
                        <input type="checkbox" name="filter__status[]" value="done" class="request__checkbox ajax__requests_filter_input" id="request-status-03" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('finished', $filter_saved->status) ):?>checked<?php endif;?>>
                        <label class="request__label-c" for="request-status-03">Завершена</label><br>
                    <?php endif;?>

                    <?php if( $filter__avalible_options['canceled']):?>
                        <input type="checkbox" name="filter__status[]" value="canceled" class="request__checkbox ajax__requests_filter_input" id="request-status-04" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('canceled', $filter_saved->status) ):?>checked<?php endif;?>>
                        <label class="request__label-c is-last-el" for="request-status-04">Отменена</label>
                    <?php endif;?>
                </div>
            </div>

        </div>


        <div class="request__btn-block is-mtop-30 text-right" style="padding-right: 20px; padding-bottom: 10px">
            <a href="#" class="is-or-link request__reset-btn">
                <span>
                    Сбросить фильтры
                </span>
            </a>
        </div>


    </form>


</div>
