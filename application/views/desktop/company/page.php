<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 17:59
 */

?>
<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>


<main>
    <div class="container">
        <div class="main-features">
            <?php
                $this->load->view('desktop/user/menu_user', $menu);
                $this->load->view('desktop/company/block__candidats_employers');
                ?>
        </div>

        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <section class="page-content">

            <div class="section-company-profile is-rounded is-box-shadow">
                <div class="company-profile__block clear">
                    <div class="company-profile__logo">
                        <?php if($company->logo):?>
                            <img src="/uploads/companies/<?php echo $company->id;?>/logo/180_<?php echo $company->logo;?>" alt="">
                        <?php endif;?>
                    </div>
                    <div class="company-profile__name"><?php echo $company->full_name;?>&nbsp;

                        <?php if( $company->is_manager && $company->approved == 'approved' ) { ?>
                            <span class="is-black-text" style="display: inline-block">&nbsp;<i class="fas fa-check-circle"></i>&nbsp;Авторизована</span>
                        <?php } else if ($company->is_manager && $company->approved == 'not_approved') {?>
                            <span class="is-red-text" style="display: inline-block">&nbsp;<i class="far fa-clock" aria-hidden="true"></i>&nbsp;На модерации</span>
                        <?php } ?>
                    </div>

                    <?php if( $company->rating ):?>
                        <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo $company->rating;?>"></div>
                        <span class="is-grey-text">&mdash; суммарный рейтинг компании</span>
                    <?php endif;?>
                </div>
                <div class="company-profile__card company-card">
                    <div class="company-card__item is-long-row is-dgrey-text">
                        <i class="fa fa-map-marker"></i>
                        <span><?php echo ( $company->city ) ? $company->city_name : 'Город не указан';?></span>
                    </div>
                    <?php if($company->phone != ''):?>
                        <div class="company-card__item">
                            <a href="tel:<?php echo $company->phone;?>" class="is-grey-link">
                                <i class="fas fa-phone-alt"></i>
                                <span><?php echo $company->phone;?></span>
                            </a>
                        </div>
                    <?php else:?>
                        <div class="company-card__item">
                            <i class="fas fa-phone-alt"></i>
                            <span>Телефон не указан</span>
                        </div>
                    <?php endif;?>
                    <?php if($company->email != ''):?>
                        <div class="company-card__item">
                            <a href="mailto:<?php echo $company->email;?>" class="is-gblue-link">
                                <i class="far fa-envelope"></i>
                                <span>Написать письмо</span>
                            </a>
                        </div>
                    <?php else:?>
                        <div class="company-card__item">
                            <i class="far fa-envelope"></i>
                            <span>E-mail не указан</span>
                        </div>
                    <?php endif;?>
                    <?php if($company->site != ''):?>
                        <div class="company-card__item">
                            <a href="<?php echo $company->site;?>" target="_blank" class="is-gblue-link">
                                <i class="fa fa-globe"></i>
                                <span>Сайт компании</span>
                            </a>
                        </div>
                    <?php else:?>
                        <div class="company-card__item">
                            <i class="fa fa-globe"></i>
                            <span>Сайт не указан</span>
                        </div>
                    <?php endif;?>
                </div>
                <div class="company-profile__about main-tagline">
                    <div class="main-tagline__text">
                        <?php if($company->description != '' ):?>

                            <div class="main-tagline__full">
                                <span class="is-grey-text">О компании: </span>
                                <?php echo $company->description;?>
                            </div>

                            <?php if ( mb_strlen( $company->description, 'UTF-8') > 90 ):?>
                                <a href="" class="main-tagline__open is-or-link"><span>Подробнее</span></a>
                            <?php endif;?>

                        <?php else:?>
                            <p class="is-long-row">
                                <span class="is-grey-text">О компании: </span>
                                Описание отсутствует
                            </p>
                        <?php endif;?>
                    </div>
                </div>

                <div class="section-user-info__actions user-actions">

                    <?php if( $company->is_manager ):?>
                        <a href="/company/edit" class="is-b-left slide-out__edit slide-out__edit--has-lvl is-fade">
                            <i class="fas fa-pen"></i>
                            <span class="">Редактировать</span>
                        </a>
                    <?php endif;?>
                    <!-- для профиля своей компании (когда можно вносить изменения в ее содержимое) у кнопки Редактировать всегда class="slide-out__edit slide-out__edit--has-lvl"
                    -->
                </div>

            </div>


            <?php if( $company->is_manager ):?>
                <div class="main-requests is-mtop-30 js__company_requests_container__header <?php if( !is_array($company_requests) || empty($company_requests) ):?>is-hidden<?php endif;?>">
                    <div class="main-requests__top-line is-mbtm-10">
                        <h2 class="section-title">Недавние заявки сотрудников <span class="section-title__sub">(видны только директору)</span></h2>
                        <div class="section-title__helpers">
                            <a href="/requests/" target="" class="is-blue-link">
                                <i class="fa fa-arrow-circle-right i-left-20"></i>
                                <span>Просмотреть все заявки сотрудников</span>
                            </a>
                        </div>
                    </div>

                    <div class="section-user-request__block is-rounded is-box-shadow">
                        <div class="section-user-request__list ajax__company_requests_container">

                            <?php if( is_array($company_requests) && !empty($company_requests)):
                                    foreach ($company_requests as $request):
                                        $this->load->view("desktop/requests/loop__block", $request);
                                    endforeach;
                                endif;
                            ?>

                        </div>
                    </div>
                </div>

            <?php endif;?>



            <div class="filter-panel is-mtop-30 is-mbtm-10" >
                <div class="news-advpost__top-line">

                    <?php if( $has_company_news && $has_employers_news ):?>
                        <h2 class="section-title">Новости
                            <a href="" class="is-blue-link change-title-com">
                                <span class="filter-title" data-textCF="только компании" data-textCS="только сотрудников" data-textCT="компании и ее сотрудников">компании и ее сотрудников</span>
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </h2>
                    <?php elseif ( $has_company_news && !$has_employers_news ):?>
                        <h2 class="section-title">Новости компании</h2>
                    <?php elseif ( !$has_company_news && $has_employers_news ):?>
                        <h2 class="section-title">Новости сотрудников</h2>
                    <?php elseif ( !$has_company_news && !$has_employers_news ):?>
                        <h2 class="section-title">&nbsp;</h2>
                    <?php endif;?>

                    <?php if( $company->is_manager ):?>
                        <div class="section-title__helpers">
                            <a href="#add-news" class="is-or-link fancybox__add_news">
                                <i class="fas fa-plus-circle i-left-20"></i>
                                <span>Создать новость компании</span>
                            </a>
                        </div>
                    <?php endif;?>
                </div>
            </div>


            <div class="ajax__news_container">
                <?php
                    if( isset($company_news) && is_array($company_news) ):
                        foreach ($company_news as $news_item):
                            $last_loaded_news   = $news_item->id;
                            $this->load->view('desktop/news/loop', $news_item);
                        endforeach;
                    else:
                        $last_loaded_news = 0;
                        ?>
                            <div class="my-partners__last is-no-select js--company__no_news_message">
                                У компании пока что нет новостей
                            </div>
                        <?php
                    endif;
                ?>
            </div>

        <div class="load-more">
            <div class="cssload-container">
                <div class="cssload-whirlpool"></div>
            </div>
            <span>Подгружаю ещё</span>
        </div>

        <input type="hidden" id="ajax__news-company_id" value="<?php echo $company->id;?>">
        <input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">

        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>


        <!--  Создать новость  -->
        <div id="add-news" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__add');?>
        </div>
        <div id="edit-news-comment" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__edit_comment');?>
        </div>
        <!-- end Создать новость -->


        <div class="ajax__news_modal_container">

            <?php if($current_news && $current_news_id):

                $this->load->view('desktop/news/loop__modal', $current_news);
                ?>
                <a href="#news-post<?php echo $current_news_id;?>" data-fancybox="news-group" id="js__current_news_opener" class="fancybox__adv-news"></a>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#js__current_news_opener").fancybox().trigger('click');
                    });
                </script>
            <?php endif;?>


            <?php
                if( isset($company_news) && is_array($company_news) ):
                    foreach ($company_news as $news_item):
                        $this->load->view('desktop/news/loop__modal', $news_item);
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</main>


