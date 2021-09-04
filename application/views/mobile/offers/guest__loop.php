<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:43
 */
?>




<div class="advpost__content advpost__item is-rounded item-offer-<?php echo $id;?>">

    <div class="adv-post__wrapper">

        <div class="advpost__head clear">

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

        <a href="/?action=author_connect" class="advpost__footer-r advpost__footer-author">
            <div class="is-blue-text">
                <i class="fa fa-envelope i-left-15"></i>
                <span>Связаться с автором</span>
            </div>
        </a>

    </div>
</div>

