<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 18:16
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

        <section class="page-content-form left-400">


            <div class="page-content-form__left" style="padding: 10px;">
                <!--  Заголовок заявки -->
                <div class="requests-step__line requests-step__second">
                    <div class="requests-step__title">
                        <b><span class="i-left-20">2</span></b>/ 3 <b class="text">Запрашиваемые позиции по заявленной технике</b>
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
                <!--  Заявка -->

                <!--  Блок заявки -->
                <div class="requests-info__block is-rounded is-box-shadow">
                    <div class="requests-info__photo">
                        <input id="eq__id" type="hidden" value="<?php echo $page_content["request_data"]->eq_id;?>">
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
                                <?php foreach ($page_content["equipment"]->images as $key => $img):?>
                                    <?php if ( $key == 1 ):?>
                                        <span class="requests-descr">
                                            <a href="#" class="js__open_images_library pointer is-blue-link" data-can-select="false">
                                                <span>Еще фотографии</span>
                                            </a>
                                        </span>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </p>

                        <?php else:?>

                            <p>
                                <span class="requests-descr">
                                    <a href="#" class="js__open_images_library is-blue-link pointer" data-can-select="false">
                                        <span>Добавить еще фотографий</span>
                                    </a>
                                </span>
                            </p>

                        <?php endif;?>
                    </div>
                    <div class="clear"></div>


                    <a href="/requests/add?action=edit_equipment" class="requests__edit-btn btn btn-block  bl-btn ripple-effect btn-primary2">
                        <i class="fa fa-pencil"></i>
                        <span>Редактировать</span>
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



            <div class="page-content-form__left" >
                <!--  Блок 2 шага заполнения формы  -->

                    <!--  Блок с формой  -->
                    <div class="requests-step__block is-rounded is-box-shadow">
                        <form action="/requests/add" method="POST" class="request__add_form">
                            <input type="hidden" name="action" value="add_positions">

                            <?php if( array_key_exists("request_positions", $page_content) && !empty($page_content["request_positions"])):?>

                                <?php foreach ($page_content["request_positions"] as $key => $position):?>
                                    <!-- Первая позиция -->
                                    <div class="requests-step__form-2">
                                        <div class="req__col requests__form-number">№1</div>
                                        <div class="req__col">
                                            <?php if( $key != 0 ):?>
                                                <a href="" class="js-del-step-form  is-or-link"><i class="fa fa-trash-o"></i></a>
                                            <?php endif;?>
                                        </div>
                                        <div class="req__col">
                                            <input type="text" name="detail[]" class="input__type-text requests-col__input pos_val_d" id="" placeholder="Название детали" value="<?php echo $position->detail;?>">
                                            <!--  -->
                                            <div class="req__col__3_4">
                                                <input type="text" inputmode="numeric" name="catalog_num[]" class="input__type-text requests-col__input pos_val_cn" id="" placeholder="Номер в каталогах" value="<?php echo $position->catalog_num;?>">
                                            </div>
                                            <div class="req__col__1_4">
                                                <input type="number" inputmode="numeric" name="amount[]" class="input__type-text" id="" placeholder="Количество" value="<?php echo $position->amount;?>">
                                            </div>

                                            <!--  -->

                                            <ul id="filelist_positions_<?php echo $position->id;?>" class="filelist has-edit clear">
                                                <?php if($position->images_arr):?>
                                                    <?php foreach ( $position->images_arr as $img):?>
                                                        <li class="request_edit__position__existing">
                                                            <img src="/uploads/equipment/<?php echo $page_content["request_data"]->eq_id;?>/158x158_<?php echo $img;?>"  data-original-src="<?php echo $img;?>"/>
                                                            <a class="remove js__remove_from_position" data-image-original-name="<?php echo $img;?>"></a>
                                                            <a class="edit js__image_edit__open_editor" data-image-original-url="/uploads/equipment/<?php echo $page_content["request_data"]->eq_id;?>/lg1000_<?php echo $img;?>" data-image-original-name="<?php echo $img;?>"></a>
                                                        </li>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </ul>
                                            <input id="filelist_positions_<?php echo $position->id;?>_images" type="hidden" name="images[]" value='<?php if(is_array($position->images_arr) && !empty($position->images_arr)): echo json_encode($position->images_arr); endif; ?>'>
                                            <div class="clearfix"></div>
                                            <a class="js__open_images_library pointer is-blue-link add-requests__label" data-can-select="true" data-for-id="filelist_positions_<?php echo $position->id;?>">
                                                <i class="fa fa-paperclip i-left-20"></i>
                                                <span>Прикрепить фото</span>
                                            </a>


                                        </div>
                                    </div>
                                    <!--  -->
                                <?php endforeach;?>

                            <?php else:?>
                                <!-- Первая позиция -->
                                <div class="requests-step__form-2">

                                    <div class="req__col requests__form-number">№1</div>
                                    <div class="req__col">

                                    </div>
                                    <div class="req__col">
                                        <input type="text" name="detail[]" class="input__type-text requests-col__input pos_val_d" id="" placeholder="Название детали">
                                        <!--  -->

                                        <div class="req__col__3_4">
                                            <input type="text"  inputmode="numeric" name="catalog_num[]" class="input__type-text requests-col__input pos_val_cn" id="" placeholder="Номер в каталогах">
                                        </div>
                                        <div class="req__col__1_4">
                                            <input type="number" inputmode="numeric" name="amount[]" class="input__type-text" placeholder="Количество">
                                        </div>

                                            <!--  -->
                                        <ul id="filelist_positions_0" class="filelist has-edit clear">

                                        </ul>
                                        <input id="filelist_positions_0_images" type="hidden" name="images[]" value="">
                                        <div class="clearfix"></div>
                                        <a class="js__open_images_library pointer is-blue-link add-requests__label" data-can-select="true" data-for-id="filelist_positions_0">
                                            <i class="fa fa-paperclip i-left-20"></i>
                                            <span>Прикрепить фото</span>
                                        </a>


                                    </div>
                                </div>
                                <!--  -->

                                <!-- Вторая позиция -->
                                <div class="requests-step__form-2">
                                    <div class="req__col requests__form-number">№2</div>
                                    <div class="req__col">
                                        <a href="" class="js-del-step-form is-or-link"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                    <div class="req__col">
                                        <input type="text" name="detail[]" class="input__type-text requests-col__input pos_val_d" id="" placeholder="Название детали">
                                        <!--  -->

                                        <div class="req__col__3_4">
                                            <input type="text" inputmode="numeric" name="catalog_num[]" class="input__type-text requests-col__input pos_val_cn" id="" placeholder="Номер в каталогах">
                                        </div>
                                        <div class="req__col__1_4">
                                            <input type="number" inputmode="numeric" name="amount[]" class="input__type-text" placeholder="Количество">
                                        </div>

                                            <!--  -->
                                        <ul id="filelist_positions_1" class="filelist has-edit clear">

                                        </ul>
                                        <input id="filelist_positions_1_images" type="hidden" name="images[]" value="">

                                        <!--  -->
                                        <a class="js__open_images_library pointer is-blue-link add-requests__label" data-can-select="true" data-for-id="filelist_positions_1">
                                            <i class="fa fa-paperclip i-left-20"></i>
                                            <span>Прикрепить фото</span>
                                        </a>

                                    </div>
                                </div>
                                <!--  -->
                            <?php endif;?>
                            <div class="requests__add-row">
                                <a href="" class="requests__add-eq is-or-link">
                                    <i class="fa fa-plus"></i>
                                    <span>Добавить еще одну позицию</span>
                                </a>
                            </div>

                            <a class="js__request_add_positions    bl-btn btn-block     pointer requests__next-step btn-primary2 btn ripple-effect   is-mbtm-30">Продолжить</a>
                        </form>
                    </div>
                    <!--  end Блок с формой  -->

            </div>

            <?php /*
            <div class="page-content-form__right">
                <div class="request-lvl__block is-rounded is-mtop-30 is-box-shadow">
                    Уровень заполненности

                    <div class="request-lvl__slider">
                        <div class="counter round-counter" id="counter-form-fill__positions">
                            <div class="rs-handle"></div>
                        </div>
                    </div>

                    <span id="request-lvl__descr" class="is-or-text is-mtop-10 request-lvl__descr lvl-descr__second">Средний</span>
                    <span class="is-grey-text is-mtop-20">Дополнительные сведения о технике, котрая указана на предыдущем шаге.</span>
                </div>
            </div>
            */?>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->



    </div>


    <?php $this->load->view("mobile/requests/modal__add__restart");?>


