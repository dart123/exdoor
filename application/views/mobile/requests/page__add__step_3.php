<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 18:59
 */

?>



<body>

<?php $this->load->view('mobile/misc/preloader');?>
    <aside class="sidebar">
        <?php
        $this->load->view('mobile/user/page__header', $page_content['menu']);
        $this->load->view('mobile/user/menu_user', $page_content['menu']);
        ?>
    </aside>
    <div class="sidebar-cover"></div>


    <header class="header">
        <div class="container">
            <!-- блоки, видимые на мобильном -->
            <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>
            <div class="header__page-title t-hide">Заявки</div>
            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
        </div>
    </header>





    <div class="content">

        <!-- Контент -->
        <section class="page-content-form left-400 ">


            <div class="page-content-form__left" style="padding: 10px;">
                <!--  Заголовок для блока с третьим шагом -->
                <div class="requests-step__line requests-step__third">
                    <div class="requests-step__title">
                        <b><span class="i-left-20">3</span></b>/ 3 <b class="text">Кому отправляем заявку?</b> <span class="is-grey-text">Можно выбрать не более 10</span>
                    </div>
                    <div class="requests-step__indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>


            <div style="padding: 10px;">
                <div class="page-content-form__left">
                    <!--  Заголовок заявки -->
                    <div class="requests-step__line">
                        <div class="requests-step__title">
                            <b>Заявка #<?php echo $page_content["request_data"]->id;?>.</b> <?php echo $page_content["request_data"]->eq_brand_name;?>, <?php echo $page_content["request_data"]->eq_appointment_name;?>, <?php echo $page_content["request_data"]->eq_model;?>
                        </div>
                    </div>
                </div>
                <div class="page-content-form__right">
                    <div class="requests-step__line">
                        <a href="#req__remove" class="is-or-link fancybox">
                            <span>Начать заново</span>
                        </a>
                    </div>
                </div>
            </div>



            <div class="page-content-form__left">
                <!--  Заявка с кнопкой редактировать -->

                <!--  Блок заявки -->
                <div class="requests-info__block is-rounded is-box-shadow">
                    <div class="requests-info__photo">
                        <?php if ($page_content["request_data"]->eq_thumbnail != false):?>
                            <img src="/uploads/equipment/<?php echo $page_content["request_data"]->eq_id;?>/158x158_<?php echo $page_content["request_data"]->eq_thumbnail;?>" class="img-responsive">
                        <?php endif;?>
                    </div>
                    <div class="requests-info__content">
                        <p>
                            <span class="requests-ind is-grey-text">Производитель:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_brand_name;?>&nbsp;</span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Назначение:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_appointment_name;?>&nbsp;</span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Модель:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_model;?>&nbsp;</span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Серийный номер:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_serial_number;?>&nbsp;</span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Двигатель:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_engine;?>&nbsp;</span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Год выпуска:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_year;?>&nbsp;</span>
                        </p>
                        <p>
                            <span class="requests-ind is-grey-text">Подразделение:</span>
                            <span class="requests-descr is-long-row"><?php echo $page_content["request_data"]->eq_section;?>&nbsp;</span>
                        </p>
                        <?php if( $page_content["equipment"]->images && is_array($page_content["equipment"]->images) && count($page_content["equipment"]->images) >= 2 ) :?>

                            <p>
                                <?php if ( is_array( $page_content["equipment"]->images) && count( $page_content["equipment"]->images ) > 0 ):?>
                                    <span class="requests-descr">
                                         <a href="#" class="open-album is-blue-link pointer" data-open-id="album-equipment" >
                                             <span>Еще фотографии</span>
                                         </a>
                                    </span>
                                <?php endif;?>
                            </p>

                            <div class="modal__block">
                                <?php foreach ($page_content["equipment"]->images as $key => $img):?>
                                    <a rel="album-equipment" class="image-show" href="/uploads/equipment/<?php echo $page_content["equipment"]->id;?>/lg1000_<?php echo $img;?>"></a>
                                <?php endforeach;?>
                            </div>
                        <?php endif;?>
                    </div>

                    <div class="clear"></div>

                    <a href="/requests/add?action=edit_equipment" class="requests__edit-btn   bl-btn btn-block    btn ripple-effect btn-primary2">
                        <i class="fa fa-pencil"></i>
                        <span class="">Редактировать</span>
                    </a>
                </div>

            </div>





            <div class="page-content-form__left" style="padding: 10px;">
                <!--  Заголовок позициии -->
                <div class="requests-step__line is-mright-400">
                    <div class="requests-step__title">
                        Запрашиваемые позиции
                    </div>
                </div>
            </div>




            <div class="page-content-form__left">
                <!--  Запрашиваемые позиции с кнопкой редактировать -->

                    <!--  Запрашиваемые позиции -->
                    <div class="requests-eq__block is-rounded is-box-shadow">
                        <!--  Позиция номер 1 -->
                        <?php
                        $r_i = 1;
                        foreach ($page_content["request_positions"] as $r_position):?>
                            <div class="requests-eq__item">
                                <div class="requests-eq__pos-row">
                                    <div class="requests-eq__no"><b>#<?php echo $r_i;?></b></div><!--
                                 --><div class="requests-eq__pos-descr">
                                        <div class="position-name">

                                            <?php if( $r_position->detail ):?>
                                                <p><?php echo $r_position->detail;?></p>
                                            <?php endif;?>

                                            <?php if( $r_position->catalog_num ):?>
                                                <p>Номер в каталогах: <?php echo $r_position->catalog_num;?></p>
                                            <?php endif;?>

                                            <p class="request_position__amount js__amount__position_<?php echo $r_position->id;?>" data-amount="<?php echo $r_position->amount;?>">
                                                <?php echo $r_position->amount;?> шт.
                                            </p>

                                        </div>
                                        <?php if (!empty($r_position->images_arr)):?>
                                            <div class="requests-eq__inner" style="float: right">
                                                <img src="/uploads/equipment/<?php echo $page_content["request_data"]->eq_id;?>/small_<?php echo $r_position->images_arr[0];?>" alt="">
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $r_i++;
                        endforeach;?>


                        <a href="/requests/add?action=edit_positions" class="requests__edit-btn btn ripple-effect btn-primary2       bl-btn btn-block">
                            <i class="fa fa-pencil"></i>
                            <span class="">Редактировать</span>
                        </a>

                    </div>

            </div>

            <div class="page-content-form__right">
                <!--  Кнопка Редактировать  -->

            </div>







            <div class="page-content-form__left">
                <!--  Блок с третьим шагом заполнения формы  -->
                <div class="is-mtop-30">
                    <!--  Блок с формой  -->
                    <div class="my-partners__rec requests__rec is-rounded is-box-shadow is-mtop-20">
                        <div class="rec__head is-first-item">
                            <div class="rec__title">Рекомендации</div>
                        </div>
                        <div class="rec__body ajax__selected_partners_container">
                            <?php if( $page_content["request_suggestion_partners"] ):?>
                                <?php foreach ( $page_content["request_suggestion_partners"] as $request_partner ):?>
                                    <div class="my-partners__row my-partners__row__user_<?php echo $request_partner->id;?>" data-partner-id="<?php echo $request_partner->id;?>">
                                        <div class="my-partners__lcell">
                                            <a href="/partners/<?php echo $request_partner->id;?>" target="_blank" class="my-partners__image is-rounded">
                                                <?php if ( $request_partner->avatar ):?>
                                                <img src="/uploads/users/<?php echo $request_partner->id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                                <?php endif;?>
                                            </a>
                                            <div class="my-partners__content">
                                                <div>
                                                    <a href="/partners/<?php echo $request_partner->id;?>" target="_blank" class="my-partners__name is-blue-link">
                                                        <span><b><?php echo $request_partner->name . ' ' . $request_partner->second_name . ' ' . $request_partner->last_name;?></b></span>
                                                    </a>
                                                </div>
                                                <div>
                                                    <?php if( $request_partner->company && $request_partner->company_id):?>
                                                    <a href="/company/id<?php echo $request_partner->company_id;?>" target="_blank" class="my-partners__company-name is-grey-link">
                                                        <span><?php echo $request_partner->company->short_name;?></span>
                                                    </a>
                                                    <?php else:?>
                                                        <a class="my-partners__company-name is-grey-link">
                                                            <span>Физическое лицо</span>
                                                        </a>
                                                    <?php endif;?>
                                                </div>
                                                <?php  /*if( $request_partner->rating):?>
                                                    <div class="my-partners__rating-level rate__lvl rate__lvl--5"></div>
                                                <?php endif; */?>
                                            </div>
                                        </div>

                                        <div class="my-partners__rcell" data-partner-id="<?php echo $request_partner->id;?>">
                                            <div class="choose-partner">
                                                <a class="is-blue-link js__request__add_partners">
                                                    <i class="fa fa-plus i-left-15"></i>
                                                    <span>Выбрать</span>
                                                </a>
                                            </div>
                                            <div class="choosen-partner is-hidden">
                                                <span class="is-grey-text">
                                                    <i class="fa fa-check i-left-15"></i>
                                                    <span>Выбран</span>
                                                </span>
                                            </div>
                                            <div class="choosen-partner del-partner is-hidden">
                                                <a class="is-or-link js__request__remove_partners">
                                                    <i class="fa fa-times i-left-15"></i>
                                                    <span>Отменить</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach;?>

                                <div class="my-partners__row my-partners__row__friends_delimiter is-hidden">
                                    <b>Выбранные Вами</b>
                                </div>

                            <?php endif;?>

                        </div>

                        <?php if( $page_content["request_partners"] ):?>
                            <div class="requests__choose">
                                <a href="#choose-partner" class="is-or-link fancybox">
                                    <i class="fa fa-plus"></i>
                                    <span>Выбрать из списка своих партнеров</span>
                                </a>
                            </div>
                        <?php endif;?>

                        <input type="hidden" id="send__to__partners">
                        <a class="js__request__add__select_partners pointer requests__submit btn-primary2 btn ripple-effect     bl-btn btn-block  is-mbtm-30 ">
                            <i class="fa fa-paper-plane"></i>
                            <span><b>Отправить заявку выбранным партнерам</b></span>
                        </a>
                    </div>
                </div>
            </div>

            <?php /*
            <div class="page-content-form__right">
                <div class="request-lvl__block is-mtop-30 is-rounded is-box-shadow">
                    Уровень заполненности

                    <div class="request-lvl__slider">
                        <div class="counter round-counter" id="counter-form-fill__step3">
                            <div class="rs-handle"></div>
                        </div>
                    </div>

                    <span class="is-or-text is-mtop-10 request-lvl__descr lvl-descr__third">Высокий</span>
                    <span class="is-grey-text is-mtop-20">Ваша заявка обречена на оперативное выполнение</span>
                </div>
            </div>
 */?>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->



    <?php if( $page_content["request_partners"] ):?>
        <!-- Выбрать партнера -->
        <div id="choose-partner" class="modal__block modal modal">


            <div class="modal__head">
                <div class="modal__head__section">
                    <div class="modal__head__close">
                        <a href="" class="modal__close-btn"><i class="fa fa-times"></i>
                            <span class="m-hide">Закрыть</span>
                        </a>
                    </div>
                </div>
                <div class="modal__head__section">
                    <div class="modal__title">Мои партнеры</div>
                </div>

                <div class="modal__head__section">
                    <div class="modal__head__submit">
                        <a href="#" class="requests__add-partner modal__close-btn">
                            <i class="fa fa-check"></i>
                            <span class="m-hide">Готово</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal__body">
                <div class="requests-partners__wrapper">

                    <div class="js__add_request__partners_modal requests-partners__slide            requests__model__equipment_scroll-wrapper         scrollbar-inner scroll-content scroll-scrolly_visible" >

                        <?php foreach ( $page_content["request_partners"] as $request_partner ):?>

                            <div class="my-partners__row my-partners__row__user_<?php echo $request_partner->id;?>"  data-partner-id="<?php echo $request_partner->id;?>">
                                <div class="my-partners__lcell">
                                    <a href="/partners/<?php echo $request_partner->id;?>" target="_blank" class="my-partners__image is-rounded">
                                        <?php if ( $request_partner->avatar ):?>
                                            <img src="/uploads/users/<?php echo $request_partner->id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                                        <?php endif;?>
                                    </a>
                                    <div class="my-partners__content">
                                        <div>
                                            <a href="/partners/<?php echo $request_partner->id;?>" target="_blank" class="my-partners__name is-blue-link">
                                                <span><b><?php echo $request_partner->name . ' ' . $request_partner->second_name . ' ' . $request_partner->last_name;?></b></span>
                                            </a>
                                        </div>
                                        <div>
                                            <?php if( $request_partner->company && $request_partner->company_id):?>
                                                <a href="/company/id<?php echo $request_partner->company_id;?>" target="_blank" class="my-partners__company-name is-grey-link">
                                                    <span><?php echo $request_partner->company->short_name;?></span>
                                                </a>
                                            <?php else:?>
                                                <a class="my-partners__company-name is-grey-link">
                                                    <span>Физическое лицо</span>
                                                </a>
                                            <?php endif;?>
                                        </div>
                                        <?php /* if( $request_partner->rating):?>
                                        <div class="my-partners__rating-level rate__lvl rate__lvl--<?php echo $request_partner->rating;?>"></div>
                                    <?php endif; */ ?>
                                    </div>
                                </div>

                                <div class="my-partners__rcell" data-partner-id="<?php echo $request_partner->id;?>">
                                    <div class="choose-partner">
                                        <a class="is-blue-link js__request__add_partners">
                                            <i class="fa fa-plus i-left-15"></i>
                                            <span>Выбрать</span>
                                        </a>
                                    </div>
                                    <div class="choosen-partner is-hidden">
                                    <span class="is-grey-text">
                                        <i class="fa fa-check i-left-15"></i>
                                        <span>Выбран</span>
                                    </span>
                                    </div>
                                    <div class="choosen-partner del-partner is-hidden">
                                        <a class="is-or-link js__request__remove_partners">
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


            <!-- -->
            <?php /*
            <div class="submit--ncover">
                <form action="">
                    <input type="submit" class="requests-modal__submit" value="" title="Начать поиск">
                    <input type="search" class="requests__search" autocomplete="off" placeholder="Поиск среди своих партнеров"/>
                </form>
            </div>
            */;?>

            <!-- -->


            <!-- Футер окна
            <div class="requests__footer">
                <span class="is-grey-text">Можно выбрать еще <span class="js__avalible_partners_counter">10</span> человек</span>

            </div>
            end Футер окна -->
        </div>
        <!-- Выбрать партнера -->

    <?php endif;?>

    </div>



    <?php $this->load->view("mobile/requests/modal__add__restart");?>



    <script>



        function uploadImg(event) {
            event.preventDefault();
            $("#fileElem").removeClass("active");
            $("#filelist").removeClass("active");
            $(event.target).closest("form").find("#fileElem").addClass("active");
            $(event.target).closest("form").find("#filelist").addClass("active");
            $(event.target).closest("form").find("#fileElem").click();
            return false;
        }


        function handleFiles(files) {

            var list = $("#filelist.active");
            var fileTypes   = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

            if (!files) {
                alert('Здесь ie9');
            } else {

                for (var i = 0, f; f = files[i]; i++) {

                    var reader              = new FileReader(),
                        original_file_name  = files[i].name;

                    var extension = files[i].name.split('.').pop().toLowerCase(),  //file extension from input file
                        isSuccess = fileTypes.indexOf(extension) > -1;

                    if(!isSuccess) {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Указаные вами файлы имеют недопустимый формат!')
                            .click();
                        return;
                    }

                    reader.onload = (function (f) {
                        return function (e) {

                            var existing_images     = [];

                            $( "#filelist > li" ).each(function( index ) {
                                if ( $(this).hasClass('js__existing_image') )
                                    existing_images.push( $(this).find('img').attr('data-original-src') );
                            });


                            $.ajax({
                                url:   '/ajax/upload_to_library',
                                data: {
                                    'equipment_id'      : <?php if($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>,
                                    'uploaded_images'   : [e.target.result],
                                    'existing_images'   : existing_images
                                },
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function(xhr){
                                    $('.preloader').fadeIn();
                                    $('.preloader__img').fadeIn();
                                },
                                success: function(result){
                                    if (result) {

                                        $( "#filelist").html('');

                                        result.images.forEach(function(item, i, data) {

                                            if ( files.length > i ) {
                                                li_class    = 'js__existing_image active';
                                            } else {
                                                li_class    = 'js__existing_image';
                                            }

                                            li      = $("<li class='"+li_class+"'></li>");

                                            $(list).append(li);
                                            $(li).append("<img src='/uploads/equipment/<?php if($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>/158x158_" + item + "'   data-original-src='" + item + "'/>");
                                            $(li).append("<a class='remove' data-image-original-name='" + item + "'></>");
                                            $(li).append("<a class='edit'></a>");
                                        });

                                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                            .attr('data-notifyText',  'Ваши изображения успешно загружены!')
                                            .click();
                                    }
                                },
                                error: function( result ) {
                                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                        .attr('data-notifyText',  'Внутрення ошибка сервера, попробуйте позже!')
                                        .click();
                                },
                                complete: function( result ){
                                    $('.preloader__img').fadeOut();
                                    $('.preloader').delay(350).fadeOut('slow');


                                }
                            });


                        };
                    })(f);

                    reader.readAsDataURL(f);
                }



                $('.eq__val').trigger('change');
            }
        }



        $(document).ready( function () {

            $('#counter-form-fill__step3').roundSlider({
                sliderType: "min-range",
                radius: 50,
                width: 2,
                value: <?php echo $page_content["total_progress"];?>,
                editableTooltip: false,
                tooltipFormat: "tooltipVal2"
            });



            //$("#counter-form-fill__step3").roundSlider("option", "value", );

            $('.js__requests_library__user_selected').click( function () {

                selected    = [];

                $( "#filelist > li" ).each(function( index ) {
                    if ( $(this).hasClass('active') )
                        selected.push( $(this).find('img').attr('data-original-src') );
                });

                if( selected.length == 0 ) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Похоже, вы не выбрали ни одного изображения!')
                        .click();

                    return;
                }


                selected.forEach( function(item, i, data) {
                    var li = $("<li></li>");
                    $('.images_library__here').append(li);
                    $(li).append("<img src='/uploads/equipment/<?php if($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>/158x158_" + item + "'   data-original-src='" + item + "'/>");
                });

                $('.images_library__here__images').val( JSON.stringify(selected) );

                $('.images_library__here').removeClass('images_library__here');
                $('.images_library__here__images').removeClass('images_library__here__images');
                $.fancybox.close();

                console.log( selected );
            });


            $('.js__open_images_library').click( function() {

                if( $(this).data('can-select') == true ) {
                    $('.js__requests_library__user_selected').show();
                } else {
                    $('.js__requests_library__user_selected').hide();
                }
                var place_to = $(this).data('for-id');
                $('#'+place_to).addClass('images_library__here');
                $('#'+place_to+'_images').addClass('images_library__here__images');

                $('#filelist > li').removeClass('active');
                $.fancybox.open({
                    href:       "#requests__add-eq",
                    closeBtn :  false,
                });
            });

        });

    </script>

<?php
    $this->load->view('mobile/requests/html__images_library');
    $this->load->view('mobile/requests/js/dnd');
    $this->load->view('mobile/requests/js/add_start_again');
    $this->load->view('mobile/requests/js/add_partners');
