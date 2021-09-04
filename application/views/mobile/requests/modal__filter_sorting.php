<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 21/10/2018
 * Time: 11:46
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

            <div class="form-input-group__container">
                <div class="form-input-group__label">
                    Сортировка
                </div>

                <div class="form-input-group__input-block">
                    <select id="request-filter" name="filter__sort" class="request__select-sidebar ajax__requests_filter_input  select select-box">
                        <option value="updated" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'sort') && $filter_saved->sort == 'updated' ):?>selected<?php endif;?>>Недавно обновленные</option>
                        <?php
                        $show_filter_marked = true;
                        switch( $sub_menu['selected'] ) {
                            case 'archived':
                                $show_filter_marked = false;
                                break;
                            case 'inbox':
                                if( $sub_menu['inbox_count'] == 0 )
                                    $show_filter_marked = false;
                                break;
                            case 'outbox':
                                if( $sub_menu['outbox_count'] == 0 )
                                    $show_filter_marked = false;
                                break;

                        }

                        if( $show_filter_marked ):
                            ?>
                            <option value="marked" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'sort') && $filter_saved->sort == 'marked' ):?>selected<?php endif;?>>Требующие действия</option>
                        <?php endif;?>
                        <option value="last" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'sort') && $filter_saved->sort == 'last' ):?>selected<?php endif;?>>Сначала новые</option>
                        <option value="oldest" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'sort') && $filter_saved->sort == 'oldest' ):?>selected<?php endif;?>>Сначала старые</option>
                    </select>
                </div>
            </div>








            <?php if ( isset( $equipment ) && is_array( $equipment ) && !empty($equipment) && ( $sub_menu['selected'] == 'archive' || $sub_menu['selected'] == 'outbox' ) ):?>

                <div class="advpost__radio--line clear     form-input-group__container">
                    <div class="form-input-group__label">
                        По технике
                    </div>
                    <div class="advpost__radio--cover     form-input-group__input-block">
                        <?php foreach ( $equipment as $equipment_item ):?>
                            <!-- Выбранный элемент из списка техники -->
                            <div class="js__requests__filter__equipment_list  advpost__tech-choosen is-long-row <?php if( ( $filter_saved && !property_exists( $filter_saved, 'equipment') ) || ($filter_saved && property_exists( $filter_saved, 'equipment') && $filter_saved->equipment == NULL) || ( property_exists( $filter_saved, 'equipment') &&  is_array( $filter_saved->equipment ) && !in_array( $equipment_item->id, $filter_saved->equipment) ) ):?>slide-hidden<?php endif;?>" data-equipment-id="<?php echo $equipment_item->id;?>">
                                <a href="#" class="is-or-link">
                                    <i class="fa fa-trash-o"></i>
                                    <span class="tech-choosen-id"><?php echo $equipment_item->brand_name .', '.$equipment_item->model;?></span>
                                </a>
                            </div>
                        <?php endforeach;?>

                        <a href="#requests__choose-eq" class="is-or-link tech-choose fancybox">
                            <span>Выбрать из парка...</span>
                        </a>

                        <a class="js__requests__filter__reset_equipment request__check-none pointer is-blue-link <?php if( !is_object( $filter_saved ) || !property_exists( $filter_saved, 'equipment') || count($filter_saved->equipment) == 0 ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
                    </div>
                </div>




            <?php endif;?>


            <div class="form-input-group__container">
                <div class="form-input-group__label">
                    Дата от
                </div>
                <div class="form-input-group__input-block">
                    <input type="text" name="filter__date_from" class="input__type-text   ajax__requests_filter_input advpost__summ-sidebar advpost__summ-sidebar--date" id="filter__datepicker__from" placeholder="с" value="<?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'output__date_from') && $filter_saved->output__date_from != '' ): echo $filter_saved->output__date_from; endif;?>"  readonly='true'>
                </div>
            </div>

            <div class="form-input-group__container">
                <div class="form-input-group__label">
                    Дата до
                </div>
                <div class="form-input-group__input-block">
                    <input type="text" name="filter__date_to" class="input__type-text    ajax__requests_filter_input advpost__summ-sidebar advpost__summ-sidebar--date advpost__summ-sidebar--r" placeholder="по" value="<?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'output__date_to') && $filter_saved->output__date_to != '' ): echo $filter_saved->output__date_to; endif;?>" id="filter__datepicker__to"  readonly='true'>
                </div>
            </div>



        </div>




    </form>






    <form action="">

        <?php if ( $employers ):?>


            <div class="offers-add__inputs form-input-group">
                <div class="form-input-group__container">
                    <div class="form-input-group__label">
                        <b>Сотрудники</b>
                    </div>
                    <div class="form-input-group__input-block">
                        <?php foreach ($employers as $employer):?>
                            <input type="hidden" name="filter__employers[]" value="<?php echo $employer->id;?>" >

                            <div class="employee__name-choosen is-long-row employee__name-choosen__user_<?php echo $employer->id;?>"  <?php if(
                            $filter_saved
                            &&
                            property_exists($filter_saved,'employers__to_show')
                            &&
                            (
                                (
                                    is_array($filter_saved->employers__to_show)
                                    &&
                                    !in_array($employer->id, $filter_saved->employers__to_show)
                                )
                                ||
                                $filter_saved->employers__to_show == NULL

                            )

                            ):?>style="display: none"<?php endif;?>>
                                <a href="" class="is-or-link" data-user="<?php echo $employer->id;?>">
                                    <i class="fa fa-trash-o"></i>
                                    <span class="tech-choosen-<?php echo $employer->id;?>"><?php echo $employer->last_name;?></span>
                                </a>

                            </div>
                        <?php endforeach;?>
                        <a href="#choose-partner" class="is-or-link partner-choose fancybox"><span>Выбрать из списка...</span></a>


                        <a class="js__requests__filter__reset_employers request__check-none pointer is-blue-link <?php if( !is_object( $filter_saved ) || !property_exists( $filter_saved, 'employers__to_show') || count($filter_saved->employers__to_show) == 0 ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>

                    </div>
                </div>
            </div>







            <div class="advpost__check-block">
                <div class="advpost__form-title"></div>

                <?php /*
                <div class="employee__me-choosen is-long-row">
                    <a class="is-grey-link"><i class="fa fa-trash-o"></i></a>
                    <span class="tech-choosen-01">Я</span>
                </div>
                */;?>

            </div>
        <?php endif;?>

    </form>


        <div class="request__btn-block is-mtop-30 text-right" style="padding-right: 20px; padding-bottom: 10px">
            <a href="#" class="is-or-link request__reset-btn">
                <span>
                    Сбросить фильтры
                </span>
            </a>
        </div>




    <div id="requests__choose-eq" class="modal" style="background: #fff">

        <div class="modal__head">
            <div class="modal__head__section">
                <div class="modal__head__close">
                    <a href="#" class="modal__close-btn__request_filter_equipment">
                        <i class="fa fa-times"></i>
                        <span class="m-hide">Закрыть</span>
                    </a>
                </div>
            </div>
            <div class="modal__head__section">
                <div class="modal__title">Техника</div>
            </div>

            <div class="modal__head__section">
                <div class="modal__head__submit">
                    <a href="#" class="pointer js__request_filter__add_equipment req-choose__btn btn ripple-effect">
                        <i class="fa fa-check i-left-15"></i><span class="m-hide">Применить</span>
                    </a>

                </div>
            </div>
        </div>


        <div class="modal__body"  style="background: #fff">

            <div class="new-msg__modal          requests__model__equipment_scroll-wrapper scrollbar-inner scroll-content scroll-scrolly_visible">

                <?php if ($equipment && is_array( $equipment ) && !empty($equipment) ):?>
                    <?php foreach ( $equipment as $equipment_item ):?>
                        <!-- строка с оборудованием -->
                        <div class="requests-info__block   js__equipment__modal-filter <?php if( $filter_saved && property_exists( $filter_saved, 'equipment') && $filter_saved->equipment != NULL && is_array( $filter_saved->equipment ) && in_array( $equipment_item->id, $filter_saved->equipment)  ):?>req-active<?php endif;?>" data-equipment-id="<?php echo $equipment_item->id;?>">
                            <div class="requests-info__photo">
                                <?php if ($equipment_item->thumbnail != false):?>
                                    <img src="/uploads/equipment/<?php echo $equipment_item->id;?>/small_<?php echo $equipment_item->thumbnail;?>" class="img-responsive">
                                <?php endif;?>
                            </div>
                            <div class="requests-info__content">
                                <p>
                                    <span class="requests-ind is-grey-text">Производитель:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->brand_name;?>&nbsp;</span>
                                </p>
                                <p>
                                    <span class="requests-ind is-grey-text">Назначение:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->appointment_name;?>&nbsp;</span>
                                </p>
                                <p>
                                    <span class="requests-ind is-grey-text">Модель:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->model;?>&nbsp;</span>
                                </p>
                                <p>
                                    <span class="requests-ind is-grey-text">Серийный номер:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->serial_number;?>&nbsp;</span>
                                </p>
                                <p>
                                    <span class="requests-ind is-grey-text">Двигатель:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->engine;?>&nbsp;</span>
                                </p>
                                <p>
                                    <span class="requests-ind is-grey-text">Год выпуска:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->year;?>&nbsp;</span>
                                </p>
                                <p>
                                    <span class="requests-ind is-grey-text">Подразделение:</span>
                                    <span class="requests-descr is-long-row"><?php echo $equipment_item->section;?>&nbsp;</span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>

            </div>

        </div>


    </div>
    <!-- end Выбрать технику -->


    <!-- Выбрать партнера -->
    <div id="choose-partner" class="modal" style="background: #fff;">


        <div class="modal__head">
            <div class="modal__head__section">
                <div class="modal__head__close">
                    <a href="#" class="modal__close-btn__request_filter_employers">
                        <i class="fa fa-times"></i>
                        <span class="m-hide">Закрыть</span>
                    </a>
                </div>
            </div>
            <div class="modal__head__section">
                <div class="modal__title">Мои сотрудники</div>
            </div>

            <div class="modal__head__section">
                <div class="modal__head__submit">
                    <a href="#" class="js__requests__filter__modal__choose_partners pointer requests__add-partner btn ripple-effect">
                        <i class="fa fa-check i-left-15"></i>
                        <span class="m-hide">Применить</span>
                    </a>
                </div>
            </div>
        </div>




            <div class="requests-partners__wrapper">
                <div class="wrapper-top"></div><div class="wrapper-btm"></div>
                <div class="requests-partners__slide scrollbar-inner scroll-content scroll-scrolly_visible" >
                    <?php foreach ($employers as $employer):?>
                        <div class="my-partners__row js__requests__modal__employer-<?php echo $employer->id;?>" <?php if($employer->ex_employer):?>style="opacity: 0.5"<?php endif;?>>
                            <div class="my-partners__lcell">
                                <a href="/partners/<?php echo $employer->id;?>" class="my-partners__image is-rounded">
                                    <?php if( $employer->avatar ):?>
                                        <img src="/uploads/users/<?php echo $employer->id;?>/avatar/80x80_<?php echo $employer->avatar;?>" alt="">
                                    <?php endif;?>
                                </a>
                                <div class="my-partners__content">
                                    <div>
                                        <a href="/partners/<?php echo $employer->id;?>" target="_blank" class="my-partners__name is-blue-link">
                                            <span><b><?php echo $employer->last_name;?> <?php echo $employer->name;?> <?php echo $employer->second_name;?></b></span>
                                        </a>
                                    </div>

                                    <?php if( property_exists($employer, 'company_role__val')):?>
                                        <div>
                                    <span class="my-partners__company-name is-grey-text">
                                        <span><?php echo $employer->company_role__val;?></span>
                                    </span>
                                        </div>
                                    <?php endif;?>


                                    <div class="requests__list__employers_block__rating_and_counts">
                                        <?php if ($employer->rating):?>
                                            <div class="my-partners__rating-level rate__lvl rate__lvl--<?php echo $employer->rating;?>"></div> <span class="is-grey-text">/&nbsp;</span>
                                        <?php endif;?>

                                        <?php if( property_exists($employer, 'requests_count') && $employer->requests_count ):?>
                                            <div class="my-partners__requests_found is-grey-text">Найдено заявок: <?php echo $employer->requests_count;?></div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>

                            <div class="my-partners__rcell">
                                <div class="choose-partner <?php if(
                                    !$filter_saved
                                    ||
                                    !property_exists($filter_saved,'employers__to_show')
                                    ||
                                    (
                                        property_exists($filter_saved,'employers__to_show')
                                        &&
                                        (
                                            is_array($filter_saved->employers__to_show)
                                            &&
                                            in_array($employer->id, $filter_saved->employers__to_show)
                                        )
                                    )
                                ):?>is-hidden<?php endif;?>">
                                    <a class="is-blue-link employee__name-choose"  data-user="<?php echo $employer->id;?>">
                                        <i class="fa fa-plus i-left-15"></i>
                                        <span>Выбрать</span>
                                    </a>
                                </div>
                                <div class="choosen-partner <?php if(
                                    $filter_saved
                                    &&
                                    property_exists($filter_saved,'employers__to_show')
                                    &&
                                    (
                                        (
                                            is_array($filter_saved->employers__to_show)
                                            &&
                                            !in_array($employer->id, $filter_saved->employers__to_show)
                                        )
                                        ||
                                        $filter_saved->employers__to_show == NULL

                                    )

                                ):?>is-hidden<?php endif;?>">
                                <span  class="is-grey-text">
                                    <i class="fa fa-check i-left-15"></i>
                                    <span>Выбран</span>
                                </span>
                                </div>
                                <div class="choosen-partner del-partner employee__name-choosen__modal <?php if(
                                    $filter_saved
                                    &&
                                    property_exists($filter_saved,'employers__to_show')
                                    &&
                                    (
                                        (
                                            is_array($filter_saved->employers__to_show)
                                            &&
                                            !in_array($employer->id, $filter_saved->employers__to_show)
                                        )
                                        ||
                                        $filter_saved->employers__to_show == NULL

                                    )

                                ):?>is-hidden<?php endif;?>" data-user="<?php echo $employer->id;?>">
                                    <a class="is-or-link">
                                        <i class="fa fa-times i-left-15"></i>
                                        <span>Отменить</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>






    </div>
    <!-- Выбрать партнера -->

</div>