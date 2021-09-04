<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.11.16
 * Time: 13:15
 */

?>

<div class="request__form-sidebar">


    <form action="">
        <input type="hidden" class="ajax__requests_filter_input" id="js__filter_input_trigger">
        <div class="request__btn-block">
            <span class="request__reset-btn--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="button" class="request__reset-btn is-rounded" value="Сбросить фильтры">
            </span>
        </div>

        <div class="request__check-block is-mtop-10" id="req-group-01">
            <div class="request__form-title"><b>В статусе</b></div>

            <?php if( $filter__avalible_options['formed']):?>
            <input type="checkbox" name="filter__status[]" value="formed" class="request__checkbox ajax__requests_filter_input" id="request-status-01" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('send', $filter_saved->status) ):?>checked<?php endif;?>>
            <label class="request__label-c" for="request-status-01">Сформирована</label>
            <?php endif;?>

            <?php if( $filter__avalible_options['in_proccess']):?>
            <input type="checkbox" name="filter__status[]" value="in_proccess" class="request__checkbox ajax__requests_filter_input" id="request-status-02" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('payed', $filter_saved->status) ):?>checked<?php endif;?>>
            <label class="request__label-c" for="request-status-02">В работе</label>
            <?php endif;?>

            <?php if( $filter__avalible_options['done']):?>
            <input type="checkbox" name="filter__status[]" value="done" class="request__checkbox ajax__requests_filter_input" id="request-status-03" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('finished', $filter_saved->status) ):?>checked<?php endif;?>>
            <label class="request__label-c" for="request-status-03">Завершена</label>
            <?php endif;?>

            <?php if( $filter__avalible_options['canceled']):?>
            <input type="checkbox" name="filter__status[]" value="canceled" class="request__checkbox ajax__requests_filter_input" id="request-status-04" <?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'status') && in_array('canceled', $filter_saved->status) ):?>checked<?php endif;?>>
            <label class="request__label-c is-last-el" for="request-status-04">Отменена</label>
            <?php endif;?>



            <a href="" rel="request__checkbox" class="js__requests__filter__reset_status request__check-none is-blue-link <?php if( !is_object( $filter_saved ) || !property_exists( $filter_saved, 'status') || count($filter_saved->status) == 0 ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
        </div>

        <label for="request-filter" class="request__select-sidebar--wrap"><b>Сортировка</b>
            <select id="request-filter" name="filter__sort" class="request__select-sidebar ajax__requests_filter_input">
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
        </label>

        <?php if ( isset( $equipment ) && is_array( $equipment ) && !empty($equipment) && ( $sub_menu['selected'] == 'archive' || $sub_menu['selected'] == 'outbox' ) ):?>
            <div class="advpost__check-block">
                <div class="advpost__form-title"><b>По технике</b></div>

                <?php foreach ( $equipment as $equipment_item ):?>
                    <!-- Выбранный элемент из списка техники -->
                    <div class="js__requests__filter__equipment_list  advpost__tech-choosen is-long-row <?php if( ( $filter_saved && !property_exists( $filter_saved, 'equipment') ) || ($filter_saved && property_exists( $filter_saved, 'equipment') && $filter_saved->equipment == NULL) || ( property_exists( $filter_saved, 'equipment') &&  is_array( $filter_saved->equipment ) && !in_array( $equipment_item->id, $filter_saved->equipment) ) ):?>slide-hidden<?php endif;?>" data-equipment-id="<?php echo $equipment_item->id;?>">
                        <a href="" class="is-or-link"><i class="fas fa-trash-alt"></i></a>
                        <span class="tech-choosen-id"><?php echo $equipment_item->brand_name .', '.$equipment_item->model;?></span>
                    </div>
                <?php endforeach;?>

                <a href="#requests__choose-eq" class="is-or-link tech-choose fancybox">
                    <span>Выбрать из парка...</span>
                </a>

                <a class="js__requests__filter__reset_equipment request__check-none pointer is-blue-link <?php if( !is_object( $filter_saved ) || !property_exists( $filter_saved, 'equipment') || ( is_array($filter_saved->equipment) && empty($filter_saved->equipment) ) ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
            </div>
        <?php endif;?>

        <div class="request__select-sidebar--wrap"></div>
        <!--
        <div class="request__select-sidebar--wrap"><b>Суммы</b>
            <div>
                <input type="number" class="advpost__summ-sidebar" placeholder="от" pattern="[0-9]{2}" inputmode="numeric"> - <input type="number" class="advpost__summ-sidebar advpost__summ-sidebar--r" placeholder="до" pattern="[0-9]{2}" inputmode="numeric">
            </div>
        </div>
        -->

        <div class="advpost__summ-sidebar--lowwrap" style="position: relative;">
            <b>Дата</b>
            <div>
                <input type="text" name="filter__date_from" class="ajax__requests_filter_input advpost__summ-sidebar advpost__summ-sidebar--date" id="filter__datepicker__from" placeholder="с" value="<?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'output__date_from') && $filter_saved->output__date_from != '' ): echo $filter_saved->output__date_from; endif;?>" >
                -
                <input type="text" name="filter__date_to" class="ajax__requests_filter_input advpost__summ-sidebar advpost__summ-sidebar--date advpost__summ-sidebar--r" placeholder="по" value="<?php if(is_object( $filter_saved ) && property_exists( $filter_saved, 'output__date_to') && $filter_saved->output__date_to != '' ): echo $filter_saved->output__date_to; endif;?>" id="filter__datepicker__to">
            </div>

            <a class="js__requests__filter__reset_date pointer request__check-none is-blue-link <?php if( !is_object( $filter_saved ) || !property_exists( $filter_saved, 'output__date_to') || !property_exists( $filter_saved, 'output__date_from') || ( $filter_saved->output__date_to == '' && $filter_saved->output__date_from == '' ) ):?>slide-hidden<?php endif;?>"><span>Сбросить</span></a>
        </div>



        <?php if ( $employers ):?>
            <div class="request__select-sidebar--wrap"></div>


            <div class="advpost__check-block">
                <div class="advpost__form-title"><b>Сотрудники</b></div>

                <?php /*
                <div class="employee__me-choosen is-long-row">
                    <a class="is-grey-link"><i class="fas fa-trash-alt"></i></a>
                    <span class="tech-choosen-01">Я</span>
                </div>
                */;?>
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
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <span class="tech-choosen-<?php echo $employer->id;?>"><?php echo $employer->last_name;?> <?php echo $employer->name;?> <?php echo $employer->second_name;?></span>
                    </div>
                <?php endforeach;?>
                <a href="#choose-partner" class="is-or-link partner-choose fancybox"><span>Выбрать из списка...</span></a>

                <a class="js__requests__filter__reset_employers request__check-none pointer is-blue-link
                    <?php if(
                        !is_object( $filter_saved ) ||
                        !property_exists( $filter_saved, 'employers__to_show') ||
                        !is_array( $filter_saved->employers__to_show ) ||
                        count($filter_saved->employers__to_show) == 0 ):?>
                        slide-hidden
                    <?php endif;?>">
                    <span>Сбросить</span>
                </a>

            </div>
        <?php endif;?>

    </form>




    <!-- Выбрать технику -->
    <div id="requests__choose-eq" class="new-msg__modal">

        <div class="modal__head modal__head--blue is-first-item">
            <div class="modal__title">Выберите технику</div>
            <a href="" class="modal__close-btn">Закрыть <i class="fas fa-times"></i></a>
        </div>

        <?php /*
        <div class="new-msg__top-line">
            <div class="new-msg__title">Выберите технику из парка</div>


            <div class="submit--rcover">
                <form action="">
                    <input type="submit" class="new-msg__submit" value="" title="Начать поиск">
                    <input type="search" class="new-msg__search is-rounded" placeholder="Поиск по технике в парке">
                </form>
            </div>




        </div>*/;?>
        <div class="is-rounded is-box-shadow" style="background: #fff">

            <div class="requests__model__equipment_scroll-wrapper scrollbar-inner scroll-content scroll-scrolly_visible">

                <?php if ($equipment && is_array( $equipment ) && !empty($equipment) ):?>
                    <?php foreach ( $equipment as $equipment_item ):?>
                        <!-- строка с оборудованием -->
                        <div class="requests-info__block is-rounded is-mtop-10 is-box-shadow js__equipment__modal-filter <?php if( $filter_saved && property_exists( $filter_saved, 'equipment') && $filter_saved->equipment != NULL && is_array( $filter_saved->equipment ) && in_array( $equipment_item->id, $filter_saved->equipment)  ):?>req-active<?php endif;?>" data-equipment-id="<?php echo $equipment_item->id;?>">
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
            <a class="pointer js__request_filter__add_equipment req-choose__btn btn-primary2 btn ripple-effect">Применить</a>
        </div>


    </div>
    <!-- end Выбрать технику -->


    <!-- Выбрать партнера -->
    <div id="choose-partner" class="modal__block is-rounded">
        <div class="modal__head modal__head--blue is-first-item">
            <div class="modal__title">Мои сотрудники</div>
            <a href="" class="modal__close-btn">Закрыть <i class="fas fa-times"></i></a>
        </div>
        <!--

        <div class="submit--ncover">
            <form action="">
                <input type="submit" class="requests-modal__submit" value="" title="Начать поиск">
                <input type="search" class="requests__search" autocomplete="off" placeholder="Поиск среди своих партнеров"/>
            </form>
        </div>

         -->
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
                                    <i class="fas fa-plus i-left-15"></i>
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
                                    <i class="fas fa-check i-left-15"></i>
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
                                    <i class="fas fa-times i-left-15"></i>
                                    <span>Отменить</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>




            </div>
        </div>
        <!-- Футер окна -->
        <div class="requests__footer">
            <span class="is-grey-text">&nbsp;</span>

            <a class="js__requests__filter__modal__choose_partners pointer requests__add-partner btn ripple-effect btn-primary2 is-rounded">
                <i class="fas fa-check i-left-15"></i><span>Применить</span>
            </a>
        </div>
        <!-- end Футер окна -->
    </div>
    <!-- Выбрать партнера -->



</div>
