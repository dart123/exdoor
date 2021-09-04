<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.09.16
 * Time: 18:21
 */

?>
<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>

        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <!-- Контент -->
        <section class="page-content-form left-400">
            <div class="page-content-form__left">
                <div class="requests-step__line requests-step__first">
                    <div class="requests-step__title">
                        <b><span class="i-left-20">1</span></b>/ 3 <b class="text">Техника, связанная с заявкой</b>
                    </div>
                    <div class="requests-step__indicator">
                        <span></span>
                        <span></span>
                        <span></span>
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


            <!--  Блок 1 шагом заполнения формы  -->

            <div class="page-content-form__left">
                <!--  Блок с формой  -->
                <div class="requests-step__block is-rounded is-box-shadow is-mtop-30">
                    <form method="POST" action="/requests/add" class="request__add_form requests-step__form">
                        <input type="hidden" name="action" class="eq__val" value="select_equipment">
                        <?php if ($equipment && $request_data && $request_data->id):?>
                        <input type="hidden" name="request_id" value="<?php echo $request_data->id;?>">

                            <?php if( $equipment_selected &&  $equipment_selected->images ):
                                foreach ( $equipment_selected->images as $img ): ?>
                                    <input type="hidden" name="existing_images[]" value="<?php echo $img;?>">
                                <?php endforeach;
                            endif;
                        endif;?>
                        <!-- Первый шаг -->

                        <?php if( is_object($request_data) && $request_data->eq_editable === false ):?>
                            <div class="requests-step__form--title"><b>Выбранная единица из парка:</b> <?php echo $request_data->eq_model;?> <?php echo $request_data->eq_brand_name;?></div>
                        <?php elseif( is_object($request_data) && $request_data->eq_editable === true):?>
                            <div class="requests-step__form--title"><b>Изменить описание единицы техники</b></div>
                        <?php else:?>
                            <div class="requests-step__form--title"><b>Опишите технику</b> <?php if ($equipment && !$request_data):?><i class="is-grey-text">или <a href="#requests__choose-eq" class="is-or-link fancybox"><span>Выберите существующую единицу из парка</span></a></i><?php endif;?></div>
                        <?php endif;?>

                        <!--  -->
                        <?php if ( $brands ):?>
                            <label for="" class="req__line-label"><span>Производитель</span>
                                <select id="eq__brand" name="brand" <?php if(is_object($request_data) && $request_data->eq_brand):?>class="eq__val select-box" <?php else:?>class="eq__val select-box is-placeholder"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_brand != 0):?>disabled<?php endif;?> required="">
                                    <option value="">Выберите производителя</option>
                                    <?php foreach ( $brands as $brand ):?>
                                        <option value="<?php echo $brand->id;?>" <?php if( is_object($request_data) && $request_data->eq_brand && $request_data->eq_brand == $brand->id):?>selected<?php endif;?>>
                                            <?php echo $brand->value;?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </label>
                        <?php endif;?>

                        <!--  -->
                        <?php if ( $equipment_appointment ):?>
                        <label for="" class="req__line-label "><span>Назначение</span>
                            <select id="eq__type" name="appointment" <?php if(is_object($request_data) && $request_data->eq_appointment):?>class="eq__val select-box" <?php else:?>class="eq__val select-box is-placeholder"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_appointment != 0):?>disabled<?php endif;?> required="">
                                <option value="">Выберите назначение</option>
                                <?php foreach ( $equipment_appointment as $eq_app ):?>
                                    <option value="<?php echo $eq_app->id;?>" <?php if( is_object($request_data) && $request_data->eq_appointment && $request_data->eq_appointment == $eq_app->id):?>selected<?php endif;?>>
                                        <?php echo $eq_app->value;?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </label>
                        <?php endif;?>

                        <!--  -->
                        <label for="" class="req__line-label"><span>Модель</span>
                            <input type="text" name="model" class="req__input eq__val" id="eq__model" placeholder="В соответствии с техпаспортом" <?php if(is_object($request_data) && $request_data->eq_model):?>value="<?php echo $request_data->eq_model;?>"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_model != ''):?>disabled<?php endif;?>>
                        </label>

                        <!--  -->
                        <label for="" class="req__line-label"><span>Серийный номер</span>
                            <input type="text" name="serial_number" class="eq__val req__input" id="eq__sn" placeholder="SN" <?php if(is_object($request_data) && $request_data->eq_serial_number):?>value="<?php echo $request_data->eq_serial_number;?>"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_serial_number != ''):?>disabled<?php endif;?>>
                        </label>

                        <!--  -->
                        <label for="" class="req__line-label"><span>Двигатель</span>
                            <input type="text" name="engine" class="req__input eq__val" id="eq__motor" placeholder="Код" <?php if(is_object($request_data) && $request_data->eq_engine):?>value="<?php echo $request_data->eq_engine;?>"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_engine != ''):?>disabled<?php endif;?>>
                        </label>

                        <!--  -->
                        <label for="" class="req__line-label"><span>Год выпуска</span>
                            <input type="text" name="year" id="eq__year" class="req__input eq__val" placeholder="ГГГГ" pattern="[0-9]{4}" min="1700" max="2100" required="" <?php if(is_object($request_data) && $request_data->eq_year):?>value="<?php echo $request_data->eq_year;?>"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_year != ''):?>disabled<?php endif;?>>
                        </label>

                        <!--  -->
                        <label for="" class="req__line-label"><span>Подразделение</span>
                            <input type="text" name="section" class="req__input eq__val" id="eq__unit" placeholder="Например, автобаза №15" <?php if(is_object($request_data) && $request_data->eq_section):?>value="<?php echo $request_data->eq_section;?>"<?php endif;?> <?php if(is_object($request_data) && $request_data->eq_editable != true && $request_data->eq_section != ''):?>disabled<?php endif;?>>
                        </label>

                        <?php if( $request_data && is_array( $request_data->eq_images ) && count( $request_data->eq_images ) >= 1 ):?>
                            <ul id="filelist_equipment" class="clear">
                                <?php foreach ($request_data->eq_images as $img):?>
                                    <li>
                                        <img src="/uploads/equipment/<?php echo $request_data->eq_id;?>/158x158_<?php echo $img;?>">
                                    </li>
                                <?php
                                break;
                                endforeach;?>
                            </ul>
                        <?php endif;?>

                        <?php if( !$request_data ):?>
                            <div class="requests-step__center">
                                <!--  -->
                                <!-- загрузка фото -->
                                <div class="center">
                                    <input type="file" accept="image/*" name="images" id="fileElem" multiple  style="display:none" onchange="handleFiles(this.files);">
                                    <a href="#" id="fileSelect" class="is-blue-link add-requests__label" onClick="uploadImg(event);">
                                        <i class="fa fa-paperclip i-left-20"></i>
                                        <span>Прикрепить фото</span>
                                    </a>
                                </div>
                                <ul id="filelist_equipment" class="clear"></ul>
                                <!--  -->

                                <div class="my-pers-profile__show">
                                    <input type="checkbox" name="show_in_park" class="show__checkbox" id="add-to-park" checked>
                                    <label class="show__label-c" for="add-to-park">Добавить в парк</label>
                                </div>
                            </div>
                        <?php endif;?>

                    </form>
                    <a class="js__request_add_form_submit pointer requests__next-step is-last-item btn-primary2 btn ripple-effect">Продолжить</a>
                </div>
                <!--  end Блок с формой  -->
            </div>

            <div class="page-content-form__right">


                <!--  Вспомогательный блок  -->
                <div class="request-lvl__block is-mtop-30 is-rounded is-box-shadow">
                    Уровень заполненности
                    <div class="request-lvl__slider">
                        <div class="counter round-counter" id="counter-form-fill">
                            <div class="rs-handle"></div>
                        </div>
                    </div>

                    <span id="request-lvl__descr" class="is-or-text is-mtop-10 lvl-descr__first">Очень низкий</span>
                    <span id="request-lvl__long_descr" class="is-grey-text is-mtop-20">К сожалению, заявки такого уровня содержания часто остаются без ответа, из-за трудности их обработки. Добавьте подробностей</span>
                </div>
            </div>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

        <?php
            if ($equipment):
                $this->load->view('desktop//requests/page__modal__equipment');
            endif;
        ?>
        <!-- end Выбрать технику -->
    </div>
