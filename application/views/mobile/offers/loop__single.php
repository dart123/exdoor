<?php
/**
 * Created by developer with PhpStorm.
 * Date: 02/10/2018 12:19
 * 
 * 
 */

?>



<div class="advpost__content advpost__item is-rounded item-offer-<?php echo $id;?>">
    <a class="ajax__undo_remove_offer after_removing_background is-rounded is-or-link" data-offer-id="<?php echo $id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fa fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>
    <div class="adv-post__wrapper">
        <!-- ссылка-слой для вызова fancy -->
        <div class="advpost__head clear">
            <?php if ( $is_author ):?>
                <div class="req-item__helpers">
                    <ul class="req-item__actions is-rounded is-box-shadow">
                        <li class="is-first-item ajax__edit_offer" data-offer-id="<?php echo $id;?>">
                            Редактировать
                        </li>
                        <li class="ajax__remove_offer" data-offer-id="<?php echo $id;?>">
                            Удалить
                        </li>
                        <li class="is-last-item    js__clipboard__copy_link" data-clipboard-text="https://exdor.ru/offers/<?php echo $type;?>/<?php echo $id;?>">
                            Скопировать ссылку
                        </li>
                    </ul>
                </div>
            <?php else:?>
                <p class="offers__share_link is-blue-link        js__clipboard__copy_link" data-clipboard-text="https://exdor.ru/offers/<?php echo $type;?>/<?php echo $id;?>">
                    <i class="fa fa-share"></i>
                </p>
            <?php endif;?>
            <p class="is-blue-text"><b><?php echo $title;?></b></p>

            <?php if ($keywords):?>
                <p class="is-grey-text"><?php echo $keywords;?></p>
            <?php endif;?>
            <?php if ($price != ""):?>
                <p class="is-or-text offer__price">
                    <b>
                        <?php echo $price;?>
                        <?php if($max_price): echo '- '.$max_price.' '; endif;?>
                        ₽
                    </b>
                </p>
            <?php endif;?>

            <?php if($barter):?>
                <p>
                    <?php if( $barter_text ):?>
                        <span class="offers__barter">
                            <span class="is-blue-text">
                                <i class="fa fa-refresh" title="" aria-hidden="true"></i>
                                <span>Возможен бартер:</span>
                            </span>
                            <span class="is-grey-text">
                                <span>
                                    <?php echo $barter_text;?>
                                </span>
                            </span>
                        </span>
                    <?php else:?>
                        <span class="offers__barter">
                            <i class="fa fa-refresh" title="" aria-hidden="true"></i>
                            <span class="is-blue-text">
                                Возможен бартер
                            </span>
                        </span>
                    <?php endif;?>
                </p>
            <?php endif;?>
        </div>
        <?php if($images):?>
            <?php if($slider):?>
                <div class="advpost__slider-class">
                    <div class="frame js-inner-page-slider-w" data-slider-id="<?php echo $id;?>">
                        <ul>
                            <?php foreach ($images as $img):?>
                                <li>
                                    <a href="/uploads/offers/<?php echo $id;?>/lg1000_<?php echo $img;?>" class="fancybox-thumb" rel="fancybox-thumb-<?php echo $id;?>">
                                        <img src="/uploads/offers/<?php echo $id;?>/medium_<?php echo $img;?>" class="img-responsive">
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <?php if( $this->agent->is_mobile() ):?>
                        <div class="pages"></div>
                    <?php endif;?>
                </div>
            <?php else:?>
                <?php foreach ($images as $img):?>
                    <div class="image__frame-10">
                        <img src="/uploads/offers/<?php echo $id;?>/medium_<?php echo $img;?>" class="img-responsive">
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        <?php endif;?>
        <div class="advpost__text">
            <?php echo $content;?>
        </div>
    </div>
    <div class="advpost__descr is-last-item">
        <div class="advpost__footer-l">
            <a href="/offers/<?php echo $type;?>/?filter=true&type=<?php echo $type;?>&cat[]=<?php echo $category;?>" class="is-blue-link"><span><?php echo $category_text;?></span></a> — <?php echo $date;?>
        </div>
        <?php if ( $this->session->user == $author_id ):?>
            <div class="advpost__footer-r advpost__footer-my">
                <i class="fa fa-circle"></i> Это Ваше объявление
            </div>
        <?php else:?>
            <a class="js-partner__open_chat advpost__footer-r advpost__footer-author" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $author_id;?>" data-offer-id="<?php echo $id;?>">
                <div class="is-blue-text">
                    <i class="fa fa-envelope i-left-15"></i>
                    <span>Связаться с автором</span>
                </div>
            </a>
        <?php endif;?>
    </div>
</div>

