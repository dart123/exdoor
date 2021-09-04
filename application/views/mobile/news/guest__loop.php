<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:01
 */

?>

<div class="is-mbtm-30 news-advpost news-by-exdor item-news-<?php echo $id;?>" id="js__news_list__news_<?php echo $id;?>">
    <div class="news-advpost__block is-rounded is-box-shadow is-mtop-20">
        <div class="news-post__wrapper">

            <div class="news-advpost__head">

                <?php if( $company_news ):?>


                    <?php if( $author->logo ):?>
                        <a href="/company/id<?php echo $author->id;?>" class="news-advpost__exdor-logo is-rounded">
                            <img src="/uploads/companies/<?php echo $author->id;?>/logo/<?php echo $author->logo;?>" class="img-responsive">
                        </a>
                    <?php else:?>
                        <a class="news-advpost__exdor-logo is-rounded">
                            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                        </a>
                    <?php endif;?>
                    <div class="news-advpost-head__descr">
                        <a href="/company/id<?php echo $author->id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                            <span>
                                <b><?php echo $author->short_name;?></b>
                            </span>
                        </a>

                        <div class="news-advpost-head__date">
                            <span><?php echo $date;?></span>
                        </div>
                    </div>





                <?php else:?>



                    <?php if( $author->avatar ):?>
                        <a href="/partners/<?php echo $author->id;?>" class="news-advpost__exdor-logo is-rounded">
                            <img src="/uploads/users/<?php echo $author->id;?>/avatar/80x80_<?php echo $author->avatar;?>" class="img-responsive">
                        </a>
                    <?php else:?>
                        <a class="news-advpost__exdor-logo is-rounded">
                            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                        </a>
                    <?php endif;?>
                    <div class="news-advpost-head__descr">
                        <a href="/partners/<?php echo $author->id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                            <span>
                                <b><?php echo $author->name;?> <?php echo $author->last_name;?></b>
                            </span>
                        </a>

                        <div class="news-advpost-head__date">
                            <span><?php echo $date;?></span>
                        </div>
                    </div>




                <?php endif;?>
            </div>

            <div class="news-advpost__text">
                <?php if( $author->id == 1):?>
                    <div class="exdor__news_html_container">
                        <?php echo $content_html;?>
                        <div class="clear"></div>
                    </div>
                <?php else:?>
                    <?php echo htmlspecialchars_decode( $content );?>
                <?endif;?>
            </div>

            <?php if( $images ):?>
                <?php if ( count($images) == 1 ):?>
                    <?php foreach ($images as $n_img):?>
                        <div class="news__one_image">
                            <img src="/uploads/news/<?php echo $id;?>/lg1000_<?php echo $n_img;?>" class="img-responsive" >
                        </div>
                    <?php endforeach;?>
                <?php elseif ( count($images) == 2 ):?>
                    <div class="news__two_images">
                        <?php foreach ($images as $n_img):?>
                            <div class="news__one_half_image">
                                <img src="/uploads/news/<?php echo $id;?>/medium_<?php echo $n_img;?>" class="img-responsive" >
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php elseif ( count($images) > 2 ):?>
                    <div class="advpost__slider-class">
                        <div class="frame js-inner-page-slider-w" data-slider-id="<?php echo $id;?>">
                            <ul class="clearfix">
                                <?php foreach ($images as $n_img):?>
                                    <li>
                                        <a href="/uploads/news/<?php echo $id;?>/lg1000_<?php echo $n_img;?>" class="fancybox-thumb-w" rel="fancybox-thumb-<?php echo $id;?>">
                                            <img src="/uploads/news/<?php echo $id;?>/medium_<?php echo $n_img;?>" class="img-responsive" >
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <?php if( $this->agent->is_mobile() ):?>
                            <div class="pages"></div>
                        <?php endif;?>
                    </div>
                <?php endif;?>
            <?php endif;?>
        </div>

        <div class="news-post__sub">
            <div class="news-advpost__feedback is-grey-text">
                <div class="feedback__comments">
                    <?php if( $comments_count > 0):?>
                        <i class="fa fa-comment"></i> <span><?php echo $comments_count;?> <?php echo $comments_count_text;?></span>
                    <?php else:?>
                        <i class="fa fa-comment-o"></i> <span><?php echo $comments_count_text;?></span>
                    <?php endif;?>
                </div>
                <div class="feedback__postlike is-fade">
                    <span class="postlike__num"><?php echo $likes;?></span>
                    <i class="fa fa-heart-o"></i>
                 </div>
            </div>

        </div>
    </div>
</div>