</main>

<!--  Подверждение  -->
<div id="req__remove" class="modal__block is-rounded">
    <div class="modal__head modal__head--blue is-first-item">
        <div class="modal__title">Начать заново</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>

    <div class="modal__content">
        <h2>Начать создание заявки с первого этапа?</h2>
        <p>Вы действительно хотите начать все сначала?</p>
        <div class="confirm__block">
            <a class="js__request__remove pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded" <?php if(is_object($request_data)):?>data-request-id="<?php echo $request_data->id;?>"<?php endif;?>>
                <i class="fas fa-check"></i>
                <span>Да, начать</span>
            </a>

            <a class="modal__close-btn pointer confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                <i class="fas fa-times"></i>
                <span>Нет, оставить</span>
            </a>
        </div>
    </div>
</div>
<!-- end Подверждение -->

<script>

    function uploadImg(event) {
        event.preventDefault();
        $("#fileElem").removeClass("active");
        $("#filelist_equipment").removeClass("active");
        $(event.target).closest("form").find("#fileElem").addClass("active");
        $(event.target).closest("form").find("#filelist_equipment").addClass("active");
        $(event.target).closest("form").find("#fileElem").click();
        return false;
    }


    function handleFiles(files) {

        var list = $("#filelist_equipment.active");
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

                reader.onload = (function(f) {
                    return function(e) {
                        var li = $("<li></li>");
                        $(list).prepend(li);
                        $(li).append("<input type='hidden' name='images[]' value='" + e.target.result + "' >" );
                        $(li).append("<img src='"+ e.target.result +"'/>");
                        $(li).append("<a href='#' class='remove'></a>");
                        $(li).append("<a href='#' class='edit'></a>");

                        $('.eq__val').trigger('change');
                    };
                })(f);
                reader.readAsDataURL(f);

            }
        }
    }

    $(document).ready( function () {
        $('.eq__val').trigger('change');

        $("body").on("click", "a.remove", function (del) {
            del.preventDefault();
            $(this).parent('li').remove();

            if( $('#filelist_equipment > li').length == 0 ){
                $('#fileElem_equipment').val('');
                $('.eq__val').trigger('change');
            }

        });
    });

</script>
<?php
    $this->load->view('desktop/requests/js/add_choose_equipment');
    $this->load->view('desktop/requests/js/add_start_again');