<?php

    $this->load->view('desktop/requests/html_block__model__cancel_author');
    $this->load->view('desktop/requests/html_block__model__cancel_executor');

    $this->load->view('desktop/company/modal__add_employer');
    $this->load->view('desktop/company/modal__no_employer');

    $this->load->view('desktop/news/mustache_template__loop');
    $this->load->view('desktop/news/mustache_template__loop_comments');
    $this->load->view('desktop/news/mustache_template__loop_modal');
    $this->load->view('desktop/news/mustache_template__loop__news_only');

    $this->load->view('desktop/company/mustache_template__new_employer');
    $this->load->view('desktop/company/mustache_template__new_employer__modal');
    $this->load->view('desktop/company/mustache_template__new_employer__edit_page');

    $this->load->view('desktop/requests/mustache_template__loop__block');

    $this->load->view('desktop/user/js/search');

    $this->load->view('desktop/company/js/news_loader');

    $this->load->view('desktop/requests/js/list_functions');
    $this->load->view('desktop/requests/js/in_process_author_denied');
    $this->load->view('desktop/requests/js/in_process_partner_denied');
    $this->load->view('desktop/requests/js/in_process_copy');
    $this->load->view('desktop/requests/js/in_process_send_to_archive');

    $this->load->view('desktop/company/js__scripts');

    $this->load->view('desktop/company/js/modal__add_employer');
    $this->load->view('desktop/company/js/modal__no_employer');
