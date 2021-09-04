<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 23/10/2018
 * Time: 14:31
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
            <div class="header__page-title t-hide">Партнеры</div>

            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
        </div>
    </header>

    <div class="content">



                <?php /*
                        <!-- если профиль пустой -->
                        <div class="container" style="display: none;">
                            <div class="flex-row">
                                <div class="profile-info__img-container">
                                    <div class="profile-info__img is-rounded" style="">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="profile-info__data-container pr-data-container">
                                    <div class="pr-data-container__empty-name">+7 999-999-99-00</div>
                                    <div class="pr-data-container__empty-title is-or-text">Сделайте рабочее пространство эффективным, дополнив информацию о себе</div>
                                    <div class="pr-data-container__empty-descr is-grey-text">Ваш профиль — это не просто анкета, но и визитная карточка, открывающая широкие возможности по расширению партнерской сети.</div>
                                </div>
                            </div>
                            <div class="profile-info__activity pr-activity pr-activity--empty">
                                <div class="pr-activity__status pr-status flex-row">
                                    <div class="pr-status__title is-grey-text">Статус</div>
                                    <div class="pr-status__name">
                                        <span>Готов к сотрудничеству</span>
                                    </div>
                                    <a href="" class="pr-status__link is-or-text">Изменить</a>
                                </div>
                            </div>
                        </div>
                        <!-- end если профиль пустой -->

                        */ ?>
                <!-- если профиль заполнен -->

        <?php if( $page_content["partner"]->security_page != 'me'):?>
            <section class="profile">
                <div class="profile__info profile-info">

                    <div class="container">
                        <div class="profile-info__main-container flex-row">

                            <div class="profile-info__img-container">
                                <?php if($page_content["partner"]->avatar):?>
                                    <div class="profile-info__img is-rounded has-avatar">
                                        <img src="/uploads/users/<?php echo $page_content["partner"]->id;?>/avatar/180x180_<?php echo $page_content["partner"]->avatar;?>" style="width: 100%; height: auto;">
                                    </div>
                                <?php else:?>
                                    <div class="profile-info__img is-rounded has-avatar">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                <?php endif;?>
                            </div>
                            <div class="profile-info__data-container pr-data-container">
                                <div class="pr-data-container__name"><?php echo $page_content["partner"]->name;?> <?php echo $page_content["partner"]->second_name;?> <?php echo $page_content["partner"]->last_name;?></div>
                                <?php if($page_content["company"] && $page_content["partner"]->company_profession):?>
                                    <div class="pr-data-container__title"><?php echo $page_content["partner"]->company_profession;?></div>
                                    <a href="/company/id<?php echo $page_content["company"]->id;?>" class="pr-data-container__descr is-blue-text">
                                        <?php echo $page_content["company"]->short_name;?>
                                    </a>
                                <?php else:?>
                                    <div class="pr-data-container__title">
                                        Физическое лицо
                                    </div>
                                <?php endif;?>

                            </div>

                        </div>


                        <?php if( $page_content["partner"]->security_contacts != 'me'):?>
                            <div class="profile-info__activity pr-activity">
                                <div class="pr-activity__contacts pr-contacts flex-row">
                                    <div class="pr-contacts__title is-grey-text">Контакты</div>

                                    <div>

                                        <?php if($page_content["partner"]->city):?>
                                            <p>
                                                <span class="pr-contacts__city"><?php echo $page_content["partner"]->city;?></span>
                                            </p>
                                        <?php endif;?>

                                        <?php if( $page_content["partner"]->email ):?>
                                            <p>
                                                <a href="mailto:<?php echo $page_content["partner"]->email;?>" class="pr-contacts__email"><?php echo $page_content["partner"]->email;?></a>
                                            </p>
                                        <?php endif;?>

                                        <?php if( $page_content["partner"]->contact_phone ):?>
                                            <p>
                                                <a href="tel:<?php echo $page_content["partner"]->contact_phone;?>" class="pr-contacts__phone is-blue-text"><?php echo $page_content["partner"]->contact_phone;?></a>
                                            </p>
                                        <?php endif;?>

                                        <?php if( $page_content["count_user_partners"] ):?>
                                            <div class="pr-contacts__pre-rating">
                                                <div class="pr-contacts__rating is-rounded">
                                                    <?php if ( isset($page_content["user"]->rating) && $page_content["user"]->rating ):?>
                                                        <div class="pr-contacts__stars rate__lvl rate__lvl--<?php echo $page_content["user"]->rating;?>"></div>
                                                    <?php else:?>
                                                        <div class="pr-contacts__stars rate__lvl" style="opacity: 0.2"></div>
                                                    <?php endif;?>

                                                    <div class="pr-contacts__users is-blue-text">
                                                        <i class="fa fa-users"></i>
                                                        <?php echo $page_content["count_user_partners"];?>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>



                        <div class="partner-status">
                            <div class="partner-status__lbar">
                                <a href="#" class="js-partner__open_modal is-grey-link partner-req pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $page_content["partner"]->id;?>">
                                    <i class="fa fa-check-square"></i>
                                    <span>Ваш партнёр</span>
                                </a>

                                <a href="#" class="js-partner__undo_remove_user my-partners__del is-blue-link is-hidden pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $page_content["partner"]->id;?>">
                                    <i class="fa fa-plus i-left-15"></i>
                                    <span>Вернуть в партнеры</span>
                                </a>
                            </div>
                            <div class="partner-status__rbar">
                                <?php /* if( $partner->security_partners != 'me'  ):?>
                        <a href="index-16.html" target="_blank" class="is-grey-link rbar__link">
                            <i class="fa fa-search i-left-15"></i>
                            <span>Найти его коллег</span>
                        </a>
                        <?php endif; */?>
                                <a href="#" class="js-partner__open_chat is-grey-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $page_content["partner"]->id;?>">
                                    <i class="fa fa-envelope i-left-15"></i>
                                    <span>Написать сообщение</span>
                                </a>
                            </div>
                            <div class="js-partner__remove__modal partner-status__msg is-box-shadow-bold is-rounded status-msg is-hidden">
                                <p>В даннный момент <?php echo $page_content["partner"]->name;?> является Вашим партнером, Вы можете завершить партнерство.</p>
                                <a href="#" class="js-partner__remove_user gr-btn status-msg__del is-fade pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $page_content["partner"]->id;?>">
                                    Убрать из партнеров
                                </a>
                            </div>
                        </div>

                    </div>

                    <?php if($page_content["partner"]->status != ''):?>
                        <div class="profile-status">
                            <div class="container pr-activity">
                                <div class="pr-activity__status pr-status flex-row">
                                    <div class="pr-status__title is-grey-text">Статус</div>
                                    <div class="pr-status__name">
                                        <?php echo $page_content["partner"]->status;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <!-- end если профиль заполнен -->


                </div>


            </section>


            <?php if( !empty( $page_content["partners__offers_and_news"] ) ):?>

                <div class="ajax__news_container ajax__offers_full_width_container">
                    <?php

                    if( $page_content["offers__pinned"] && is_array( $page_content["offers__pinned"] ) && !empty( $page_content["offers__pinned"] )):
                        foreach ( $page_content["offers__pinned"] as $pinned_offer ):
                            $this->load->view('mobile/offers/loop', $pinned_offer);
                        endforeach;
                    endif;


                    $last_loaded_news = '';
                    $last_loaded_offers = '';

                    foreach( $page_content["partners__offers_and_news"] as $users_post):
                        if( $users_post->post_type == 'news' ):
                            $last_loaded_news   = $users_post->id;
                            $this->load->view('mobile/news/loop', $users_post);
                        elseif( $users_post->post_type == 'offers' ):
                            $last_loaded_offers   = $users_post->id;
                            $this->load->view('mobile/offers/loop', $users_post);
                        endif;
                    endforeach;
                    ?>
                </div>

                <input type="hidden" id="ajax__news-user_id" value="<?php echo $page_content["partner"]->id;?>">
                <input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">
                <input type="hidden" id="ajax__last_loaded_offers" value="<?php echo $last_loaded_offers;?>">


            <?php else:?>
                <div class="requests__last">
                    Пользователь еще не добавлял ни новостей, ни объявлений
                </div>
            <?php endif;?>

        <?php else:?>

            <div class="my-partners__last is-no-select">
                Страница скрыта настройками приватности
            </div>

        <?php endif;?>












    </div>


