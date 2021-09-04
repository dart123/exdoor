<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 22/10/2018
 * Time: 11:55
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
        <div class="header__page-title t-hide">
            <?php if( $page_header["search_or_link"]['type'] == 'link' ):?>
                <a href="<?php echo $page_header["search_or_link"]['url'];?>" class="js--header__go-back   header__go-back is-white-link">
                    <i class="fa fa-caret-left"></i> <span>Назад</span>
                </a>
            <?php else:?>
                Моя компания
            <?php endif;?>
        </div>

        <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>

    </div>
</header>

<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>


<div class="content">






    <form action="" method="post" class="fill-com-form" enctype="multipart/form-data">





<?php /*

        <div class="page-content-form__right">




            <div class="my-pers-profile__photo is-mtop-20 is-rounded   company__edit__logo" <?php if ($page_content["company"]->logo):?> style="background: url('/uploads/companies/<?php echo $page_content["company"]->id;?>/logo/180_<?php echo $page_content["company"]->logo;?>') no-repeat center center"<?php endif;?>>
                <div class="my-pers-profile__space"></div>


                <label for="choose-portrait-img" class="is-blue-link my-pers-profile__helpers helpers-signs">
                    <div class="helpers-signs__content">
                        <?php if (!$page_content["company"]->logo):?>
                            <div class="helpers-signs__icons">
                                <i class="fa fa-user"></i>
                            </div>
                            <span>Изменить лого</span>
                        <?php endif;?>
                    </div>
                </label>

                <input type="file" name="avatar" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" class="ajax-upload-avatar-profile" id="choose-portrait-img">

                <div class="is-mtop-20">
                    <a class="is-or-link pointer js__remove_logo <?php if( !$page_content["company"]->logo ):?>is-hidden<?php endif;?>" data-action="remove_logo" data-company_id="<?php echo $page_content["company"]->id;?>"><span>Удалить лого</span></a>
                </div>



            </div>



        </div>



*/ ?>





        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
        <input type="hidden" name="director" value="<?php echo $page_content["user"]->id;?>">
        <input type="hidden" name="action" value="update_company">
        <input type="hidden" name="company_id" value="<?php echo $page_content["company"]->id;?>">

        <div class="page-content-form__left">
            <!--  Блок Анкета  -->
            <!--  Блок c формой анкеты  -->
            <div class="my-pers-profile__block is-rounded is-box-shadow">

                <!-- Контактная информация -->
                <b class="my-pers-profile__form--title"><?php echo $page_content["company"]->full_name; ?></b>

                <!--  -->
                <label for="" class="my-company-profile__line-label my-company-profile__chk"><span>Профиль</span>
                    <div class="my-pers-profile__input">
                        <div class="">
                            <input type="checkbox" class="show__checkbox" id="com-type-1" name="company_sell" value="sell" <?php if ($page_content["company"]->type == 'sell' || $page_content["company"]->type == 'all'):?>checked<?php endif;?>>
                            <label class="show__label-c" for="com-type-1">Торгующая компания</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="show__checkbox" id="com-type-2" name="company_buy" value="buy" <?php if ($page_content["company"]->type == 'buy' || $page_content["company"]->type == 'all'):?>checked<?php endif;?>>
                            <label class="show__label-c" for="com-type-2">Покупающая компания</label>
                        </div>
                    </div>
                </label>

                <div class="my-company-profile__line-label is-mtop-10">
                    <span>Производители</span>

                    <div class="my-company-profile__input check-group__block">
                        <select id="js__select__brand_tags" name="brand[]" multiple class="demo-default" placeholder="Выберите производителей">
                            <?php foreach($page_content["brands"] as $brand):?>
                                <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"  <?php echo ( is_array($page_content["company"]->brands) && array_key_exists($brand->id, $page_content["company"]->brands) )? 'selected' :'';?>><?php echo $brand->value;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div style="clear: both"></div>


                </div>




                <?php if( $page_content["candidats"] ):?>
                    <b class="my-pers-profile__form--title-sm">
                        Заявки на присоединение к компании
                    </b>
                    <div class="is-mbtm-30 js__company__page_edit__candidats__list">
                        <?php foreach ($page_content["candidats"] as $candidat):
                            $this->load->view('mobile/company/loop__candidats', $candidat);
                        endforeach; ?>
                    </div>
                <?php endif;?>


                <!-- Контактная информация -->
                <b class="my-pers-profile__form--title-sm">
                    Сотрудники компании
                </b>

                <div class="ajax__employers_list__page_edit is-mtop-10">

                    <?php if( $page_content["employers"] ):
                        foreach ($page_content["employers"] as $employer):
                            $this->load->view('mobile/company/loop__employers', $employer);
                        endforeach;
                    endif;?>
                </div>

                <!-- Контактная информация -->

                <b class="my-pers-profile__form--title-sm">Контактные данные компании</b>



                <label for="" class="my-company-profile__line-label prop"><span>Телефон<sup>*</sup></span>
                    <input type="tel" class="my-company-profile__input phone-mask input__type-text" id="" name="phone" value="<?php echo $page_content["company"]->phone;?>" placeholder="Укажите общий для компании номер" >
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop"><span>E-mail</span>
                    <input type="email" class="my-company-profile__input input__type-text" id="" name="email" value="<?php echo $page_content["company"]->email;?>" placeholder="Будет виден всем посетителям профиля компании">
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop"><span>Сайт</span>
                    <input type="text" class="my-company-profile__input input__type-text" id="" name="site" value="<?php echo $page_content["company"]->site;?>" placeholder="Например, www.dsu-15.su">
                </label>

                <!-- Реквизиты -->
                <b class="my-pers-profile__form--title-sm">Реквизиты организации</b>

                <label for="" class="my-company-profile__line-label prop"><span>ИНН<sup>*</sup></span>
                    <input type="text" class="my-company-profile__input input__type-text" id="" placeholder="123 456 789" pattern="[0-9]" value="<?php echo $page_content["company"]->inn; ?>" disabled>

                </label>
                <!--  -->
                <?php if( $page_content["company"]->type === 'LEGAL'):?>
                    <label for="" class="my-company-profile__line-label prop"><span>КПП<sup>*</sup></span>
                        <input type="text" class="my-company-profile__input input__type-text" id="" placeholder="123 456 789" pattern="[0-9]" value="<?php echo $page_content["company"]->kpp; ?>" disabled>
                    </label>
                <?php endif;?>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop"><span>ОГРН<sup>*</sup></span>
                    <input type="text" class="my-company-profile__input input__type-text" id="" placeholder="13 цифр" pattern="[0-9]" value="<?php echo $page_content["company"]->ogrn; ?>" disabled>
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop"><span>Расчетный счет<sup>*</sup></span>
                    <input type="text" class="my-company-profile__input input__type-text" id="" placeholder="20 цифр для РФ" name="r_account"  pattern="[0-9]{20}"  value="<?php echo $page_content["company"]->r_account;?>">
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label my-company-profile__line-label-overflow-visible prop"><span>БИК банка<sup>*</sup></span>
                    <input type="text" class="my-company-profile__input input__type-text" id="dadata_input_field__bik" placeholder="9 цифр для РФ" name="bank_bik" value="<?php echo $page_content["company"]->bank_bik;?>" >
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop js-bic-select-success"><span>Название банка<sup>*</sup></span>
                    <input type="text"  class="my-company-profile__input input-company-bank-name input__type-text"  placeholder="Определяется по БИК автоматически" value="<?php echo $page_content["company"]->bank_name;?>" disabled>
                    <input type="hidden"  class="input-company-bank-name" name="bank_name" value="<?php echo $page_content["company"]->bank_name;?>">
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop js-bic-select-success"><span>Корр. счет<sup>*</sup></span>
                    <input type="text" class="my-company-profile__input input-company-koor input__type-text" placeholder="20 цифр для РФ" pattern="[0-9]" value="<?php echo $page_content["company"]->k_account;?>" disabled>
                    <input type="hidden"  class="input-company-koor" name="k_account" value="">
                </label>
                <!--  -->

                <?php if( $page_content["company"]->type === 'LEGAL'):?>
                    <label for="advpost__ta-posttext" class="my-company-profile__line-label prop clear"><span>Юридический адрес</span>
                        <textarea id="input-u-address" class="my-company-profile__ta--mid input__type-text" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" disabled><?php echo $page_content["company"]->u_address; ?></textarea>
                    </label>
                    <!--  -->
                    <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-5">Фактический адрес</span>
                        <textarea id="input-f-address" class="my-company-profile__ta--mid input__type-text" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" name="f_address"><?php echo $page_content["company"]->f_address; ?></textarea>
                        <div style="clear: both"></div>
                    </label>
                    <!--  -->
                    <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-5">Почтовый адрес</span>
                        <textarea id="input-p-address" class="my-company-profile__ta--mid input__type-text" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" name="p_address"><?php echo $page_content["company"]->p_address; ?></textarea>
                        <div style="clear: both"></div>
                    </label>
                <?php endif;?>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Руководитель<sup>*</sup></span>
                    <input type="text" class="my-pers-profile__input input__type-text" id="" placeholder="Фамилия Имя Отчество (полностью)"  value="<?php echo $page_content["company"]->manager; ?>" disabled>
                </label>
                <!--  -->
                <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Должность<sup>*</sup></span>
                    <input type="text" class="my-pers-profile__input input__type-text" id="" placeholder="Должность руководителя"  value="<?php echo $page_content["company"]->manager_post; ?>" disabled>
                </label>

                <div class="hr-grey"></div>

                <!-- Нижняя часть формы -->

                <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Город<sup>*</sup></span>
                    <input type="text" class="my-pers-profile__input input__type-text" id="js-autocomplete-city" placeholder="Населенный пункт" value="<?php echo ( $page_content["company"]->city ) ? $page_content["company"]->city_name : '';?>" >
                    <input type="hidden" id="js-input-city-hidden" name="city" value="<?php echo ( $page_content["company"]->city ) ? $page_content["company"]->city : '';?>">
                </label>

                <label for="" class="my-company-profile__line-label"><span>О компании</span>
                    <textarea class="my-company-profile__ta--high input__type-text" id="" maxlength="2000" name="description" placeholder="Напишите о миссии компании. На странице компании отображаются первые 140 символов. Остальное &mdash; по клику по ссылке «Подробнее»"><?php echo $page_content["company"]->description;?></textarea>
                </label>

                <div class="clear"></div>


                <span class="is-mtop-20 my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                        <input type="button" id="form-submit-save" class="button button__default my-pers-profile__submit is-rounded" value="Сохранить">
                    </span>

            </div>

            <!-- -->

        </div>


    </form>









</div>




<?php

    $this->load->view('mobile/company/modal__add_employer');
    $this->load->view('mobile/company/modal__no_employer');
    $this->load->view('mobile/company/modal__remove_employer');

    $this->load->view('mobile/company/mustache_template__new_employer');
    $this->load->view('mobile/company/mustache_template__new_employer__edit_page');

    $this->load->view('mobile/company/js__scripts');

    $this->load->view('mobile/company/js/modal__add_employer');
    $this->load->view('mobile/company/js/modal__no_employer');
    $this->load->view('mobile/company/js/modal__remove_employer');

    $this->load->view('mobile/company/js/logo_uploader');
    $this->load->view('mobile/profile/js/company_validation');