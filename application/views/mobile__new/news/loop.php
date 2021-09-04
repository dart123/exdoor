<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 13.04.2018
 * Time: 20:36
 */
?>


<div class="news-advpost advpost__item news-by-exdor item-news-<?php echo $id;?>" id="js__news_list__news_<?php echo $id;?>">

    <a class="ajax__undo_remove_news after_removing_background is-rounded is-or-link" data-news-id="<?php echo $id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fa fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>


    <div class="news-advpost__block is-rounded is-box-shadow">
        <div class="news-post__wrapper">
            <!-- ссылка-слой для вызова fancy -->
            <a href="/news/<?php echo $id;?>"  data-id="<?php echo $id;?>" class="lower-layer"></a>
            <!--    -->

            <div class="news-advpost__head">

                <?php if( $author->id == 1 ):?>

                    <?php if( $author->avatar ):?>
                        <a href="/partners/<?php echo $author->id;?>" class="news-advpost__exdor-logo is-rounded">
                            <img src="<?php echo $taxonomy_public_icon;?>" class="img-responsive">
                        </a>
                    <?php endif;?>

                    <div class="news-advpost-head__descr">
                        <a href="/news/<?php echo $taxonomy_public_url;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                            <span>
                                <b><?php echo $taxonomy_public_title;?></b>
                            </span>
                        </a>

                        <div class="news-advpost-head__date">
                            <span><?php echo $date;?></span>
                        </div>
                    </div>


                <?php elseif( $company_news ):?>

                    <?php if( $is_author ):?>
                        <div class="req-item__helpers">
                            <ul class="req-item__actions is-rounded is-box-shadow">
                                <?php if( $editable ):?>
                                    <li class="ajax__news_edit is-first-item" data-id="<?php echo $id;?>">Редактировать</li>
                                <?php endif;?>
                                <li class="ajax__news_remove is-last-item" data-id="<?php echo $id;?>">Удалить</li>
                            </ul>
                        </div>
                    <?php endif;?>
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





                <?php elseif( $author ):?>

                    <?php if( $is_author ):?>
                        <div class="req-item__helpers">
                            <ul class="req-item__actions is-rounded is-box-shadow">
                                <?php if( $editable ):?>
                                    <li class="ajax__news_edit is-first-item" data-id="<?php echo $id;?>">Редактировать</li>
                                <?php endif;?>
                                <li class="ajax__news_remove is-last-item" data-id="<?php echo $id;?>">Удалить</li>
                            </ul>
                        </div>
                    <?php endif;?>
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

            <div class="news-advpost__text pointer">
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

                                        <img src="/uploads/news/<?php echo $id;?>/medium_<?php echo $n_img;?>" class="img-responsive" >

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

                <div class="feedback__comments" data-news-id="<?php echo $id;?>" data-user-id="<?php echo $page_content["user"]->id;?>">
                    <?php if( $comments_count > 0):?>
                        <a href="/news/<?php echo $id;?>#comments" class="is-grey-link">
                            <i class="fa fa-comment"></i> <span><?php echo $comments_count;?> <?php echo $comments_count_text;?></span>
                        </a>
                    <?php else:?>
                        <i class="fa fa-comment"></i> <span><?php echo $comments_count_text;?></span>
                    <?php endif;?>
                </div>


                <div class="feedback__postlike is-fade" data-news-id="<?php echo $id;?>" data-user-id="<?php echo $page_content["user"]->id;?>">
                    <span class="postlike__num" data-likes-count="<?php echo $likes;?>" data-is-liked="<?php if($liked):?>1<?php else:?>0<?php endif;?>" ><?php echo $likes;?></span>
                    <?php if ($liked):?>
                        <i class="fa fa-heart"></i>
                    <?php else:?>
                        <i class="fa fa-heart"></i>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

