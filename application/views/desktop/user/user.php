<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.16
 * Time: 12:30
 * Description: Отображения страницы пользователя при высоком уровне заполненности
 *
 */

?>

<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>

<main>
    <div class="container">
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
            <?php
                if( ( $relationship == 'partner'  && $partner->security_partners == 'all') || $relationship == 'owner') :
                    $this->load->view('desktop/user/template__partners', $partners);
                endif;
            ?>
        </div>
        <section class="additional-features">
            <?php $this->load->view('desktop/misc/html__profile-step-by-step');?>
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <section class="page-content">
            <div class="section-user-info is-rounded is-box-shadow js__user_info_block">
                <div class="section-user-info__portrait user-portrait is-b-left">
                    <?php if(!$user->avatar):?>
                        <div class="user-portrait__space"></div>
                    <?php endif;?>
                    <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="choose-portrait-img" class="ajax-upload-avatar">

                    <label for="choose-portrait-img" class="is-or-link user-portrait__helpers helpers-signs js__avatar_label">
                        <?php if($user->avatar):?>
                            <div class="user-portrait__img user-portrait__img--image_exists user-portrait__img__editable">
                                <img src="/uploads/users/<?php echo $user->id;?>/avatar/180x180_<?php echo $user->avatar;?>" style="width: 100%; height: auto;">
                                <div class="user-portrait__img__edit"><i class="fas fa-pen"></i></div>
                            </div>
                        <?php else:?>
                            <div class="helpers-signs__content">
                                <div class="helpers-signs__icons"><i class="fas fa-plus"></i><i class="fa fa-camera"></i></div>
                                <span>Добавьте свой портрет</span>
                            </div>
                        <?php endif;?>
                    </label>

                </div>
                <div class="section-user-info__profile user-profile">
                    <div class="user-profile__contact"><?php echo $user->name;?> <?php echo $user->second_name;?> <?php echo $user->last_name;?></div>

                    <?php if($company && $user->company_profession):?>
                        <div class="user-profile__title">
                            <?php echo $user->company_profession;?>, <a href="/company/id<?php echo $company->id;?>" class="is-blue-link"><span><?php echo $company->short_name;?></span></a>
                        </div>
                    <?php endif;?>

                    <span class="<?php if ($this_user):?>js__profile-status__text <?php endif;?>profile-status__text pointer" data-user="<?php echo $user->id;?>" <?php if($user->status == ''):?>data-status="unset"<?php endif;?>><?php if($user->status != '') echo $user->status; else echo "<span class='is-grey-text'>yкажите статус</span>";?></span> <?php if ($this_user):?>&nbsp;<i class="js__profile-status__text__save_icon fas fa-check is-blue-text pointer" style="display: none;"></i>&nbsp;<i class="js__profile-status__text__edit_icon fas fa-pen" style="display: none;"></i><?php endif;?>

                    <div class="user-profile__text">
                        <?php if($user->city):?>
                        <p>
                            <span class="profile-ind is-grey-text">Город:</span>
                            <span class="profile-descr"><?php echo $user->city;?></span>
                        </p>
                        <?php endif;?>
                        <?php if( $user->email ):?>
                            <p>
                                <span class="profile-ind is-grey-text">E-mail:</span>
                                <span class="profile-descr">
                                    <a href="mailto:<?php echo $user->email;?>" class="is-blue-link">
                                        <span><?php echo $user->email;?></span>
                                    </a>
                                </span>
                            </p>
                        <?php endif;?>
                        <?php if( $user->contact_phone ):?>
                            <p>
                                <span class="profile-ind is-grey-text">Телефон:</span>
                                <span class="profile-descr">
                                    <a href="tel:<?php echo $user->contact_phone;?>" class="is-blue-link">
                                        <span><?php echo $user->contact_phone;?></span>
                                    </a>
                                </span>
                            </p>
                        <?php endif;?>
                    </div>
                </div>
                <div class="user-actions">

                    <?php if( $user->rating ):?>
                        <div class="user-actions__rating-level rate__lvl rate__lvl--<?php echo $user->rating;?>"></div>
                    <?php endif;?>

                    <a href="/profile" class="is-b-left slide-out__edit slide-out__edit--has-lvl is-fade">
                        <i class="fas fa-pen"></i>
                        <span class="">Редактировать</span>
                    </a>
                    <!--
                    1) если есть кнопка Редактировать, у звезд: class="user-actions__rating-level rate__lvl"
                    если нет кнопки Редактировать, у звезд: class="user-actions__rating-level rate__lvl rate__lvl--no-edit"

                    2) если нет рейтинга, кнопке Редактировать: class="is-b-left slide-out__edit is-fade"
                    если есть рейтинг со звездами, кнопке Редактировать: class="is-b-left slide-out__edit slide-out__edit--has-lvl is-fade"
                    -->
                </div>
            </div>




            <?php if( $this->session->user == $user->id && ($count_user_news == 0 || $count_user_offers == 0 || $count_user_requests == 0) ):?>

                <div class="section-user-create create__block is-mtop-20">
                    <ul class="create__list">

                        <?php if( $count_user_news == 0 ):?>
                            <li class="create__link">
                                <a href="#add-news" class="create__news is-rounded is-or-link btn ripple-effect fancybox">
                                    <i class="fas fa-plus"></i><i class="far fa-newspaper"></i>
                                    <span>Создать новость</span>
                                </a>
                            </li>
                        <?php endif;?>

                        <?php if( $count_user_offers == 0 ):?>
                            <li class="create__link">
                                <a href="#add-advpost" class="create__adv-post is-rounded is-or-link btn ripple-effect fancybox">
                                    <i class="fas fa-plus"></i><i class="fa fa-bullhorn"></i>
                                    <span>Создать объявление</span>
                                </a>
                            </li>
                        <?php endif;?>

                        <?php if( $count_user_requests == 0 ):?>
                            <li class="create__link">
                                <a href="/requests/add" class="create__request is-rounded is-or-link btn ripple-effect">
                                    <i class="fas fa-plus"></i><i class="fa fa-list-alt"></i>
                                    <span>Создать заявку</span>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            <?php endif;?>


            <?php if( $this->session->user == $user->id && $users__requests ):?>

                <div class="main-requests is-mtop-30">
                    <div class="main-requests__top-line is-mbtm-10">
                        <h2 class="section-title">Недавние заявки <span class="section-title__sub">(видны только вам)</span></h2>
                        <div class="section-title__helpers">
                            <a href="/requests/" class="is-blue-link">
                                <i class="fa fa-arrow-circle-right i-left-20"></i>
                                <span>Просмотреть все заявки</span>
                            </a>
                            <a href="/requests/add" class="is-or-link">
                                <i class="fas fa-plus-circle i-left-20"></i>
                                <span>Создать заявку</span>
                            </a>
                        </div>
                    </div>

                    <div class="is-rounded is-box-shadow">
                        <div class="section-user-request__list">

                            <?php foreach ($users__requests as $request):
                                $this->load->view("desktop/requests/loop__block", $request);
                            endforeach;?>

                        </div>
                    </div>
                </div>

            <?php endif;?>



            <div class="filter-panel is-mtop-30 is-mbtm-10" >
                <div class="news-advpost__top-line ">
                    <?php if( $count_user_news != 0 && $count_user_offers != 0 ):?>
                        <h2 class="section-title">Мои
                            <a href="" class="is-blue-link change-title">
                                <span class="filter-title" data-textF="объявления и новости" data-textS="объявления" data-textT="новости">объявления и новости</span>
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </h2>
                    <?php elseif( $count_user_news == 0 && $count_user_offers != 0 ):?>
                        <h2 class="section-title">Мои объявления</h2>
                    <?php elseif( $count_user_news != 0 && $count_user_offers == 0):?>
                        <h2 class="section-title">Мои новости</h2>
                    <?php endif;?>


                    <div class="section-title__helpers">
                        <?php if( $count_user_news != 0 ):?>
                            <a href="#add-news" class="is-or-link fancybox fancybox__add_news">
                                <i class="fas fa-plus-circle i-left-20"></i>
                                <span>Создать новость</span>
                            </a>
                        <?php endif;?>

                        <?php if( $count_user_offers != 0 ):?>
                            <a href="#add-advpost" class="is-or-link fancybox advpost__add-btn">
                                <i class="fas fa-plus-circle i-left-20"></i>
                                <span>Создать объявление</span>
                            </a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="ajax__news_container ajax__offers_full_width_container ">
                <?php

                    if($offers__pinned && is_array($offers__pinned) && !empty($offers__pinned)):
                        foreach ( $offers__pinned as $pinned_offer ):
                            $this->load->view('desktop/offers/loop__full_width', $pinned_offer);
                        endforeach;
                    endif;


                    $last_loaded_news = '';
                    $last_loaded_offers = '';
                if( $users__offers_and_news && is_array( $users__offers_and_news ) && !empty( $users__offers_and_news ) ) :
                        foreach($users__offers_and_news as $users_post):
                            if( $users_post->post_type == 'news' ):
                                $last_loaded_news   = $users_post->id;
                                $this->load->view('desktop/news/loop', $users_post);
                            elseif( $users_post->post_type == 'offers' ):
                                $last_loaded_offers   = $users_post->id;
                                $this->load->view('desktop/offers/loop__full_width', $users_post);
                            endif;
                        endforeach;
                    endif;
                ?>
            </div>

            <input type="hidden" id="ajax__news-user_id" value="<?php echo $user->id;?>">
            <input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">
            <input type="hidden" id="ajax__last_loaded_offers" value="<?php echo $last_loaded_offers;?>">

            <div class="load-more">
                <div class="cssload-container">
                    <div class="cssload-whirlpool"></div>
                </div>
                <span>Подгружаю ещё</span>
            </div>
        </section>

        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>


        <div id="add-news" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__add');?>
        </div>
        <div id="edit-news-comment" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__edit_comment');?>
        </div>
        <div id="add-advpost" class="modal is-rounded">
            <?php $this->load->view('desktop/offers/modal__add');?>
        </div>



        <div class="ajax__offers_modal_container ajax__news_modal_container">
            <?php
                if($offers__pinned && is_array($offers__pinned) && !empty($offers__pinned)):
                    foreach ( $offers__pinned as $pinned_offer ):
                        $this->load->view('desktop/offers/loop__modal', $pinned_offer);
                    endforeach;
                endif;

            if( $users__offers_and_news && is_array( $users__offers_and_news ) && !empty( $users__offers_and_news ) ) :
                    foreach($users__offers_and_news as $users_post):
                        if( $users_post->post_type == 'news' ):
                            $this->load->view('desktop/news/loop__modal', $users_post);
                        elseif( $users_post->post_type == 'offers' ):
                            $this->load->view('desktop/offers/loop__modal', $users_post);
                        endif;
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</main>


