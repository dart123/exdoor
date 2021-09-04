<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.07.16
 * Time: 20:02
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
            <div class="sub-menu is-mright-200">
                <ul class="sub-menu__list">
                    <li><a href="/profile" class="is-fade">Анкета</a></li>
                    <li><a class="active is-fade">Моя компания</a></li>
                    <li><a href="/profile/security" class="is-fade">Безопасность</a></li>
                    <li><a href="/profile/plan" class="is-fade">Тарифный план</a></li>
                </ul>
            </div>

            <div class="page-content-form__left">
                <!--  Блок Анкета  -->
                <div class="is-mtop-20">
                    <!--  Блок c формой первого шага заполнения Профиля компании  -->
                    <div class="my-company-profile__block is-rounded is-box-shadow">
                        <form action="/profile/add_company" id="profile__company__form__add_company" method="POST">

                            <input type="hidden" name="action" value="add_company_step_1">

                            <input id="input-company-fullname" name="full_name" type="hidden">
                            <input id="input-company-shortname" name="short_name" type="hidden">
                            <input id="input-company-inn" name="inn" type="hidden">
                            <input id="input-company-kpp" name="kpp" type="hidden">
                            <input id="input-company-ogrn" name="ogrn" type="hidden">
                            <input id="input-company-address" name="address" type="hidden">
                            <input id="input-company-manager" name="manager" type="hidden">
                            <input id="input-company-manager-post" name="manager_post" type="hidden">
                            <input id="input-company-type" name="company_type" type="hidden">

                            <input name="user_id" type="hidden" value="<?php echo $user->id;?>">


                            <label for="dadata_input_field__inn" class="my-company-profile__line-label " style="overflow: visible"><span>Выберите организацию</span>
                                <input type="text" class="my-company-profile__input" id="dadata_input_field__inn" placeholder="Подсмотрите в шапке официального документа компании">
                            </label>
                            <!--  -->
                            <div class="my-company-radio--line">Ваша роль в компании
                                <div class="my-company-radio--cover">
                                    <input type="radio" class="radio" name="my-company-role" id="im-employee" value="worker" checked>
                                    <label class="radio__label" for="im-employee">Я &mdash; сотрудник</label>

                                    <input type="radio" class="radio" name="my-company-role" id="im-director" value="manager">
                                    <label class="radio__label" for="im-director">Я &mdash; руководитель</label>
                                    <!--
                                    <div class="tooltip">
                                        <i class="fa fa-question"></i>
                                        <div class="tooltip__msg is-rounded is-box-shadow is-fade">Подсказка с текстом, описывающая информацию, которая полезна будет для заполнения поля.</div>
                                    </div>
                                    -->
                                </div>
                            </div>
                            <div class="block__footer">
                                <button type="submit" class="my-company-profile__submit is-last-item btn-primary2 btn ripple-effect" disabled>Продолжить</button>
                            </div>
                        </form>
                    </div>
                    <!-- -->
                </div>
            </div>
            <div class="page-content-form__right">
                <!-- Блок уведомлением -->
                <div class="my-company-profile__photo is-mtop-20 material-block-show is-rounded">
                    <div class="my-company-profile__helpers">
                        <div class="helpers-signs__content">
                            <i class="fa fa-street-view"></i>
                            <span>В данный момент Вы зарегистрированы как частное лицо. Начните действовать от имени компании!</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->
    </div>
</main>


<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
    $this->load->view('desktop/profile/js/functions');
    $this->load->view('desktop/profile/js__scripts');
?>
