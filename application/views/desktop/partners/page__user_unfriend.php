<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.09.16
 * Time: 20:14
 */
?>
<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);



            if( $partners && $partner->security_partners == 'all' && $partner->security_page == 'all' ) :
                $this->load->view('desktop/user/template__partners', $partners);
            endif;
            ?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <!-- Контент -->
        <section class="page-content">



                <div class="section-user-info is-rounded is-box-shadow">
                    <div class="section-user-info__portrait user-portrait is-b-left">

                        <?php if($partner->avatar):?>
                            <div class="user-portrait__img user-portrait__img--image_exists">
                                <img src="/uploads/users/<?php echo $partner->id;?>/avatar/180x180_<?php echo $partner->avatar;?>" style="width: 100%; height: auto;">
                            </div>
                        <?php else:?>
                            <div class="user-portrait__img">
                                <div class="my-pers-profile__helpers">
                                    <div class="helpers-signs__content is-blue-link">
                                        <div class="helpers-signs__icons">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>

                    </div>
                    <?php if( $partner->security_page == 'all'):?>
                        <div class="section-user-info__profile user-profile">
                            <div class="user-profile__contact"><?php echo $partner->name;?> <?php echo $partner->second_name;?> <?php echo $partner->last_name;?></div>


                            <?php if($company && $partner->company_profession):?>
                                <div class="user-profile__title">
                                    <?php echo $partner->company_profession;?>, <a href="/company/id<?php echo $company->id;?>" class="is-blue-link"><span><?php echo $company->short_name;?></span></a>
                                </div>
                            <?php else:?>
                                <div class="user-profile__title">
                                    Физическое лицо, компания не указана
                                </div>
                            <?php endif;?>

                            <span class="profile-status__text"><?php echo $partner->status;?></span>

                            <div class="user-profile__text">
                                <?php if( $partner->city ):?>
                                    <p>
                                        <span class="profile-ind is-grey-text">Город:</span>
                                        <span class="profile-descr"><?php echo $partner->city;?></span>
                                    </p>
                                <?php endif;?>
                                <?php if( $partner->security_contacts == 'all'  ):?>
                                    <?php if( $partner->email ):?>
                                        <p>
                                            <span class="profile-ind is-grey-text">E-mail:</span>
                                                <span class="profile-descr">
                                                <a href="mailto:<?php echo $partner->email;?>" class="is-blue-link">
                                                    <span><?php echo $partner->email;?></span>
                                                </a>
                                            </span>
                                        </p>
                                    <?php endif;?>
                                    <?php if( $partner->contact_phone && $partner->show_phone ):?>
                                        <p>
                                            <span class="profile-ind is-grey-text">Телефон:</span>
                                            <span class="profile-descr">
                                                <a href="tel:<?php echo $partner->contact_phone;?>" class="is-blue-link">
                                                    <span><?php echo $partner->contact_phone;?></span>
                                                </a>
                                            </span>
                                        </p>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>



                        </div>
                        <?php if( $partner->rating):?>
                        <div class="section-user-info__actions user-actions">
                            <div class="user-actions__rating-level rate__lvl rate__lvl--<?php echo $partner->rating;?> rate__lvl--no-edit"></div>
                        </div>
                        <?php endif;?>

                    <?php else:?>

                        <div class="my-partners__last is-no-select">
                            Страница скрыта настройками приватности
                        </div>

                    <?php endif;?>
                </div>
                <div class="partner-status">
                    <div class="partner-status__lbar">
                        <?php if ($relationship == 'send_request'):?>

                            <div class="relationship__send_request">

                                <a class="js-partner__add_user is-or-link pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $partner->id;?>">
                                    <i class="fas fa-plus-circle i-left-20"></i>
                                    <span>Принять в партнеры</span>
                                </a>
                            </div>

                        <?php else:?>


                            <div class="relationship__get_request <?php if ($relationship != 'get_request'):?>is-hidden<?php endif;?>">
                                <a class="js-partner__modal__cancel_request is-grey-link partner-req pointer">
                                    <i class="fas fa-check-square i-left-15"></i>
                                    <span>Вы отправили заявку</span>
                                </a>

                                <div class="modal__partner__cancel_request partner-status__msg is-box-shadow-bold is-rounded status-msg is-hidden">
                                    <p>Вы отправили Дмитрию заявку в партнеры, на данный момент заявка находится на рассмотрении.</p>

                                    <a class="js-partner__cancel_request gr-btn status-msg__cancel is-fade pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $partner->id;?>">Отменить заявку</a>

                                    <?php if( is_object($user_request) && $user_request->message ):?>
                                        <div class="my-partners__inbox-msg outbox-msg__text">
                                            <div class="my-partners__inbox-msg--before">Вы написали: </div>
                                            <p><?php echo $user_request->message;?></p>
                                        </div>
                                    <?php else:?>
                                        <div class="news-advpost__form is-last-item show-reply">
                                            <div class="reply__form-box">
                                                <textarea id="ajax-input-message" class="reply__area is-rounded" placeholder="Прикрепить сообщение"></textarea>
                                                <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                                <input type="submit" class="reply-tbox__submit reply__submit is-rounded" value="Отправить">
                                            </span>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>


                            <div class="relationship__none <?php if ($relationship != false):?>is-hidden<?php endif;?>">
                                <a class="js-partner__send_request is-or-link partner-add pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $partner->id;?>">
                                    <i class="fas fa-plus-circle i-left-20"></i>
                                    <span>Добавить в партнеры</span>
                                </a>
                            </div>

                        <?php endif;?>




                    </div>
                    <div class="partner-status__rbar">
                        <?php if( $is_dialog_exist ):?>
                            <a href="/messages/<?php echo $is_dialog_exist;?>" class="is-grey-link">
                                <i class="fas fa-envelope i-left-15"></i>
                                <span>Написать сообщение</span>
                            </a>
                        <?php else:?>
                            <a class="js-partner__open_chat is-grey-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $partner->id;?>">
                                <i class="fas fa-envelope i-left-15"></i>
                                <span>Написать сообщение</span>
                            </a>
                        <?php endif;?>
                    </div>


                </div>

                <?php if( $partner->security_page == 'all'):?>
                    <?php if( !empty($partners__offers_and_news) ):?>

                        <div class="filter-panel is-mtop-30 is-mbtm-10" >
                            <div class="news-advpost__top-line">
                                <?php if( $count_user_news != 0 && $count_user_offers != 0 ):?>
                                    <h2 class="section-title">
                                        <a href="" class="is-blue-link change-title">
                                            <span class="filter-title" data-textF="Объявления и новости" data-textS="Объявления" data-textT="Новости">Объявления и новости</span>
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
                                    </h2>
                                <?php elseif( $count_user_news == 0 && $count_user_offers != 0 ):?>
                                    <h2 class="section-title">Объявления</h2>
                                <?php elseif( $count_user_news != 0 && $count_user_offers == 0):?>
                                    <h2 class="section-title">Новости</h2>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="ajax__news_container ajax__offers_full_width_container">
                            <?php

                                if($offers__pinned && is_array($offers__pinned) && !empty($offers__pinned)):
                                    foreach ( $offers__pinned as $pinned_offer ):
                                        $this->load->view('desktop/offers/loop__full_width', $pinned_offer);
                                    endforeach;
                                endif;

                                $last_loaded_news = '';
                                $last_loaded_offers = '';
                                foreach($partners__offers_and_news as $users_post):
                                    if( $users_post->post_type == 'news' ):
                                        $last_loaded_news   = $users_post->id;
                                        $this->load->view('desktop/news/loop', $users_post);
                                    elseif( $users_post->post_type == 'offers' ):
                                        $last_loaded_offers   = $users_post->id;
                                        $this->load->view('desktop/offers/loop__full_width', $users_post);
                                    endif;
                                endforeach;
                            ?>
                        </div>

                        <input type="hidden" id="ajax__news-user_id" value="<?php echo $partner->id;?>">
                        <input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">
                        <input type="hidden" id="ajax__last_loaded_offers" value="<?php echo $last_loaded_offers;?>">


                        <div class="ajax__offers_modal_container ajax__news_modal_container">
                            <?php
                                if($offers__pinned && is_array($offers__pinned) && !empty($offers__pinned)):
                                    foreach ( $offers__pinned as $pinned_offer ):
                                        $this->load->view('desktop/offers/loop__modal', $pinned_offer);
                                    endforeach;
                                endif;

                                foreach($partners__offers_and_news as $users_post):
                                    if( $users_post->post_type == 'news' ):
                                        $this->load->view('desktop/news/loop__modal', $users_post);
                                    elseif( $users_post->post_type == 'offers' ):
                                        $this->load->view('desktop/offers/loop__modal', $users_post);
                                    endif;
                                endforeach;
                            ?>
                        </div>

                    <?php else:?>
                        <div class="requests__last">
                            Пользователь еще не добавлял ни новостей, ни объявлений
                        </div>
                    <?php endif;?>
                <?php endif;?>
        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>


        <div id="edit-news-comment" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__edit_comment');?>
        </div>

    </div>
</main>

<?php
    $this->load->view('desktop/news/mustache_template__loop');
    $this->load->view('desktop/news/mustache_template__loop_modal');
    $this->load->view('desktop/news/mustache_template__loop_comments');
    $this->load->view('desktop/news/mustache_template__loop__news_only');

    $this->load->view('desktop/offers/mustache_template__loop');
    $this->load->view('desktop/offers/mustache_template__loop_full_width');
    $this->load->view('desktop/offers/mustache_template__loop_modal');

    $this->load->view('desktop/misc/js/partners__open_chat');

    $this->load->view('desktop/partners/js/partner_functions');
    $this->load->view('desktop/partners/js/partner_accept');
    $this->load->view('desktop/partners/js/partner_add');
    $this->load->view('desktop/partners/js/partner_cancel');
    $this->load->view('desktop/partners/js/partner_messages');
    //$this->load->view('desktop/partners/js/partner_remove');
    $this->load->view('desktop/user/js/search');

    $this->load->view('desktop/user/js/functions');
    $this->load->view('desktop/user/js/load_user_content');

    $this->load->view('desktop/offers/js/functions');
    $this->load->view('desktop/offers/js/get_item');