<?php

    $this->load->view('desktop/requests/html_block__model__cancel_author');
    $this->load->view('desktop/requests/html_block__model__cancel_executor');

    $this->load->view('desktop/requests/mustache_template__loop__block');

    $this->load->view('desktop/news/mustache_template__loop');
    $this->load->view('desktop/news/mustache_template__loop_modal');
    $this->load->view('desktop/news/mustache_template__loop_comments');
    $this->load->view('desktop/news/mustache_template__loop__news_only');

    $this->load->view('desktop/offers/mustache_template__loop');
    $this->load->view('desktop/offers/mustache_template__loop_full_width');
    $this->load->view('desktop/offers/mustache_template__loop_modal');

    $this->load->view('desktop/user/mustache_template__user_info_block__main');
    $this->load->view('desktop/user/mustache_template__user_info_block__user');

    $this->load->view('desktop/user/js/functions');
    $this->load->view('desktop/user/js/avatar_uploader');
    $this->load->view('desktop/user/js/load_user_content');
    $this->load->view('desktop/user/js/user_status');

    $this->load->view('desktop/user/js/search');

    $this->load->view('desktop/requests/js/list_functions');
    $this->load->view('desktop/requests/js/in_process_author_denied');
    $this->load->view('desktop/requests/js/in_process_partner_denied');
    $this->load->view('desktop/requests/js/in_process_copy');
    $this->load->view('desktop/requests/js/in_process_send_to_archive');

    $this->load->view('desktop/offers/js/functions');
    $this->load->view('desktop/offers/js/get_item');
    $this->load->view('desktop/offers/js/add_item', array('page' => 'main'));
    $this->load->view('desktop/offers/js/edit_item');
    $this->load->view('desktop/offers/js/remove_item');
    $this->load->view('desktop/offers/js/pin_item');
