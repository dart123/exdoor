<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 15:41
 */
?>

<div class="advpost is-mbtm-30 is-rounded is-box-shadow item-offer-<?php echo $id;?>">
    <a class="ajax__undo_remove_offer after_removing_background is-rounded is-or-link" data-offer-id="<?php echo $id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>
    <?php if ($first_image):?>
        <div class="advpost_bg">
            <div class="ie-cover"></div>
            <img src="/uploads/offers/<?php echo $id;?>/lg1000_<?php echo $first_image;?>" />
        </div>
    <?php endif;?>
    <div class="advpost__icon"><i class="fa fa-bullhorn"></i> Объявление</div>
    <?php if( $is_author ):?>
        <div class="advpost__actions">
            <?php if( $pinned ):?>
                <a href="" class="ajax__pinned_offer slide-out" data-id="<?php echo $id;?>" data-pinned="true">
                    <i class="fas fa-thumbtack"></i>
                    <span class="slide-out__fix is-b-left slide-out__fix--pin"><span>Закреплено</span></span>
                </a>
            <?php else:?>
                <a href="" class="ajax__pinned_offer slide-out" data-id="<?php echo $id;?>" data-pinned="false">
                    <i class="fas fa-thumbtack"></i>
                    <span class="slide-out__fix is-b-left"><span>Закрепить в начале</span></span>
                </a>
            <?php endif;?>
        </div>
    <?php endif;?>
    <div class="advpost__content is-rounded">
        <div class="adv-post__wrapper">
            <!-- ссылка-слой для вызова fancy -->
            <a href="#adv-post<?php echo $id;?>" data-fancybox="adv-group" data-id="<?php echo $id;?>" class="lower-layer fancybox__adv-news"></a>
            <!--    -->

            <div class="advpost__head clear">


                <?php if ( $is_author ):?>
                    <div class="req-item__helpers">
                        <ul class="req-item__actions is-rounded is-box-shadow">
                            <li class="is-first-item ajax__edit_offer" data-offer-id="<?php echo $id;?>">
                                Редактировать
                            </li>
                            <li class="is-last-item ajax__remove_offer" data-offer-id="<?php echo $id;?>">
                                Удалить
                            </li>
                        </ul>
                    </div>
                <?php endif;?>




                <p class="is-blue-text"><b><?php echo $title;?></b></p>

                <?php if ($keywords):?>
                    <p class="is-grey-text"><?php echo $keywords;?></p>
                <?php endif;?>

                <p class="is-or-text offer__price">
                    <?php if ($price != ""):?>
                        <b>
                            <?php echo $price;?>
                            <?php if($max_price): echo '- '.$max_price.' '; endif;?>
                            ₽
                        </b>
                    <?php endif;?>
                    <?php if($barter):?>
                        <?php if( $barter_text ):?>
                            <span class="is-blue-text offers__barter">
                            <span class="tooltip tooltip_offers">
                                <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                Возможен бартер
                                <span class="tooltip__msg is-rounded is-box-shadow is-fade">
                                    <?php echo $barter_text;?>
                                </span>
                            </span>
                        </span>
                        <?php else:?>
                            <span class="is-blue-text offers__barter">
                                <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                Возможен бартер
                            </span>
                        <?php endif;?>
                    <?php endif;?>
                </p>
            </div>
            <?php if($images):?>
                <?php if($slider):?>
                    <div class="advpost__slider-class">
                        <div class="frame js-inner-page-slider-w" data-slider-id="<?php echo $id;?>">
                            <ul>
                                <?php foreach ($images as $img):?>
                                    <li>
                                        <a href="/uploads/offers/<?php echo $id;?>/lg1000_<?php echo $img;?>" class="fancybox-thumb" data-fancybox="fancybox-thumb-<?php echo $id;?>">
                                            <img src="/uploads/offers/<?php echo $id;?>/medium_<?php echo $img;?>" alt="" class="img-responsive">
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                <?php else:?>
                    <?php foreach ($images as $img):?>
                        <a href="/uploads/offers/<?php echo $id;?>/lg1000_<?php echo $img;?>" class="fancybox-thumb" data-fancybox="fancybox-thumb-<?php echo $id;?>">
                            <div class="image__frame-10">
                                <img src="/uploads/offers/<?php echo $id;?>/medium_<?php echo $img;?>" alt="" class="img-responsive">
                            </div>
                        </a>
                    <?php endforeach;?>
                <?php endif;?>
            <?php endif;?>
            <div class="advpost__text">
                <p><?php echo $content;?></p>
            </div>
        </div>
        <div class="advpost__descr is-last-item">
            <div class="advpost__footer-l">
                <a href="/offers/<?php echo $type;?>/?filter=true&type=<?php echo $type;?>&cat[]=<?php echo $category;?>" class="is-blue-link js__real-link">
                    <span><?php echo $category_text;?></span>
                </a> — <?php echo $date;?>
            </div>
            <?php if ( $this->session->user == $author_id ):?>
                <div class="advpost__footer-r advpost__footer-my">
                    <i class="fa fa-circle"></i> Это Ваше объявление
                </div>
            <?php else:?>
                <a class="js-partner__open_chat advpost__footer-r advpost__footer-author" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $author_id;?>"  data-offer-id="<?php echo $id;?>">
                    <div class="is-blue-text">
                        <i class="fas fa-envelope i-left-15"></i>
                        <span>Связаться с автором</span>
                    </div>
                </a>
            <?php endif;?>
        </div>
    </div>
    <div class="advpost--type_label">
        <?php if( $type_buy ):?>Покупка<?php endif;?>
        <?php if( $type_sell ):?>Продажа<?php endif;?>
        <?php if( $type_service ):?>Услуга<?php endif;?>
    </div>
</div>
