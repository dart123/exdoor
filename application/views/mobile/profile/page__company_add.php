<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.08.16
 * Time: 14:34
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
            <div class="header__page-title t-hide">Профиль</div>
            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
        </div>
    </header>


    <div class="content">
        
        <section class="page-content-form left-400">

            <?php $this->load->view('mobile/profile/submenu', array("active" => "company"));?>

            <form action="" method="post" class="fill-com-form" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                <input type="hidden" name="action" value="add_company_step_2">
                <input type="hidden" name="director" value="<?php echo $page_content["user"]->id;?>">
                <input type="hidden" name="action" value="add_company_step_2">
                <input type="hidden" name="short_name" value="<?php echo htmlspecialchars( $page_content["company"]['short_name'] ); ?>">
                <div class="page-content-form__left">

                    <div class="my-pers-profile__block">
                        <b class="my-pers-profile__form--title">Информация о компании</b>
                        <label for="" class="my-company-profile__line-label"><span>Название</span>
                            <textarea class="input__type-text   my-company-profile__ta--mid" id="" maxlength="200" placeholder="Полное название" disabled><?php echo $page_content["company"]['full_name']; ?></textarea>
                            <input type="hidden" name="full_name" value="<?php echo htmlspecialchars( $page_content["company"]['full_name'] ); ?>">
                        </label>
                        <label for="" class="my-company-profile__line-label my-company-profile__chk"><span>Профиль<sup>*</sup></span>
                            <div class="my-pers-profile__input">
                                <div>
                                    <input type="checkbox" class="show__checkbox" id="com-type-1" name="company_sell" value="sell" >
                                    <label class="add_company__type__sell_label show__label-c" for="com-type-1">Торгующая компания</label>
                                </div>
                                <div>
                                    <input type="checkbox" class="show__checkbox" id="com-type-2" name="company_buy" value="buy" >
                                    <label class="add_company__type__buy_label show__label-c" for="com-type-2">Покупающая компания</label>
                                </div>
                            </div>
                        </label>
                        <div class="my-company-profile__line-label is-mtop-10">
                            <span>Производители<sup>*</sup></span>

                            <div class="my-company-profile__input check-group__block">

                                <select id="js__select__brand_tags" name="brand[]" multiple class="demo-default" placeholder="Выберите производителей...">
                                    <?php foreach($page_content["brands"] as $brand):?>
                                        <?php if( $brand->id != 0 ): /* Не указан */?>
                                            <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"><?php echo $brand->value;?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>

                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <b class="my-pers-profile__form--title">Контактные данные компании</b>
                        <label for="" class="my-company-profile__line-label prop"><span>Телефон<sup>*</sup></span>
                            <input type="tel" class="input__type-text     my-company-profile__input phone-mask" id="" name="phone" placeholder="Укажите общий для компании номер" >
                        </label>
                        <label for="" class="my-company-profile__line-label prop"><span>Email</span>
                            <input type="email" class="input__type-text     my-company-profile__input" id="" name="email" placeholder="Будет виден всем посетителям профиля компании">
                        </label>
                        <label for="" class="my-company-profile__line-label prop"><span>Сайт</span>
                            <input type="text" class="input__type-text     my-company-profile__input" id="" name="site" placeholder="Например, www.dsu-15.su">
                        </label>

                        <!-- Реквизиты -->
                        <b class="my-pers-profile__form--title-sm">Реквизиты организации</b>

                        <label for="" class="my-company-profile__line-label prop"><span>ИНН<sup>*</sup></span>
                            <input type="text" class="input__type-text            my-company-profile__input" id="" placeholder="123 456 789" pattern="[0-9]" value="<?php echo $page_content["company"]['inn']; ?>" disabled>
                            <input type="hidden" name="inn" value="<?php echo $page_content["company"]['inn']; ?>">
                        </label>
                        <!--  -->
                        <?php if( $page_content["company"]['type'] === 'ORGANIZATION'):?>
                        <label for="" class="my-company-profile__line-label prop"><span>КПП<sup>*</sup></span>
                            <input type="text" class="input__type-text            my-company-profile__input" id="" placeholder="123 456 789" pattern="[0-9]" value="<?php echo $page_content["company"]['kpp']; ?>" disabled>
                            <input type="hidden" name="kpp" value="<?php echo $page_content["company"]['kpp']; ?>">
                        </label>
                        <?php endif;?>
                        <!--  -->
                        <label for="" class="my-company-profile__line-label prop"><span>ОГРН<sup>*</sup></span>
                            <input type="text" class="input__type-text       my-company-profile__input" id="" placeholder="13 цифр" pattern="[0-9]" value="<?php echo $page_content["company"]['ogrn']; ?>" disabled>
                            <input type="hidden" name="ogrn" value="<?php echo $page_content["company"]['ogrn']; ?>">
                        </label>
                        <!--  -->
                        <label for="" class="my-company-profile__line-label prop"><span>Расчетный счет</span>
                            <input type="text" class="input__type-text     my-company-profile__input" id="" placeholder="20 цифр для РФ" name="r_account"  value="">
                        </label>
                        <!--  -->
                        <label for="" class="my-company-profile__line-label my-company-profile__line-label-overflow-visible prop"><span>БИК банка</span>
                            <input type="text" class="input__type-text     my-company-profile__input" id="dadata_input_field__bik" placeholder="9 цифр для РФ" name="bank_bik"  >
                        </label>
                        <!--  -->
                        <label for="" class="my-company-profile__line-label prop js-bic-select-success"><span>Название банка</span>
                            <input type="text"  class="input__type-text       my-company-profile__input input-company-bank-name"  placeholder="Определяется по БИК автоматически" disabled>
                            <input type="hidden"  class="input-company-bank-name" name="bank_name" value="">
                        </label>
                        <!--  -->
                        <label for="" class="my-company-profile__line-label prop js-bic-select-success"><span>Корр. счет<sup>*</sup></span>
                            <input type="text" class="input__type-text        my-company-profile__input input-company-koor" placeholder="20 цифр для РФ" pattern="[0-9]" disabled>
                            <input type="hidden"  class="input-company-koor" name="k_account" value="">
                        </label>
                        <!--  -->

                        <?php if( $page_content["company"]['type'] != 'INDIVIDUAL' ):?>

                            <label for="advpost__ta-posttext" class="my-company-profile__line-label prop clear"><span>Юр. адрес</span>
                                <textarea id="input-u-address" class="input__type-text        my-company-profile__ta--mid" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" disabled><?php echo $page_content["company"]['address']; ?></textarea>
                                <input type="hidden" name="u_address" value="<?php echo $page_content["company"]['address']; ?>">
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-5">Факт. адрес</span>
                                <div class="my-company-profile__input">
                                    <input type="checkbox" class="show__checkbox js-f_address-the-same" id="address-01" checked>
                                    <label class="show__label-c" for="address-01">Совпадает с предыдущим</label>
                                </div><br><br>
                                <textarea id="input-f-address" class="input__type-text         my-company-profile__ta--mid" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" name="f_address"><?php echo $page_content["company"]['address']; ?></textarea>
                                <div style="clear: both"></div>
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-5">Почтовый адрес</span>
                                <div class="my-company-profile__input">
                                    <input type="checkbox" class="show__checkbox js-p_address-the-same" id="address-02" checked>
                                    <label class="show__label-c" for="address-02">Совпадает с предыдущим</label>
                                </div><br><br>
                                <textarea id="input-p-address" class="input__type-text            my-company-profile__ta--mid" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" name="p_address"><?php echo $page_content["company"]['address']; ?></textarea>
                                <div style="clear: both"></div>
                            </label>

                        <?php endif;?>

                        <!--  -->
                        <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Руководитель<sup>*</sup></span>
                            <input type="text" class="input__type-text          my-pers-profile__input" id="" placeholder="Фамилия Имя Отчество (полностью)" name="manager" required value="<?php echo $page_content["company"]['manager']; ?>" disabled>
                        </label>
                        <!--  -->
                        <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Должность<sup>*</sup></span>
                            <input type="text" class="input__type-text         my-pers-profile__input" id="" placeholder="Должность руководителя" name="manager_post" required value="<?php echo $page_content["company"]['manager_post']; ?>" disabled>
                        </label>

                        <div class="hr-grey"></div>

                        <!-- Нижняя часть формы -->

                        <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Город<sup>*</sup></span>
                            <input type="text" class="input__type-text        my-pers-profile__input" id="js-autocomplete-city" placeholder="Населенный пункт" value="" >
                            <input type="hidden" id="js-input-city-hidden" name="city" value="">
                        </label>

                        <label for="" class="my-company-profile__line-label"><span>О компании</span>
                            <textarea class="input__type-text         my-company-profile__ta--high" id="" maxlength="2000" name="description" placeholder="Напишите о миссии компании"></textarea>
                        </label>
                        <div class="clear"></div>
                        <br>
                        <div class="text-right">
                            <span class="my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                <input type="button" id="form-submit-save" class="button__default  my-pers-profile__submit is-rounded" value="Сохранить">
                            </span>
                        </div>


                    </div>
                    <div style="padding: 10px;" class="text-center">
                        <a href="/profile/company" class="my-com-profile__notes is-or-link"><i class="fa fa-sign-out i-left-15"></i><span>Я не руководитель этой компании</span></a>
                        <!-- -->
                    </div>

                </div>


                <div class="page-content-form__right" style="display: none">
                    <!-- Блок с загрузкой фото для компании-->
                    <div class="my-pers-profile__photo is-mtop-20 is-rounded">
                        <div class="my-pers-profile__space"></div>
                        <input type="file" name="logo" id="choose-portrait-img">
                        <label for="choose-portrait-img" class="is-blue-link my-pers-profile__helpers helpers-signs" id="choose-portrait-img__place">
                            <div class="helpers-signs__content">
                                <div class="helpers-signs__icons">
                                    <i class="fa fa-home"></i>
                                </div>
                                <span>Добавить логотип</span>
                            </div>
                        </label>
                    </div>
                    <div class="choose-portrait-img-temp"></div>
                    <div style="clear: both"></div>
                    <div class="is-mtop-20">
                        <a class="is-or-link pointer js__remove_logo is-hidden" data-action="remove_logo"><span>Удалить лого</span></a>
                    </div>

                </div>

            </form>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->
    </div>





    <link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
    <!--[if lt IE 10]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
    $this->load->view('mobile/profile/js/functions');
    $this->load->view('mobile/profile/js__scripts');
    $this->load->view('mobile/profile/js/company_add');
    $this->load->view('mobile/profile/js/company_validation');