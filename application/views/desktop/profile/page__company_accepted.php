
<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.08.16
 * Time: 14:17
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

                    <!--  Блок c результатами поиска компании  -->
                    <div class="my-company-search__treatment is-rounded is-box-shadow">
                        <div class="my-company-search__content">
                            <!--  -->
                            <div class="my-partners__row">
                                <div class="my-partners__lcell">
                                    <a href="" class="company__image is-rounded">
                                        <?php if($company->logo):?>
                                            <img src="/uploads/companies/<?php echo $company->id;?>/logo/80x80_<?php echo $company->logo;?>" alt="">
                                        <?php endif;?>
                                    </a>
                                    <div class="my-partners__content">
                                        <a href="/company" class="my-partners__name is-blue-link"><span><b><?php echo $company->short_name;?></b></span></a>
                                        <div>
                                            <?php if( $company->is_manager && !$company->active):?>
                                                На ваше имя и юридический адрес <b>(<?php echo $company->manager;?>, <?php echo $company->u_address;?>)</b> выслано письмо с паролем для подтверждения достоверности данных
                                            <?php elseif ( $company->is_manager && $company->active ):?>
                                                <a href="/company" class="my-partners__company-staff is-grey-link">
                                                    <span><?php echo $company->count_employers;?> <?php echo $company->count_employers_text;?></span>
                                                </a>
                                                <?php if ($company->count_employers > 1):?>
                                                <span> и Вы руководитель!</span>
                                                <?php endif;?>
                                            <?php elseif (!$company->is_manager):?>
                                                <a href="/company" class="my-partners__company-staff is-grey-link">
                                                    <span><?php echo $company->count_employers;?> <?php echo $company->count_employers_text;?></span>
                                                </a>
                                                <?php if ($company->count_employers > 1):?>
                                                <span> и Вы один из них!</span>
                                                <?php endif;?>
                                            <?php endif;?>
                                        </div>
                                        <?php if( $company->rating ):?>
                                            <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $company->rating;?>"></div>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <div class="my-partners__rcell">
                                    <div>
                                        <?php if( $company->removed == 1 ):?>

                                            <p>
                                                <span class="is-or-text">
                                                    <span>Временно деактивирована</span>
                                                </span>
                                            </p>

                                        <?php elseif( $company->is_manager && !$company->active):?>
                                            <a href="#leave-company" class="is-or-link fancybox">
                                                <i class="fas fa-sign-out-alt i-left-15"></i>
                                                <span>Отменить регистрацию</span>
                                            </a>
                                            <p>
                                                <a class="js__exdor_code__trigger is-blue-link">
                                                    <i class="fas fa-unlock i-left-15"></i>
                                                    <span>Ввести пароль</span>
                                                </a>
                                            </p>
                                        <?php elseif( $company->is_manager && $company->active ):?>

                                            <p>
                                                <a href="/company/edit" class="is-blue-link">
                                                    <i class="fas fa-pen i-left-15"></i>
                                                    <span>Редактировать</span>
                                                </a>
                                            </p>

                                            <p>
                                                <a href="#leave-company" class="is-or-link fancybox">
                                                    <i class="fas fa-times i-left-15"></i>
                                                    <span>Удалить компанию</span>
                                                </a>
                                            </p>

                                        <?php else:?>
                                            <a href="#leave-company" class="is-or-link fancybox">
                                                <i class="fas fa-sign-out-alt i-left-15"></i>
                                                <span>Покинуть компанию</span>
                                            </a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                    <!-- -->

                    <!-- Текст под результатами -->
                    <div class="my-company-search__notes">
                        <span class="is-grey-text">
                            <?php if( $company->is_manager && !$company->active):?>
                                В целях обеспечения безопасности и сохранения репутации наших пользователей в ближайшее время на юридический адрес вашей компании придет письмо с паролем для подтверждения и инструкциями по использованию нашего ресурса.<br><br>
                                Спасибо за регистрацию компании на нашем сайте!
                            <?php else:?>
                                В сети Exdor вы можете быть сотрудником или руководителем только одной компании.<br>
                                Если Вы хотите представлять интересы другой компании, нажмите на ссылку "Покинуть компанию"<br> и пройдите процедуру присоединения/создания другой компании.
                            <?php endif;?>
                        </span>
                    </div>
                    <!-- -->
                </div> 
            </div>
            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->


        <!--  Подверждение  -->
        <div id="leave-company" class="modal__block is-rounded">
            <div class="modal__head modal__head--blue is-first-item">
                <div class="modal__title">Это важно</div>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>

            <div class="modal__content">
                <form method="post">
                    <input type="hidden" name="action" value="leave_company">
                    <input type="hidden" name="user" value="<?php echo $user->id;?>">
                    <input type="hidden" name="company" value="<?php echo $company->id;?>">
                    <input type="hidden" name="manager" value="<?php echo $company->manager;?>">

                    <?php if( $company->is_manager && !$company->active):?>

                        <h2>Вы уверены что хотите отменить регистрацию <?php echo $company->short_name;?>?</h2>
                        <p>После того, как Вы отмените регистрацию компании, Вы не сможете действовать от ее лица. В дальнейшем Вы сможете снова добавить компанию.</p>
                        <div class="confirm__block">
                            <button type="submit" value="leave" class="confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                                <i class="fas fa-check"></i>
                                <span>Да, отменить</span>
                            </button>

                            <a href="" class="confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                                <i class="fas fa-times"></i>
                                <span>Не отменять</span>
                            </a>
                        </div>

                    <?php elseif( $company->is_manager && $company->active):?>
                        <h2>Вы уверены что хотите удалить компанию <?php echo $company->short_name;?>?</h2>
                        <p>После того, как Вы удалите компанию, Вы и ваши сотрудники не сможете действовать от ее лица.</p>
                        <div class="confirm__block">
                            <button type="submit" value="leave" class="confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                                <i class="fas fa-check"></i>
                                <span>Да, удалить</span>
                            </button>

                            <a href="" class="confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                                <i class="fas fa-times"></i>
                                <span>Нет, остаться</span>
                            </a>
                        </div>
                    <?php else:?>
                        <h2>Вы уверены что хотите покинуть компанию <?php echo $company->short_name;?>?</h2>
                        <p>После того, как Вы покинете компанию, Вы не сможете действовать от ее лица. Все заявки наработанные за период Вашей деятельности в компании будут удалены из Вашего раздела заявок. Чтобы вернуться в компанию Вам потребуется подтверждение запроса от ее директора.</p>
                        <div class="confirm__block">
                            <button type="submit" value="leave" class="confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                                <i class="fas fa-check"></i>
                                <span>Да, покинуть</span>
                            </button>

                            <a href="" class="confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                                <i class="fas fa-times"></i>
                                <span>Нет, остаться</span>
                            </a>
                        </div>
                    <?php endif;?>
                </form>

            </div>
        </div>
        <!-- end Подверждение -->
    </div>
</main>
<div id="enter_exdor_code--modal" class="enter_exdor_code--modal modal is-rounded" style="display: none;">
    <?php $this->load->view('desktop/profile/modal__enter_exdor_code');?>
</div>


<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
    $this->load->view('desktop/profile/js/functions');
    $this->load->view('desktop/profile/js__scripts');
    $this->load->view('desktop/profile/js/company_exdor_code');
    ?>