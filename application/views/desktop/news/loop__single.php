<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.08.17
 * Time: 21:50
 */
?>
<div class="news-advpost news-by-exdor item-news-<?php echo $id;?>" id="js__news_list__news_<?php echo $id;?>">
    <a class="ajax__undo_remove_news after_removing_background is-rounded is-or-link" data-news-id="<?php echo $id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>
    <div class="news-advpost__block is-mbtm-30 is-rounded is-box-shadow">
        <div class="news-post__wrapper">

            <div class="news-advpost__head">

                <?php if( $author->id == 1 ):?>

                    <?php if( $author->avatar ):?>
                        <a href="/partners/<?php echo $author->id;?>" class="news-advpost__exdor-logo is-rounded">
                            <img src="/uploads/users/<?php echo $author->id;?>/avatar/80x80_<?php echo $author->avatar;?>" class="img-responsive">
                        </a>
                    <?php endif;?>
                    <div class="news-advpost-head__descr">
                        <a href="/news/<?php echo $taxonomy_public_url;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                            <span>
                                <b><?php echo $taxonomy_public_title;?></b>
                            </span>
                        </a>

                        <a href="#news-post<?php echo $id;?>" data-fancybox="news-group-b" data-id="<?php echo $id;?>" class="news-advpost-head__date fancybox__adv-news">
                            <i class="far fa-newspaper i-left-20"></i>
                            <span><b><?php echo $date;?></b></span>
                        </a>
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
                            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                        </a>
                    <?php endif;?>
                    <div class="news-advpost-head__descr">
                        <a href="/company/id<?php echo $author->id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                            <span>
                                <b><?php echo $author->short_name;?></b>
                            </span>
                        </a>

                        <span class="news-advpost-head__date">
                            <i class="far fa-newspaper i-left-20"></i>
                            <span><?php echo $date;?></span>
                        </span>
                    </div>





                <?php else:?>




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
                            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                        </a>
                    <?php endif;?>
                    <div class="news-advpost-head__descr">
                        <a href="/partners/<?php echo $author->id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                            <span>
                                <b><?php echo $author->name;?> <?php echo $author->last_name;?></b>
                            </span>
                        </a>

                        <span class="news-advpost-head__date">
                            <i class="far fa-newspaper i-left-20"></i>
                            <span><?php echo $date;?></span>
                        </span>
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
                                        <a href="/uploads/news/<?php echo $id;?>/lg1000_<?php echo $n_img;?>" class="fancybox-thumb-w" data-fancybox="fancybox-thumb-<?php echo $id;?>">
                                            <img src="/uploads/news/<?php echo $id;?>/medium_<?php echo $n_img;?>" class="img-responsive" >
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                <?php endif;?>
            <?php endif;?>
        </div>

        <div class="news-post__sub">
            <div class="news-advpost__feedback is-grey-text">
                <div class="feedback__comments" data-news-id="<?php echo $id;?>" data-user-id="<?php echo $user->id;?>">
                    <?php if( $comments_count > 0):?>
                        <i class="fas fa-comment"></i> <span><?php echo $comments_count;?> <?php echo $comments_count_text;?></span> <?php if($comments_count > 5):?><a class="js-show-all-comments show-all-comments" data-news-id="<?php echo $id;?>">(показать все)</a><?php endif;?>
                    <?php else:?>
                        <i class="far fa-comment"></i> <span><?php echo $comments_count_text;?></span>
                    <?php endif;?>
                </div>
                <div class="feedback__postlike is-fade" data-news-id="<?php echo $id;?>" data-user-id="<?php echo $user->id;?>">
                    <span class="postlike__num" data-likes-count="<?php echo $likes;?>" data-is-liked="<?php if($liked):?>1<?php else:?>0<?php endif;?>"><?php echo $likes;?></span>
                    <?php if ($liked):?>
                        <i class="fas fa-heart"></i>
                    <?php else:?>
                        <i class="far fa-heart"></i>
                    <?php endif;?>
                </div>
            </div>

            <div class="news_<?php echo $id;?>_replys">
                <?php
                if ($comments):
                    foreach ( $comments as $comment):
                        $this->load->view('desktop/news/loop__comments', array('news_id' => $id, 'comment' => $comment, ) );
                    endforeach;
                endif;
                ?>
            </div>



            <!--  Добавить комментарий  -->
            <div class="news-advpost__form is-last-item">
                <a href="/partners/<?php echo $user->id;?>" class="reply__form-image is-rounded">
                    <?php if( $user->avatar ):?>
                        <img class="author_avatar img-responsive" src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" alt="">
                    <?php else:?>
                        <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                    <?php endif;?>
                </a>
                <div class="reply__form-box">
                    <textarea class="js__news__add_comment reply__area is-rounded news-<?php echo $id;?>-replay" placeholder="Оставить комментарий" data-news-id="<?php echo $id;?>" data-author-id="<?php echo $user->id;?>"></textarea>

                    <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                        <input type="submit" class="reply__submit is-rounded ajax-news-leave-comment" value="Отправить" data-news-id="<?php echo $id;?>" data-author-id="<?php echo $user->id;?>">
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>
