<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 22/10/2018
 * Time: 11:51
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
        <div class="header__page-title t-hide">Моя компания</div>

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


    <section class="profile">
        <div class="profile__info profile-info">

            <!-- если профиль заполнен -->
            <div class="container">
                <div class="profile-info__main-container flex-row">

                    <div class="company-profile__logo">
                        <?php if($page_content["company"]->logo):?>
                            <div class="profile-info__img  company-profile-info__img  is-rounded has-avatar">
                                <img src="/uploads/companies/<?php echo $page_content["company"]->id;?>/logo/180_<?php echo $page_content["company"]->logo;?>" alt="">
                            </div>
                        <?php else: ?>
                            <div class="profile-info__img is-rounded has-avatar">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="profile-info__data-container pr-data-container">
                        <div class="pr-data-container__name">
                            <?php echo $page_content["company"]->short_name;?>
                        </div>

                        <?php switch( $page_content["company"]->type ) {
                            case "sell":
                                $company_type   = "Продающая компания";
                                break;
                            case "buy":
                                $company_type   = "Покупающая компания";
                                break;
                            case "all":
                                $company_type   = "Торгующая компания";
                                break;
                        }?>

                        <div class="pr-data-container__title"><?php echo $company_type;?></div>

                        <div class="pr-data-container__title is-grey-text">
                            <span>
                                <?php foreach ( $page_content["company"]->brands as $brand ):?>
                                    <?php echo $brand;?>,
                                <?php endforeach;?>
                            </span>
                        </div>



                    </div>
                    <?php if( $page_content["company"]->is_manager ):?>
                        <a href="/company/edit/" class="profile-info__edit"><i class="fa fa-pencil is-grey-text"></i></a>
                    <?php endif;?>

                </div>
                <div class="profile-info__activity pr-activity">
                    <div class="pr-activity__contacts pr-contacts flex-row">
                        <div class="pr-contacts__title is-grey-text">Контакты</div>

                        <div>

                            <?php if( $page_content["company"]->city_name):?>
                                <p>
                                    <span class="pr-contacts__city"><?php echo $page_content["company"]->city_name;?></span>
                                </p>
                            <?php endif;?>

                            <?php if( $page_content["company"]->email ):?>
                                <p>
                                    <a href="mailto:<?php echo $page_content["company"]->email;?>" class="pr-contacts__email"><?php echo $page_content["company"]->email;?></a>
                                </p>
                            <?php endif;?>

                            <?php if( $page_content["company"]->phone ):?>
                                <p>
                                    <a href="tel:<?php echo $page_content["company"]->phone;?>" class="pr-contacts__phone is-blue-text"><?php echo $page_content["company"]->phone;?></a>
                                </p>
                            <?php endif;?>

                        </div>
                    </div>


                    <div class="pr-activity__contacts pr-contacts flex-row">
                        <div class="pr-contacts__title is-grey-text">О компании</div>

                        <div style="width: 60%">
                            <?php if($page_content["company"]->description != '' ):?>

                                <div class="main-tagline__full js__company_about_full  is-long-row">
                                    <?php echo $page_content["company"]->description;?>
                                </div>

                                <?php if ( mb_strlen( $page_content["company"]->description, 'UTF-8') > 90 ):?>
                                    <a href="#" class="js__show_full_about   is-or-link"><span>Подробнее</span></a>
                                <?php endif;?>

                            <?php else:?>
                                <p class="is-long-row">
                                    Описание отсутствует
                                </p>
                            <?php endif;?>

                            <div class="pr-contacts__pre-rating">
                                <div class="pr-contacts__rating is-rounded">
                                    <?php if ( isset($page_content["company"]->rating) && $page_content["company"]->rating ):?>
                                        <div class="pr-contacts__stars rate__lvl rate__lvl--<?php echo $page_content["company"]->rating;?>"></div>
                                    <?php else:?>
                                        <div class="pr-contacts__stars rate__lvl" style="opacity: .2"></div>
                                    <?php endif;?>

                                    <div class="pr-contacts__users is-blue-text">
                                        <i class="fa fa-users"></i>
                                        <?php echo $page_content["company"]->count_employers;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <section class="profile-links flex-row">

                <a class="js--change-content pointer profile-links__item -active" data-content="news">Новости</a>

                <a class="js--change-content pointer profile-links__item" data-content="employers">Сотрудники</a>

                <a class="js--change-content pointer profile-links__item" data-content="requests">Заявки</a>

        </section>





        <div class="js--change-content--container js--change-content--news-container      ajax__news_container">
            <?php
            if( isset($page_content["company_news"]) && is_array($page_content["company_news"]) ):
                foreach ($page_content["company_news"] as $news_item):
                    $last_loaded_news   = $news_item->id;
                    $this->load->view('mobile/news/loop', $news_item);
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



        <div class="js--change-content--container js--change-content--employers-container" style="display: none">

            <?php foreach ($page_content["employers"] as $employer):?>

                <div class="requests-step__author req-author is-rounded is-box-shadow clear">

                    <?php if ( $employer->avatar ):?>
                        <a href="/partners/<?php echo $employer->id;?>" class="req-author__image req-author__image--image_exists is-rounded ">
                            <img src="/uploads/users/<?php echo $employer->id;?>/avatar/80x80_<?php echo $employer->avatar;?>" alt="" class="img-responsive">
                        </a>
                    <?php else:?>
                        <a href="/partners/<?php echo $employer->id;?>" class="req-author__image is-rounded ">
                        </a>
                    <?php endif;?>

                    <div class="req-author__content">
                        <div class="is-long-row">
                            <a href="/partners/<?php echo $employer->id;?>" class="is-blue-link">
                                <span>
                                    <b>
                                        <?php if( $employer->id == $this->session->user):?>(Вы)<?php endif;?>
                                        <?php echo $employer->name;?> <?php echo $employer->second_name;?> <?php echo $employer->last_name;?>
                                    </b>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>



            <?php endforeach;?>
        </div>

        <div class="js--change-content--container js--change-content--requests-container" style="display: none">




            <?php if( $page_content["company"]->is_manager ):?>
                <div class="main-requests  js__company_requests_container__header">

                    <div class="section-user-request__block is-rounded">
                        <div class="section-user-request__list ajax__company_requests_container">

                            <?php if( is_array($page_content["company_requests"]) && !empty($page_content["company_requests"])):
                                foreach ($page_content["company_requests"] as $request):
                                    $this->load->view("mobile/requests/loop__block", $request);
                                endforeach;
                            ?>

                                <div class="text-center is-mtop-30">
                                    <a href="/requests/" target="" class="is-blue-link">
                                        <i class="fa fa-arrow-circle-right i-left-20"></i>
                                        <span>Перейти в раздел с заявками</span>
                                    </a>
                                </div>

                            <?php else:?>

                                <div class="text-center is-mbtm-30">
                                    <p class="is-grey-text">
                                        <span>Заявки компании не найдены</span>
                                    </p>
                                </div>

                            <?php endif;?>

                        </div>
                    </div>


                </div>

            <?php else:?>

                <div class="text-center is-mtop-30">
                    <p class="is-grey-text">
                        <span>Просматривать заявки может только директор</span>
                    </p>
                </div>


            <?php endif;?>


        </div>

