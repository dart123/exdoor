<?php
/**
 *
 *
 *  АНАЛОГ COMPANY_FOUND
 *
 *
 *
 * Created by PhpStorm.
 * User: developer
 * Date: 02.08.16
 * Time: 14:23
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
                        Вы объявили себя сотрудником компании <a href="/company/id<?php echo $company->id;?>" class="is-blue-link"><span><?php echo $company->short_name;?></span></a>. <br>Мы ожидаем подтверждения этой информации от директора компании.
                    </div>

                    <!--  Блок c результатами поиска компании  -->
                    <div class="my-company-search__treatment is-rounded is-box-shadow">
                        <div class="my-company-search__content">
                            <!--  -->

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
                                        <div><a href="/company/id<?php echo $company->id;?>" class="my-partners__company-name is-grey-link"><span>Директор компании <?php echo $company->short_name;?></span></a></div>

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
                </div>
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->

        <!--  Сообщить об ошибке  -->
        <div id="report" class="modal modal__block is-rounded">
            <div class="modal__head is-rounded">
                <div class="modal__title">Сообщить об ошибке на сайте</div>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>
            <form action="">
                <div class="modal__body">
                    <div class="textarea--pre">
                        <textarea id="add-news__textarea" class="add-news__area is-rounded limit-1000" placeholder="Опишите проблему" maxlength="1000"></textarea>
                        <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
                    </div>

                    <!-- загрузка фото -->
                    <div class="clear">
                        <input type="file" accept="image/jpeg,image/png*" id="fileElem" multiple=""  style="display:none" onchange="handleFiles(this.files);">
                        <a href="#" id="fileSelect" class="is-blue-link add-requests__label" onClick="uploadImg(event);">
                            <i class="fa fa-paperclip i-left-20"></i>
                            <span>Прикрепить фото</span>
                        </a>
                        <ul id="filelist" class="сlear"></ul>
                    </div>
                    <!-- -->
                </div>
                <div class="modal__footer">
                        <span class="add-news__submit--wrap is-last-item btn ripple-effect btn-primary2">
                            <i class="fas fa-check"></i>
                            <input type="submit" class="add-news__submit " value="Отправить">
                        </span>
                </div>
            </form>
        </div>
        <!-- end Сообщить об ошибке -->
    </div>
</main>