<?php

    $this->load->view('mobile/news/mustache_template__loop');
    $this->load->view('mobile/news/mustache_template__loop_modal');
    $this->load->view('mobile/news/mustache_template__loop_comments');
    $this->load->view('mobile/news/mustache_template__loop__news_only');

    $this->load->view('mobile/offers/mustache_template__loop');
    //$this->load->view('mobile/offers/mustache_template__loop_full_width');
    $this->load->view('mobile/offers/mustache_template__loop_modal');

    $this->load->view('mobile/misc/js/partners__open_chat');

    $this->load->view('mobile/partners/js/partner_functions');
    $this->load->view('mobile/partners/js/partner_accept');
    $this->load->view('mobile/partners/js/partner_add');
    $this->load->view('mobile/partners/js/partner_cancel');
    $this->load->view('mobile/partners/js/partner_messages');
    $this->load->view('mobile/partners/js/partner_remove');

    $this->load->view('mobile/user/js/search');

    //$this->load->view('mobile/user/js/functions');
    $this->load->view('mobile/user/js/load_user_content');

    $this->load->view('mobile/news/js/functions');
    $this->load->view('mobile/news/js/comments');
    $this->load->view('mobile/news/js/likes');

    $this->load->view('mobile/offers/js/functions');
    $this->load->view('mobile/offers/js/get_item');