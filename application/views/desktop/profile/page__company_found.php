<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.08.16
 * Time: 23:13
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

                    <div class="my-company-search__title">
                        По указанному ИНН <b><?php echo $company->inn;?></b> найдена компания
                    </div>

                    <!--  Блок c результатами поиска компании  -->
                    <div class="my-company-search__res is-rounded is-box-shadow">
                        <div class="my-company-search__content">
                            <!--  -->
                            <div class="my-company-search__row">

                                <?php if($company->logo):?>
                                    <a href="/company/id<?php echo $company->id;?>" class="my-partners__image is-rounded">
                                        <img src="/uploads/companies/<?php echo $company->id;?>/logo/180_<?php echo $company->logo;?>" alt="">
                                    </a>
                                <?php else:?>
                                    <a href="/company/id<?php echo $company->id;?>" class="my-partners__image is-rounded">

                                    </a>
                                <?php endif;?>

                                <div class="my-partners__content">
                                    <a href="/company/id<?php echo $company->id;?>" class="my-partners__name is-blue-link"><span><b><?php echo $company->short_name;?></b></span></a>
                                    <div><a href="/company/id<?php echo $company->id;?>" class="my-partners__company-staff is-grey-link"><span>Сотрудников: <?php echo $company->employers_num;?></span></a></div>
                                    <?php if( $company->rating ):?>
                                        <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $company->rating;?>"></div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <!--  -->
                            <div class="my-company-search__row">

                                <?php if($company_manager->avatar):?>
                                    <a href="/partners/<?php echo $company_manager->id;?>" class="my-partners__image my-partners__image--image_exists is-rounded">
                                        <img src="/uploads/users/<?php echo $company_manager->id;?>/avatar/180x180_<?php echo $company_manager->avatar;?>" style="width: 100%; height: auto;">
                                    </a>
                                <?php else:?>
                                    <a href="/company/id<?php echo $company->id;?>" class="my-partners__image is-rounded">

                                    </a>
                                <?php endif;?>

                                <div class="my-partners__content">
                                    <a href="/partners/<?php echo $company_manager->id;?>" class="my-partners__name is-blue-link"><span><b><?php echo $company_manager->name;?> <?php echo $company_manager->second_name;?> <?php echo $company_manager->last_name;?></b></span></a>
                                    <div><a href="/partners/<?php echo $company_manager->id;?>" class="my-partners__company-name is-grey-link"><span><?php echo $company_manager->company_profession;?></span></a></div>
                                    <?php if( $company->rating ):?>
                                        <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $company_manager->rating;?>"></div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <!--  -->
                        </div>

                        <div class="block__footer">
                            <a href="#" class="my-company-search__submit is-last-item btn-primary2 btn ripple-effect      ajax__company_join" data-company-id="<?php echo $company->id;?>">
                                <i class="fa fa-puzzle-piece i-left-20"></i>Запросить присоединение к компании
                            </a>
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

                </div>
            </div>

        </section>

    </div>
</main>

<?php
    $this->load->view('desktop/misc/modal__bug_report');
    $this->load->view('desktop/misc/js/bug_report');
    $this->load->view('desktop/profile/js/company_join');