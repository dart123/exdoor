<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.04.2018
 * Time: 18:24
 */


$last_loaded_news   = '';
$last_loaded_offers = '';
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
                <div class="header__page-title t-hide">Моя страница</div>

                <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>
            </div>
        </header>


        <div class="add_menu__actions">
            <i class="fa fa-plus add_menu__actions__i" aria-hidden="true"></i>
            <ul class="add_menu__actions__item is-box-shadow-bold">
                <li>
                    <a href="/news/?action=add" class="add_menu__actions__link">Добавить новость</a>
                </li>
                <li>
                    <a href="/offers/?action=add" class="add_menu__actions__link">Добавить объявление</a>
                </li>
                <li>
                    <a href="/requests/add" class="add_menu__actions__link">Добавить заявку</a>
                </li>
            </ul>
        </div>

        <div class="content">

            <section class="profile">
                <div class="profile__info profile-info">

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
                    <div class="container">
                        <div class="profile-info__main-container flex-row">

                            <div class="profile-info__img-container">
                                <?php if($page_content["user"]->avatar):?>
                                    <div class="profile-info__img is-rounded has-avatar">
                                        <img src="/uploads/users/<?php echo $page_content["user"]->id;?>/avatar/180x180_<?php echo $page_content["user"]->avatar;?>" style="width: 100%; height: auto;">
                                    </div>
                                <?php else:?>
                                <div class="profile-info__img is-rounded has-avatar">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                <?php endif;?>
                            </div>
                            <div class="profile-info__data-container pr-data-container">
                                <div class="pr-data-container__name"><?php echo $page_content["user"]->name;?> <?php echo $page_content["user"]->second_name;?> <?php echo $page_content["user"]->last_name;?></div>
                                <?php if($page_content["company"] && $page_content["user"]->company_profession):?>
                                    <div class="pr-data-container__title"><?php echo $page_content["user"]->company_profession;?></div>
                                    <a href="/company/id<?php echo $page_content["company"]->id;?>" class="pr-data-container__descr is-blue-text">
                                        <?php echo $page_content["company"]->short_name;?>
                                    </a>
                                <?php else:?>
                                    <div class="pr-data-container__title">
                                        Физическое лицо
                                    </div>
                                <?php endif;?>

                            </div>
                            <a href="/profile" class="profile-info__edit"><i class="fa fa-pen is-grey-text"></i></a>
                        </div>
                        <div class="profile-info__activity pr-activity">
                            <div class="pr-activity__contacts pr-contacts flex-row">
                                <div class="pr-contacts__title is-grey-text">Контакты</div>

                                <div>

                                    <?php if($page_content["user"]->city):?>
                                        <p>
                                            <span class="pr-contacts__city"><?php echo $page_content["user"]->city;?></span>
                                        </p>
                                    <?php endif;?>

                                    <?php if( $page_content["user"]->email ):?>
                                        <p>
                                            <a href="mailto:<?php echo $page_content["user"]->email;?>" class="pr-contacts__email"><?php echo $page_content["user"]->email;?></a>
                                        </p>
                                    <?php endif;?>

                                    <?php if( $page_content["user"]->contact_phone ):?>
                                        <p>
                                            <a href="tel:<?php echo $page_content["user"]->contact_phone;?>" class="pr-contacts__phone is-blue-text"><?php echo $page_content["user"]->contact_phone;?></a>
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
                    </div>

                    <div class="profile-status">
                        <div class="container pr-activity">
                            <div class="pr-activity__status pr-status flex-row">
                                <div class="pr-status__title is-grey-text">Статус</div>
                                <div class="pr-status__name">
                                    <a href="#" class="<?php if ($page_content["this_user"]):?>js__profile-status__text <?php endif;?>profile-status__text pointer" data-user="<?php echo $page_content["user"]->id;?>" <?php if($page_content["user"]->status == ''):?>data-status="unset"<?php endif;?>><?php if($page_content["user"]->status != '') echo $page_content["user"]->status; else echo "<span class='is-grey-text'>yкажите статус</span>";?></a> <?php if ($page_content["this_user"]):?>&nbsp;<a href="#" class="js__profile-status__text__save_icon" style="display: none;"><i class=" fa fa-2x fa-check is-blue-text pointer" ></i></a>&nbsp;<i class="fa fa-pen" style="display: none;"></i><?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end если профиль заполнен -->

                </div>
            </section>

            <section class="profile-links flex-row">
                <?php if ($page_content["users__news"]):?>
                    <a class="js--change-content pointer profile-links__item -active" data-content="news">Новости</a>
                <?php endif;?>
                <?php if ($page_content["users__offers"]):?>
                    <a class="js--change-content pointer profile-links__item" data-content="offers">Объявления</a>
                <?php endif;?>
                <?php if ($page_content["users__requests"]):?>
                    <a class="js--change-content pointer profile-links__item" data-content="requests">Заявки</a>
                <?php endif;?>
            </section>

            <div class="js--change-content--container js--change-content--news-container">
                <div class="ajax__news_container">
                    <?php if( $page_content["users__news"] ):
                        foreach ( $page_content["users__news"] as $users__news ):
                            $last_loaded_news   = $users__news->id;
                            $this->load->view('mobile/news/loop', $users__news);
                        endforeach;
                    endif;?>
                </div>
            </div>
            <div class="js--change-content--container js--change-content--offers-container" style="display: none">
                <div class="ajax__offers_full_width_container">
                    <?php if( $page_content["offers__pinned"] && is_array($page_content["offers__pinned"]) && !empty($page_content["offers__pinned"])):
                        foreach ( $page_content["offers__pinned"] as $pinned_offer ):
                            $this->load->view('mobile/offers/loop', $pinned_offer);
                        endforeach;
                    endif;?>

                    <?php if( $page_content["users__offers"] ):
                        foreach ( $page_content["users__offers"] as $users__offers ):
                            $last_loaded_offers   = $users__offers->id;
                            $this->load->view('mobile/offers/loop', $users__offers);
                        endforeach;
                    endif;?>
                </div>
            </div>
            <div class="js--change-content--container js--change-content--requests-container" style="display: none">

                <?php if( $page_content["users__requests"] ):
                    foreach ( $page_content["users__requests"] as $users__request ):
                        $this->load->view('mobile/requests/loop__block', $users__request);
                    endforeach;
                endif;?>

            </div>


            <input type="hidden" id="ajax__news-user_id" value="<?php echo $page_content["user"]->id;?>">
            <input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">
            <input type="hidden" id="ajax__last_loaded_offers" value="<?php echo $last_loaded_offers;?>">

            <?php if ( ( count($page_content["users__offers"]) + count($page_content["users__news"]) ) > 9 ):?>
                <!-- Кнопка Подгружаю еще -->
                <div class="load-more">
                    <div class="cssload-container">
                        <div class="cssload-whirlpool"></div>
                    </div>
                    <span>Подгружаю еще</span>
                </div>
            <?php endif;?>

        </div>

