<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.10.16
 * Time: 15:08
 */

?>

<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>


<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php
                $this->load->view('desktop/user/menu_user', $menu);
            ?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <!-- Контент -->
        <section class="page-content-form left-400">

            <form action="" method="post" class="fill-com-form" enctype="multipart/form-data">

                <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                <input type="hidden" name="director" value="<?php echo $user->id;?>">
                <input type="hidden" name="action" value="update_company">
                <input type="hidden" name="company_id" value="<?php echo $company->id;?>">

                <div class="page-content-form__left">
                    <!--  Блок Анкета  -->
                        <!--  Блок c формой анкеты  -->
                        <div class="my-pers-profile__block is-rounded is-box-shadow">

                            <!-- Контактная информация -->
                            <b class="my-pers-profile__form--title">Информация о компании</b>

                            <label for="" class="my-company-profile__line-label"><span>Название</span>
                                <textarea class="my-company-profile__ta--mid" id="" maxlength="200" placeholder="Полное название" disabled><?php echo $company->full_name; ?></textarea>
                            </label>

                            <!--  -->
                            <label for="" class="my-company-profile__line-label my-company-profile__chk"><span>Профиль</span>
                                <div class="my-pers-profile__input">
                                    <div class="">
                                        <input type="checkbox" class="show__checkbox" id="com-type-1" name="company_sell" value="sell" <?php if ($company->type == 'sell' || $company->type == 'all'):?>checked<?php endif;?>>
                                        <label class="show__label-c" for="com-type-1">Торгующая компания</label>
                                    </div>

                                    <div class="">
                                        <input type="checkbox" class="show__checkbox" id="com-type-2" name="company_buy" value="buy" <?php if ($company->type == 'buy' || $company->type == 'all'):?>checked<?php endif;?>>
                                        <label class="show__label-c" for="com-type-2">Покупающая компания</label>
                                    </div>
                                </div>
                            </label>

                            <div class="my-company-profile__line-label is-mtop-10">
                                <span>Производители<br>реализуемой техники</span>

                                <div class="my-company-profile__input check-group__block">
                                    <select id="js__select__brand_tags" name="brand[]" multiple class="demo-default" placeholder="Выберите производителей">
                                        <?php foreach($brands as $brand):?>
                                            <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"  <?php echo ( is_array($company->brands) && array_key_exists($brand->id, $company->brands) )? 'selected' :'';?>><?php echo $brand->value;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div style="clear: both"></div>


                            </div>




                            <?php if( $candidats ):?>
                                <b class="my-pers-profile__form--title js__company__page_edit__candidats__title">
                                    Заявки на присоединение к компании
                                </b>
                                <div class="is-mbtm-30 js__company__page_edit__candidats__list">
                                    <?php foreach ($candidats as $candidat):
                                        $this->load->view('desktop/company/loop__candidats', $candidat);
                                    endforeach; ?>
                                </div>
                            <?php endif;?>


                            <!-- Контактная информация -->
                            <b class="my-pers-profile__form--title">
                                Сотрудники компании
                            </b>

                            <div class="ajax__employers_list__page_edit">

                                <?php if( $employers ):
                                    foreach ($employers as $employer):
                                        $this->load->view('desktop/company/loop__employers', $employer);
                                    endforeach;
                                endif;?>
                            </div>


                            <!-- Контактная информация -->
                            <b class="my-pers-profile__form--title">Контактные данные компании</b>

                            <label for="" class="my-company-profile__line-label prop"><span>Телефон<sup>*</sup></span>
                                <input type="text" class="my-company-profile__input phone-mask-with-code" id="" name="phone" value="<?php echo $company->phone;?>" placeholder="Укажите общий для компании номер" >
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span>E-mail</span>
                                <input type="email" class="my-company-profile__input" id="" name="email" value="<?php echo $company->email;?>" placeholder="Будет виден всем посетителям профиля компании">
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span>Сайт</span>
                                <input type="text" class="my-company-profile__input" id="" name="site" value="<?php echo $company->site;?>" placeholder="Например, www.dsu-15.su">
                            </label>

                            <!-- Реквизиты -->
                            <b class="my-pers-profile__form--title-sm">Реквизиты организации</b>

                            <label for="" class="my-company-profile__line-label prop"><span>ИНН<sup>*</sup></span>
                                <input type="text" class="my-company-profile__input" id="" placeholder="123 456 789" pattern="[0-9]" value="<?php echo $company->inn; ?>" disabled>

                            </label>
                            <!--  -->
                            <?php if( $company->type === 'LEGAL'):?>
                                <label for="" class="my-company-profile__line-label prop"><span>КПП<sup>*</sup></span>
                                    <input type="text" class="my-company-profile__input" id="" placeholder="123 456 789" pattern="[0-9]" value="<?php echo $company->kpp; ?>" disabled>
                                </label>
                            <?php endif;?>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span>ОГРН<sup>*</sup></span>
                                <input type="text" class="my-company-profile__input" id="" placeholder="13 цифр" pattern="[0-9]" value="<?php echo $company->ogrn; ?>" disabled>
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span>Расчетный счет<sup>*</sup></span>
                                <input type="text" class="my-company-profile__input" id="" placeholder="20 цифр для РФ" name="r_account"  pattern="[0-9]{20}"  value="<?php echo $company->r_account;?>">
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label my-company-profile__line-label-overflow-visible prop"><span>БИК банка<sup>*</sup></span>
                                <input type="text" class="my-company-profile__input" id="dadata_input_field__bik" placeholder="9 цифр для РФ" name="bank_bik" value="<?php echo $company->bank_bik;?>" >
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop js-bic-select-success"><span>Название банка<sup>*</sup></span>
                                <input type="text"  class="my-company-profile__input input-company-bank-name"  placeholder="Определяется по БИК автоматически" value="<?php echo $company->bank_name;?>" disabled>
                                <input type="hidden"  class="input-company-bank-name" name="bank_name" value="<?php echo $company->bank_name;?>">
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop js-bic-select-success"><span>Корр. счет<sup>*</sup></span>
                                <input type="text" class="my-company-profile__input input-company-koor" placeholder="20 цифр для РФ" pattern="[0-9]" value="<?php echo $company->k_account;?>" disabled>
                                <input type="hidden"  class="input-company-koor" name="k_account" value="">
                            </label>
                            <!--  -->

                            <?php if( $company->type === 'LEGAL'):?>
                                <label for="advpost__ta-posttext" class="my-company-profile__line-label prop clear"><span>Юридический адрес</span>
                                    <textarea id="input-u-address" class="my-company-profile__ta--mid" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" disabled><?php echo $company->u_address; ?></textarea>
                                </label>
                                <!--  -->
                                <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-5">Фактический адрес</span>
                                    <textarea id="input-f-address" class="my-company-profile__ta--mid" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" name="f_address"><?php echo $company->f_address; ?></textarea>
                                    <div style="clear: both"></div>
                                </label>
                                <!--  -->
                                <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-5">Почтовый адрес</span>
                                    <textarea id="input-p-address" class="my-company-profile__ta--mid" placeholder="Индекс, Страна, Город, Улица, Дом, Офис" name="p_address"><?php echo $company->p_address; ?></textarea>
                                    <div style="clear: both"></div>
                                </label>
                            <?php endif;?>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Ф.И.О руководителя<sup>*</sup></span>
                                <input type="text" class="my-pers-profile__input" id="" placeholder="Фамилия Имя Отчество (полностью)"  value="<?php echo $company->manager; ?>" disabled>
                            </label>
                            <!--  -->
                            <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Должность<sup>*</sup></span>
                                <input type="text" class="my-pers-profile__input" id="" placeholder="Должность руководителя"  value="<?php echo $company->manager_post; ?>" disabled>
                            </label>

                            <div class="hr-grey"></div>

                            <!-- Нижняя часть формы -->

                            <label for="" class="my-company-profile__line-label prop"><span class="is-mtop-2">Город<sup>*</sup></span>
                                <input type="text" class="my-pers-profile__input" id="js-autocomplete-city" placeholder="Населенный пункт" value="<?php echo ( $company->city ) ? $company->city_name : '';?>" >
                                <input type="hidden" id="js-input-city-hidden" name="city" value="<?php echo ( $company->city ) ? $company->city : '';?>">
                            </label>

                            <label for="" class="my-company-profile__line-label"><span>Несколько слов о компании</span>
                                <textarea class="my-company-profile__ta--high" id="" maxlength="2000" name="description" placeholder="Напишите о миссии компании. На странице компании отображаются первые 140 символов. Остальное &mdash; по клику по ссылке «Подробнее»"><?php echo $company->description;?></textarea>
                            </label>

                            <span class="my-pers-profile__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                        <input type="button" id="form-submit-save" class="my-pers-profile__submit is-rounded" value="Сохранить">
                    </span>

                        </div>

                        <!-- -->

                </div>


                <div class="page-content-form__right">




                    <div class="my-pers-profile__photo is-mtop-20 is-rounded" <?php if ($company->logo):?> style="background: url('/uploads/companies/<?php echo $company->id;?>/logo/180_<?php echo $company->logo;?>') no-repeat center center"<?php endif;?>>
                        <div class="my-pers-profile__space"></div>


                        <label for="choose-portrait-img" class="is-blue-link my-pers-profile__helpers helpers-signs">
                            <div class="helpers-signs__content">
                                <?php if (!$company->logo):?>
                                    <div class="helpers-signs__icons">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <span>Изменить лого</span>
                                <?php endif;?>
                            </div>
                        </label>

                        <input type="file" name="avatar" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" class="ajax-upload-avatar-profile" id="choose-portrait-img">

                        <div class="is-mtop-20">
                            <a class="is-or-link pointer js__remove_logo <?php if( !$company->logo ):?>is-hidden<?php endif;?>" data-action="remove_logo" data-company_id="<?php echo $company->id;?>"><span>Удалить лого</span></a>
                        </div>



                    </div>



                </div>

            </form>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

    </div>
</main>

<?php

    $this->load->view('desktop/company/modal__add_employer');
    $this->load->view('desktop/company/modal__no_employer');
    $this->load->view('desktop/company/modal__remove_employer');

    $this->load->view('desktop/company/mustache_template__new_employer');
    $this->load->view('desktop/company/mustache_template__new_employer__edit_page');

    $this->load->view('desktop/company/js__scripts');

    $this->load->view('desktop/company/js/modal__add_employer');
    $this->load->view('desktop/company/js/modal__no_employer');
    $this->load->view('desktop/company/js/modal__remove_employer');

    $this->load->view('desktop/company/js/logo_uploader');
    $this->load->view('desktop/profile/js/company_validation');