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
        <!-- ссылка-слой для вызова fancy -->
        <a href="#adv-post<?php echo $id;?>" data-fancybox="adv-group" data-id="<?php echo $id;?>" class="lower-layer fancybox"></a>
        <!--    -->

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
                                        <img src="/uploads/offers/<?php echo $id;?>/medium_<?php echo $img;?>" class="img-responsive">
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
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
            <a href="" class="is-blue-link"><span><?php echo $category_text;?></span></a> — <?php echo $date;?>
        </div>

        <a class="js-guest__go-login advpost__footer-r advpost__footer-author" href="javascript:void(0)">
            <div class="is-blue-text">
                <i class="fas fa-envelope i-left-15"></i>
                <span>Связаться с автором</span>
            </div>
        </a>

    </div>
</div>