<!--
        <div class="load-more">
            <div class="cssload-container">
                <div class="cssload-whirlpool"></div>
            </div>
            <span>Подгружаю ещё</span>
        </div>
-->



        <input type="hidden" id="ajax__news-company_id" value="<?php echo $page_content["company"]->id;?>">
        <input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">
    </section>




</div>

<?php

    $this->load->view('mobile/company/js/company_content_filter');

    $this->load->view('mobile/requests/html_block__modal__cancel_author');
    $this->load->view('mobile/requests/html_block__modal__cancel_executor');

    $this->load->view('mobile/company/modal__add_employer');
    $this->load->view('mobile/company/modal__no_employer');

    $this->load->view('mobile/news/mustache_template__loop');
    $this->load->view('mobile/news/mustache_template__loop_comments');
    $this->load->view('mobile/news/mustache_template__loop_modal');
    $this->load->view('mobile/news/mustache_template__loop__news_only');

    $this->load->view('mobile/company/mustache_template__new_employer');

    $this->load->view('mobile/requests/mustache_template__loop__block');

    $this->load->view('mobile/news/js/functions');
    $this->load->view('mobile/news/js/add_item', array( 'company_news' => true ));
    $this->load->view('mobile/news/js/get_item');
    $this->load->view('mobile/news/js/edit_item');
    $this->load->view('mobile/news/js/remove_item');
    $this->load->view('mobile/news/js/likes');
    $this->load->view('mobile/news/js/comments');
    $this->load->view('mobile/news/js/navigation__company');

    $this->load->view('mobile/user/js/search');

    $this->load->view('mobile/company/js/news_loader');

    $this->load->view('mobile/requests/js/list_functions');
    $this->load->view('mobile/requests/js/in_process_author_denied');
    $this->load->view('mobile/requests/js/in_process_partner_denied');
    $this->load->view('mobile/requests/js/in_process_copy');
    $this->load->view('mobile/requests/js/in_process_send_to_archive');

    $this->load->view('mobile/company/js__scripts');
    $this->load->view('mobile/company/js/show_full_about');

    $this->load->view('mobile/company/js/modal__add_employer');
    $this->load->view('mobile/company/js/modal__no_employer');
