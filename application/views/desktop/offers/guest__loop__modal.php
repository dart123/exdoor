<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:44
 */

?>

<div id="adv-post<?php echo $id;?>" class="post-wrapper item-offer-<?php echo $id;?>">
    <div class="advpost__content is-rounded">

        <div class="adv-post__wrapper">
            <div class="advpost__head clear">
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

                </p>
            </div>

            <?php if($barter):?>
                <?php if( $barter_text ):?>
                    <div class="advpost__text">
                        <span class="is-blue-text">
                            <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                            Возможен бартер &mdash;
                        </span>
                        <?php echo $barter_text;?>
                    </div>
                <?php else:?>
                    <div class="advpost__text">
                        <span class="is-blue-text">
                            <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                            Возможен бартер
                        </span>
                    </div>
                <?php endif;?>
            <?php endif;?>

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

            <span class="advpost__footer-r advpost__footer-author" style="opacity: .7; cursor: default">
                <div class="is-blue-text">
                    <i class="fas fa-envelope i-left-15"></i>
                    Связаться с автором
                </div>
            </span>

        </div>
    </div>
</div>

