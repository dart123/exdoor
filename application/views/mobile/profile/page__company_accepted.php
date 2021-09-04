<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.08.16
 * Time: 14:17
 */

redirect('/company/edit', 'refresh');
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

<style>
    .content img {
        width: 100%;
        height: auto;
    }
</style>



<div class="content">

    <?php $this->load->view('mobile/profile/submenu', array("active" => "company"));?>

    <div class="page-content-form__left">
        <!--  Блок Результаты поиска компании  -->
        <div class="my-company-search">

            <!--  Блок c результатами поиска компании  -->
            <div class="my-company-search__treatment">
                <div class="my-company-search__content">
                    <!--  -->
                    <div class="my-partners__row" style="background: white">
                        <div class="my-partners__lcell">
                            <a href="/company" class="company__image is-rounded">
                                <?php if($page_content["company"]->logo):?>
                                    <img src="/uploads/companies/<?php echo $page_content["company"]->id;?>/logo/80x80_<?php echo $page_content["company"]->logo;?>" alt="">
                                <?php endif;?>
                            </a>
                            <div class="my-partners__content">
                                <a href="/company" class="my-partners__name is-blue-link"><span><b><?php echo $page_content["company"]->short_name;?></b></span></a>
                                <div>
                                    <?php if( $page_content["company"]->is_manager && !$page_content["company"]->active):?>
                                        На ваше имя и юридический адрес <b>(<?php echo $page_content["company"]->manager;?>, <?php echo $page_content["company"]->u_address;?>)</b> выслано письмо с паролем для подтверждения достоверности данных
                                    <?php elseif ( $page_content["company"]->is_manager && $page_content["company"]->active ):?>
                                        <a href="/company" class="my-partners__company-staff is-grey-link">
                                            <span><?php echo $page_content["company"]->count_employers;?> <?php echo $page_content["company"]->count_employers_text;?></span>
                                        </a>
                                        <?php if ($page_content["company"]->count_employers > 1):?>
                                        <span> и Вы руководитель!</span>
                                        <?php endif;?>
                                    <?php elseif (!$page_content["company"]->is_manager):?>
                                        <a href="/company" class="my-partners__company-staff is-grey-link">
                                            <span><?php echo $page_content["company"]->count_employers;?> <?php echo $page_content["company"]->count_employers_text;?></span>
                                        </a>
                                        <?php if ($page_content["company"]->count_employers > 1):?>
                                        <span> и Вы один из них!</span>
                                        <?php endif;?>
                                    <?php endif;?>
                                </div>
                                <?php if( $page_content["company"]->rating ):?>
                                    <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $page_content["company"]->rating;?>"></div>
                                <?php endif;?>


                                <div class="is-mtop-10">  <!-- my-partners__rcell -->

                                    <?php if( $page_content["company"]->removed == 1 ):?>

                                        <p>
                                            <span class="is-or-text">
                                                <span>Временно деактивирована</span>
                                            </span>
                                        </p>

                                    <?php elseif( $page_content["company"]->is_manager && !$page_content["company"]->active):?>
                                        <a href="#leave-company" class="is-or-link fancybox">
                                            <i class="fa fa-sign-out i-left-15"></i>
                                            <span>Отменить регистрацию</span>
                                        </a>
                                        <p class="is-mtop-5">
                                            <a class="js__exdor_code__trigger is-blue-link">
                                                <i class="fa fa-unlock i-left-15"></i>
                                                <span>Ввести пароль</span>
                                            </a>
                                        </p>
                                    <?php elseif( $page_content["company"]->is_manager && $page_content["company"]->active ):?>

                                        <p>
                                            <a href="/company/edit" class="is-blue-link">
                                                <i class="fa fa-pencil i-left-15"></i>
                                                <span>Редактировать</span>
                                            </a>
                                        </p>

                                        <p class="is-mtop-5">
                                            <a href="#leave-company" class="is-or-link fancybox">
                                                <i class="fa fa-sign-out i-left-15"></i>
                                                <span>Удалить компанию</span>
                                            </a>
                                        </p>

                                    <?php else:?>
                                        <a href="#leave-company" class="is-or-link fancybox">
                                            <i class="fa fa-sign-out i-left-15"></i>
                                            <span>Покинуть компанию</span>
                                        </a>
                                    <?php endif;?>
                                </div>



                            </div>




                        </div>
                    </div>
                    <!--  -->
                </div>
            </div>
            <!-- -->

            <!-- Текст под результатами -->
            <div class="my-company-search__notes" style="padding: 10px;">
                <span class="is-grey-text">
                    <?php if( $page_content["company"]->is_manager && !$page_content["company"]->active):?>
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


    <!--  Подверждение  -->
    <div id="leave-company" class="modal  modal--middle">
        <div class="modal__head modal__head--blue">
            <div class="modal__title">Удалить компанию?</div>
        </div>

        <div class="modal-body" style="background: #fff;">
            <form method="post">
                <input type="hidden" name="action" value="leave_company">
                <input type="hidden" name="user" value="<?php echo $page_content["user"]->id;?>">
                <input type="hidden" name="company" value="<?php echo $page_content["company"]->id;?>">
                <input type="hidden" name="manager" value="<?php echo $page_content["company"]->manager;?>">

                <?php if( $page_content["company"]->is_manager && !$page_content["company"]->active):?>
                    <p>После того, как Вы отмените регистрацию компании, Вы не сможете действовать от ее лица. В дальнейшем Вы сможете снова добавить компанию.</p>
                    <div class="confirm__block center is-mtop-20">
                        <button type="submit" value="leave" class=" bl-btn   confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                            <i class="fa fa-check"></i>
                            <span>Да</span>
                        </button>

                        <a href="#" class="btn-inline       confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                            <i class="fa fa-times"></i>
                            <span>Нет</span>
                        </a>
                    </div>

                <?php elseif( $page_content["company"]->is_manager && $page_content["company"]->active):?>
                    <p>После того, как Вы удалите компанию, Вы и ваши сотрудники не сможете действовать от ее лица.</p>
                    <div class="confirm__block center is-mtop-20">
                        <button type="submit" value="leave" class="bl-btn   confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                            <i class="fa fa-check"></i>
                            <span>Да</span>
                        </button>

                        <a href="#" class="btn-inline      confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                            <i class="fa fa-times"></i>
                            <span>Нет</span>
                        </a>
                    </div>
                <?php else:?>
                    <h2>Вы уверены что хотите покинуть компанию <?php echo $page_content["company"]->short_name;?>?</h2>
                    <p>После того, как Вы покинете компанию, Вы не сможете действовать от ее лица. Все заявки наработанные за период Вашей деятельности в компании будут удалены из Вашего раздела заявок. Чтобы вернуться в компанию Вам потребуется подтверждение запроса от ее директора.</p>
                    <div class="confirm__block center is-mtop-20">
                        <button type="submit" value="leave" class="bl-btn  confirm__block-btn btn ripple-effect btn-primary2 is-rounded">
                            <i class="fa fa-check"></i>
                            <span>Да</span>
                        </button>

                        <a href="#" class="btn-inline    confirm__block-btn btn ripple-effect or-btn btn-info is-rounded modal__close-btn">
                            <i class="fa fa-times"></i>
                            <span>Нет</span>
                        </a>
                    </div>
                <?php endif;?>
            </form>

        </div>
    </div>
    <!-- end Подверждение -->

    <div id="enter_exdor_code--modal" class="enter_exdor_code--modal modal is-rounded" style="display: none;">
        <?php $this->load->view('mobile/profile/modal__enter_exdor_code');?>
    </div>


<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>

<?php
    $this->load->view('mobile/profile/js/functions');
    $this->load->view('mobile/profile/js__scripts');
    $this->load->view('mobile/profile/js/company_exdor_code');
