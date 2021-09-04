<?php
/**
 * Created by developer with PhpStorm.
 * Date: 25.08.2018 12:37
 *
 *
 */

?>


<div class="header__icons t-hide">

    <?php if (array_key_exists( 'compare_page', $page_content["menu"]) && $page_content["menu"]["compare_page"] == true ):

        // Don't do anything

    elseif ( isset( $page_content["request_data"] ) && current_url() != "https://exdor.ru/requests/add"):?>

        <div class="request_menu__actions">
            <i class="fa fa-ellipsis-v  request_menu__actions__i" aria-hidden="true"></i>

            <ul class="request_menu__actions__item is-box-shadow">

                <?php if( $page_content["request_data"]->can__compare ):?>
                    <li>
                        <a href="<?php echo $page_content["request_data"]->html_compare_url;?>">Сравнить предложения</a>
                    </li>
                <?php endif;?>

                <?php if( $page_content["request_data"]->can__set_rating ):?>
                    <li class="js__requests__context_menu" data-href="https://exdor.ru/requests/<?php echo $page_content["request_data"]->id;?>?set_rating=true">
                        <?php if( $page_content["request_data"]->finished ):?>
                            <a href="#req__rating" class="fancybox__rating_modal">Завершить</a>
                        <?php else:?>
                            <a href="#req__rating" class="fancybox__rating_modal"><?php if($page_content["request_data"]->show_rating):?>Изменить оценку<?php else:?>Оценить партнера<?php endif;?></a>
                        <?php endif;?>

                    </li>
                <?php endif;?>

                <?php if( $page_content["request_data"]->can__clone ):?>
                    <li class="ajax__request__copy" data-request-id="<?php echo $page_content["request_data"]->id;?>">
                        <a>Копировать</a>
                    </li>
                <?php endif;?>

                <?php if( $page_content["request_data"]->can__archived ):?>
                    <li class="is-last-item ajax__request__send_to_archive" data-request-id="<?php echo $page_content["request_data"]->id;?>">
                        <a>Отправить в архив</a>
                    </li>
                <?php endif;?>

                <?php if( $page_content["request_data"]->can__cancel ): ?>
                    <?php if( $page_content["request_data"]->is_author ):?>
                        <li class="is-last-item js__requests_list__author_denied" data-request-id="<?php echo $page_content["request_data"]->id;?>" data-page-reload="no">
                            <a>Отменить</a>
                        </li>
                    <?php else:?>
                        <li class="is-last-item js__requests_list__partner_denied" data-request-id="<?php echo $page_content["request_data"]->id;?>" data-page-reload="no">
                            <a>Отклонить</a>
                        </li>
                    <?php endif;?>
                <?php endif;?>

            </ul>
        </div>

    <?php else:?>

        <?php if( isset( $page_header["search_or_link"] ) && is_array( $page_header["search_or_link"] ) && $page_header["search_or_link"]['type'] == 'search' ):?>

            <div class="header__open-search">
                <a href="#search_modal" class="fancybox clear">
                    <i class="fa fa-search js-search" aria-hidden="true"></i>
                </a>
            </div>

        <?php endif;?>


        <a id="messages_topbar_informer" href="/messages" class="header__open-msg <?php if ($new_messages) echo "has-msg";?>" >
            <span><?php if ($new_messages) echo $new_messages;?></span>
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </a>

    <?php endif;?>
</div>

<!-- блоки, видимые на планшете -->
<img src="/assets__old/img/header__company--logo.png" class="header__logo m-hide">
<div class="header__line m-hide">

    <?php if( isset( $page_header["search_or_link"] ) && is_array( $page_header["search_or_link"] ) && $page_header["search_or_link"]['type'] == 'search' ):?>

        <div class="header__open-search">
            <a href="#search_modal" class="fancybox clear">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
        </div>

    <?php endif;?>

    <div class="header-widget__exchange-value">
        <span class="">$ — <span class="exchange-value__dollar"><?php echo $page_header['usd'];?></span></span>
        <span class="">€ — <span class="exchange-value__euro"><?php echo $page_header['eur'];?></span></span>
    </div>
    <a href="#header__converter" class="widget__convert   header-widget__convert">
        <div class="header-widget__convert-icon">
            <div><i class="fa fa-eur"></i><i class="fa fa-gbp"></i></div>
            <div><i class="fa fa-usd"></i><i class="fa fa-rub"></i></div>
        </div>
    </a>
    <a href="#header__calc"  class="widget__calc  header-widget__calc">
        <i class="fa fa-calculator"></i>
    </a>
</div>



<?php if( isset( $page_header["search_or_link"] ) && is_array( $page_header["search_or_link"] ) && $page_header["search_or_link"]['type'] == 'search' ):?>
    <div id="search_modal" class="modal" tabindex="-1" role="dialog">
        <form action="/<?php echo $page_header["search_or_link"]["target"];?>/find" class="modal-form widget__search--wrap is-fade" method="get" id="">
            <div class="modal__head">

                <div class="modal__head__section">

                    <div class="modal__head__close">
                        <a href="" class="modal__close-btn"><i class="fa fa-times"></i> <span class="m-hide">Отменить</span></a>
                    </div>

                </div>

                <div class="modal__head__section">

                    <div class="modal__head__title">Поиск</div>

                </div>

                <div class="modal__head__section">

                    &nbsp;

                </div>
            </div>



            <div class="" style="padding: 30px 10px;">

                <input style="width: 100%;" type="text" class="js-search__input widget__search input__type-text"   name="query" id="search_<?php echo $page_header["search_or_link"]['target'];?>" autocomplete="off" placeholder="<?php echo $page_header["search_or_link"]['title'];?>">

            </div>

            <div class="modal__body">

                <div class="clear"></div>
            </div>

        </form>

    </div>

<?php endif;?>