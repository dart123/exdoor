<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 15:54
 */
?>
<div id="adv-post<?php echo $id;?>" class="post-wrapper item-offer-<?php echo $id;?>">
    <div class="advpost__content is-rounded">
        <a class="ajax__undo_remove_offer after_removing_background is-rounded is-or-link" data-offer-id="<?php echo $id;?>">
            <div class="like_table">
                <div class="like_td">
                    <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                    <p><span>Восстановить</span></p>
                </div>
            </div>
        </a>
        <div class="adv-post__wrapper">

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
                                <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                Возможен бартер
                            </span>
                            <span class="is-black-text"> &mdash; <?php echo $barter_text;?> </span>
                        <?php else:?>
                            <span class="is-blue-text offers__barter">
                                <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                Возможен бартер
                            </span>
                        <?php endif;?>
                    <?php endif;?>

                </p>
            </div>


            <div class="advpost__text">
                <?php echo $content;?>
            </div>



            <?php if($images):?>
                <div class="news_offers__modal_images">
                    <?php foreach ($images as $img):?>
                        <img src="/uploads/offers/<?php echo $id;?>/lg1000_<?php echo $img;?>" alt="" class="img-responsive">
                    <?php endforeach;?>
                </div>
            <?php endif;?>

        </div>
        <div class="advpost__descr is-last-item">
            <div class="advpost__footer-l">
                <a href="/offers/<?php echo $type;?>?filter=true&type=<?php echo $type;?>&cat[]=<?php echo $category;?>" class="is-blue-link js__real-link">
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
</div>