<script>
    $(document).ready( function () {


        $("body").on("click", "#filelist li", function(event){

            if( $(".js__requests_library__user_selected").css("display") == "block" ) {

                if( event.target.nodeName == 'IMG' )
                    $(this).toggleClass('active');

            }

        });

        $('#counter-form-fill__positions').roundSlider({
            sliderType: "min-range",
            radius: 50,
            width: 2,
            value: <?php echo $page_content["request_data"]->progress;?>,
            editableTooltip: false,
            tooltipFormat: "tooltipVal2"
        });
        $(".pos_val_d, .pos_val_cn").change(function() {

            var value       = <?php echo $page_content["request_data"]->progress;?>,
                details     = false,
                cat_num     = false;

            $('.pos_val_d').each( function (index) {
                if( $(this).val() != '' ) {
                    details = true;
                }
            });

            $('.pos_val_cn').each( function (index) {
                if( $(this).val() != '' ) {
                    cat_num = true;
                }
            });

            if (details) value += 25;
            if (cat_num) value += 25;

            $("#counter-form-fill__positions").roundSlider("option", "value", value);


            if (value <= 33) {
                $('.ui-widget-header').css('background' , '#ff6c08');
                $('.eq__progressval i').removeClass('hundred');
                $('.eq__progressval').css('background-position' , '0 0');

                $('#counter-form-fill__positions .rs-range-color').css('background' , '#ff6c08');
                $('#request-lvl__descr').text('Очень низкий').css('color' , '#ff6c08');
                $('#counter-form-fill__positions .rs-move').css('background-position' , '0 0');
                $('#request-lvl__long_descr').text('К сожалению, заявки такого уровня содержания часто остаются без ответа, из-за трудности их обработки. Добавьте подробностей');

            } else if (value > 33 && value <= 66 ) {
                $('.ui-widget-header').css('background' , '#fec315');
                $('.eq__progressval i').removeClass('hundred');
                $('.eq__progressval').css('background-position' , '0 -15px');

                $('#counter-form-fill__positions .rs-range-color').css('background' , '#fec315');
                $('#request-lvl__descr').text('Средний').css('color' , '#fec315');
                $('#counter-form-fill__positions .rs-move').css('background-position' , '0 -15px');
                $('#request-lvl__long_descr').text('Вы неплохо описали этот этап заявки, но если добавите подробностей, на Вашу заявку быстрее откликнутся');

            } else if (value > 66 && value <= 99) {
                $('.ui-widget-header').css('background' , '#00bea5');
                $('.eq__progressval i').removeClass('hundred');
                $('.eq__progressval').css('background-position' , '0 -30px');

                $('#counter-form-fill__positions .rs-range-color').css('background' , '#00bea5');
                $('#request-lvl__descr').text('Высокий').css('color' , '#00bea5');
                $('#counter-form-fill__positions .rs-move').css('background-position' , '0 -30px');
                $('#request-lvl__long_descr').text('Отлично! Ваша заявка - эталон и образец. У Ваших потенциальных исполнителей есть все исходные данные, для того чтобы наиболее достоверно составить ответ!');

            } else if (value == 100 ) {
                $('.eq__progressval i').addClass('hundred');
            }
        });



        $('.pos_val_d').trigger('change');


    });



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

        console.log(files);

        var all_selected_items      = [];

        $( "#filelist > li" ).each(function( index ) {
            if ( $(this).hasClass('active') )
                all_selected_items.push( $(this).find('img').attr('data-original-src') );
        });

        $('.requests-step__block').remove('.request_edit__position_'+ +'__existing');

        var list        = $("#filelist.active");
        var fileTypes   = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
        if (!files) {
            alert('Здесь ie9');
        } else {



            var post_images = [];

            for (var i = 0, f; f = files[i]; i++) {


                if( f.size > 7900000) {

                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Размер загружаемого файла превышает 8Мб.')
                        .click();
                    return;

                }

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

                        var image = new Image();
                        image.src = e.target.result;

                        image.onload = function() {

                            if (this.width > 5000 || this.height > 5000) {

                                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                    .attr('data-notifyText', 'Разрешение загружаемого изображения превышает 5000х5000 пикселей.')
                                    .click();
                                return false;

                            } else {





                                post_images.push( e.target.result );

                                if(  post_images.length == files.length ) {

                                    var existing_images     = [];

                                    $( "#filelist > li" ).each(function( index ) {
                                        if ( $(this).hasClass('js__existing_image') )
                                            existing_images.push( $(this).find('img').attr('data-original-src') );
                                    });


                                    $.ajax({
                                        url:   '/ajax/upload_to_library',
                                        data: {
                                            'equipment_id'      : <?php if($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>,
                                            'uploaded_images'   : post_images,
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

                                                new_files   = result.images.slice( -files.length );

                                                result.images.forEach(function(item, i, data) {

                                                    if ( new_files.indexOf( item ) != -1 ) {
                                                        li_class    = 'js__existing_image active';
                                                    } else {
                                                        li_class    = 'js__existing_image';
                                                    }

                                                    li      = $("<li class='"+li_class+"'></li>");
                                                    $(list).append(li);
                                                    $(li).append("<img src='/uploads/equipment/<?php if($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>/158x158_" + item + "'   data-original-src='" + item + "'/>");
                                                    $(li).append("<a href='#' class='remove js__remove_from_library' data-image-original-name='" + item + "'></a>");
                                                    $(li).append("<a href='#' class='edit js__image_edit__open_editor' data-image-original-url='https://exdor.ru/uploads/equipment/<?php if ($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>/lg1000_" + item + "' data-image-original-name='" + item + "' ></a>");

                                                });

                                                $( "#filelist > li" ).each(function( index ) {
                                                    original_src    = $(this).find('img').attr('data-original-src');
                                                    if ( all_selected_items.indexOf( original_src ) != -1 ) {
                                                        $(this).addClass('active');
                                                    }
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
                                }
                            }
                        }
                    };
                })(f);

                reader.readAsDataURL(f);
            }


            $('.eq__val').trigger('change');
        }
    }



    $(document).ready( function () {
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

            $('.images_library__here').html(''); //  обновляем список
            selected.forEach( function(item, i, data) {
                var li = $("<li></li>");
                $('.images_library__here').append(li);
                $(li).append("<img src='/uploads/equipment/<?php if($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>/158x158_" + item + "?v=" + Math.floor(Date.now() / 1000) + "'   data-original-src='" + item + "'/>");
                $(li).append("<a href='#' class='remove js__remove_from_position' data-image-original-name='" + item + "'></a>");
                $(li).append("<a href='#' class='edit js__image_edit__open_editor' data-image-original-url='https://exdor.ru/uploads/equipment/<?php if ($page_content["request_data"]->eq_id) echo $page_content["request_data"]->eq_id;?>/lg1000_" + item + "' data-image-original-name='" + item + "' ></a>");
            });

            $('.images_library__here__images').val( JSON.stringify(selected) );

            $('.images_library__here').removeClass('images_library__here');
            $('.images_library__here__images').removeClass('images_library__here__images');

            $.fancybox.close();

        });

        $('body').on('click', '.js__remove_from_position', function() {

            html_ul         = $(this).closest('ul');
            html_ul_id      = html_ul.attr('id');
            html_input      = $('#' + html_ul_id + '_images');

            $(this).closest('li').remove();

            images_left     = [];

            $( "#" + html_ul_id + " > li" ).each(function( index ) {
                images_left.push( $(this).find('img').attr('data-original-src') );
            });

            $( "#" + html_ul_id + "_images" ).val( JSON.stringify(images_left) );

        });

        $('body').on('click', '.js__open_images_library', function() {

            if( $(this).data('can-select') == true ) {
                $('.js__requests_library__user_selected').show();
            } else {
                $('.js__requests_library__user_selected').hide();
            }
            var place_to = $(this).data('for-id');
            $('#'+place_to).addClass('images_library__here');   // список картинок
            $('#'+place_to+'_images').addClass('images_library__here__images'); // Инпут с данными


            $('#filelist > li').removeClass('active');

            if( $('#'+place_to+'_images').val() && $('#'+place_to+'_images').val().length > 0  ) {
                selected_images = JSON.parse( $('#'+place_to+'_images').val() );

                $('#filelist > li').each( function ( index ) {
                    li  = $(this);
                    img = li.find('img').data('original-src');
                    console.log( img + ' in ' + selected_images );
                    if( $.inArray( img, selected_images ) != -1 ) {
                        li.addClass('active');
                    }
                })

            }


            $.fancybox.open({
                href:       "#requests__add-eq",
                closeBtn :  false,
            });
        });

        $('body').on('click', '.js__remove_from_library', function() {

            image       = $(this).data('image-original-name');

            $(this).parent('li').remove();

            existing_images     = [];
            $('#filelist > li').each( function () {
                existing_images.push(    $(this).find('img').data('original-src')   );
            });

            $.ajax({
                url:   '/ajax/upload_to_library',
                data: {
                    'equipment_id'      : <?php echo $page_content["request_data"]->eq_id;?>,
                    'existing_images'   : existing_images
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn(0);
                    $('.preloader__img').fadeIn(0);

                },
                success: function(data){
                    if (data) {

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово!')
                            .attr('data-notifyText',  'Изображени удалено из парка техники и из заявки!')
                            .click();

                        $('.js__remove_from_position[data-image-original-name="' + image + '"]').trigger( 'click' );

                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Возникла ошибка! Попробуйте позже')
                            .click();
                    }

                },
                error: function( result ) {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Внутрення ошибка сервера, попробуйте позже!')
                        .click();
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut('slow');
                    $('.preloader').delay(350).fadeOut('slow');
                }
            });





        });
    });
</script>
<?php
    $this->load->view('mobile/requests/html__images_library');
    $this->load->view('mobile/requests/js/dnd');
    //$this->load->view('mobile/requests/js/__pixie_editor');

    $this->load->view('desktop/misc/js/pixie2');

    $this->load->view('mobile/requests/js/add_start_again');
    $this->load->view('mobile/requests/js/add_positions');