<?php

    $this->load->view('mobile/user/js/load_user_content');
    $this->load->view('mobile/user/js/user_status');
    $this->load->view('mobile/user/js/user_content_filter');
    $this->load->view('mobile/user/js/search');


    /****** NEWS ******/

    $this->load->view('mobile/news/mustache_template__loop');
    $this->load->view('mobile/news/mustache_template__loop_comments');
    $this->load->view('mobile/news/mustache_template__loop_modal');
    $this->load->view('mobile/news/mustache_template__loop__news_only');


    $this->load->view('mobile/news/js/functions');
    //$this->load->view('mobile/news/js/navigation');
    $this->load->view('mobile/news/js/add_item');
    $this->load->view('mobile/news/js/get_item');
    $this->load->view('mobile/news/js/remove_item');

    $this->load->view('mobile/news/js/comments');
    $this->load->view('mobile/news/js/likes');

    /****** OFFERS ******/

    $this->load->view('mobile/offers/mustache_template__loop');
    $this->load->view('mobile/offers/mustache_template__loop_modal');
    $this->load->view('mobile/offers/mustache_template__loop_full_width');

    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/offers/js/functions');
    //$this->load->view('mobile/offers/js/navigation');
    $this->load->view('mobile/offers/js/get_item');
    $this->load->view('mobile/offers/js/add_item', array('page' => 'main'));
    $this->load->view('mobile/offers/js/edit_item');
    $this->load->view('mobile/offers/js/remove_item');
    $this->load->view('mobile/offers/js/filter');