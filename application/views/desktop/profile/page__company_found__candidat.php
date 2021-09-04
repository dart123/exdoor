<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-04
 * Time: 14:56
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

                    <div class="my-company-search__title--high">
                        Вы объявили себя сотрудником компании <a href="/company/id<?php echo $company->id;?>" target="_blank" class="is-blue-link"><span><?php echo $company->short_name;?></span></a>. <br>Мы ожидаем подтверждения этой информации от руководителя компании.
                    </div>

                    <!--  Блок c результатами поиска компании  -->
                    <div class="my-company-search__treatment is-rounded is-box-shadow">
                        <div class="my-company-search__content">


                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <?php if($company_manager->avatar):?>
                                        <a href="/company/id<?php echo $company->id;?>" class="my-partners__image my-partners__image--image_exists is-rounded">
                                            <img src="/uploads/users/<?php echo $company_manager->id;?>/avatar/180x180_<?php echo $company_manager->avatar;?>" style="width: 100%; height: auto;">
                                        </a>
                                    <?php else:?>
                                        <a href="/company/id<?php echo $company->id;?>" class="my-partners__image is-rounded">

                                        </a>
                                    <?php endif;?>
                                    <div class="my-partners__content">
                                        <a href="/partners/<?php echo $company_manager->id;?>" class="my-partners__name is-blue-link"><span><b><?php echo $company_manager->last_name;?> <?php echo $company_manager->name;?> <?php echo $company_manager->second_name;?></b></span></a>
                                        <div><a href="" class="my-partners__company-name is-grey-link"><span><?php echo $company->manager_post;?> (<?php echo $company->short_name;?>)</span></a></div>
                                        <?php if( $company->rating ):?>
                                            <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $company->rating;?>"></div>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div>
                                        <a href="#" class="is-or-link send-remind">
                                            <i class="fa fa-bell i-left-15"></i>
                                            <span>Напомнить о заявке</span>
                                        </a>
                                        <span href="#" class="is-grey-text is-long-row is-hidden">
                                            <i class="far fa-clock i-left-15"></i>
                                            <span>Напоминание отправлено</span>
                                        </span>
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

                    <!-- -->
                </div>
            </div>





            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

        <?php $this->load->view('desktop/misc/modal__bug_report');?>
    </div>
</main>

<?php $this->load->view('desktop/misc/js/bug_report'); ?>