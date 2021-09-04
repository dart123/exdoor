<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.08.16
 * Time: 22:47
 */
?>


    <div class="preloader preloader__show">
        <img src="/assets/img/preload.gif" alt="" class="preloader__img preloader__show">
    </div>

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
        <section class="page-content-form wide left-200">
            <div class="sub-menu is-mright-200">
                <ul class="sub-menu__list">
                    <li><a href="/profile" class="is-fade">Анкета</a></li>
                    <li><a href="/profile/company" class="active is-fade">Моя компания</a></li>
                    <li><a href="/profile/security" class="is-fade">Безопасность</a></li>
                    <li><a href="/profile/plan" class="is-fade">Тарифный план</a></li>
                </ul>
            </div>

            <div class="page-content-form__left">
                <!--  Блок Результаты поиска компании  -->
                <div class="my-company-search is-mtop-20">

                    <?php if($company['short_name'] != '' && $company['inn'] != ''):?>
                        <div class="my-company-search__title">

                            По указанному ИНН <b><?php echo $company['inn'];?></b> найдена компания. Однако ее руководитель не зарегистрирован в Exdor

                            <span class="is-grey-text">Только руководитель организации может подтвердить факт того, что Вы являетесь сотрудником этой организации и можете общаться с партнерами от имени компании. До момента его регистрации Вы можете использовать партнерскую сеть Exdor как частное лицо.</span>

                        </div>

                        <!--  Блок c результатами поиска компании  -->
                        <div class="my-company-search__no-dir is-rounded is-box-shadow">
                            <div class="my-company-search__content">
                                <!--  -->
                                <div class="my-company-search__row">
                                    <div class="company__image is-rounded">

                                    </div>
                                    <div class="my-partners__content">
                                        <div class="my-partners__name is-blue-text"><b><?php echo $company['short_name'];?></b></div>
                                        <div class="my-partners__company-name is-grey-text">Нет информации о компании</div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="my-company-search__row">
                                    <div class="my-partners__image is-rounded">

                                    </div>
                                    <div class="my-partners__content">
                                        <span class="my-partners__name is-grey-text">Руководитель не зарегистрирован в Exdor</span>

                                        <div class="my-company-search__send-btn--wrap">
                                            <a href="#send-mail" class="my-company-search__send-btn or-btn btn btn-info ripple-effect fancybox">
                                                <i class="fas fa-envelope i-left-15"></i>
                                                Пригласить руководителя
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                            </div>

                        </div>
                        <!-- -->

                        <!-- Текст под результатами -->
                        <div class="my-company-search__notes">
                            <span class="is-grey-text">Если это не та организация, что Вы искали, попробуйте одно из следующих действий:</span>
                            <a href="/profile/company?change_inn=true" class="is-or-link"><span>Изменить ИНН</span></a>
                            <a href="#report" class="is-blue-link fancybox"><span>Сообщить об ошибке</span></a>
                        </div>
                        <!-- -->
                    <?php else:?>
                        <div class="my-company-search__title">

                            По указанному ИНН компания не найдена.

                        </div>

                        <!-- Текст под результатами -->
                        <div class="my-company-search__notes">
                            <span class="is-grey-text">Попробуйте одно из следующих действий:</span>
                            <a href="/profile/company?change_inn=true" class="is-or-link"><span>Изменить ИНН</span></a>
                            <a href="#report" class="is-blue-link fancybox"><span>Сообщить об ошибке</span></a>
                        </div>
                    <?php endif;?>

                </div>
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

        <?php
            $this->load->view('desktop/profile/modal__company__invite_director');
            $this->load->view('desktop/misc/modal__bug_report');
        ?>
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
    $this->load->view('desktop/profile/js/company_invite_director');
    $this->load->view('desktop/misc/js/bug_report');
?>