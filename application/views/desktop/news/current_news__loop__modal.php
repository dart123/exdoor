<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.12.16
 * Time: 21:58
 */
?>


<div id="news-post<?php echo $id;?>" class="post-wrapper item-news-<?php echo $id;?>">
    <a class="ajax__undo_remove_news after_removing_background is-or-link" data-news-id="<?php echo $id;?>">
        <div class="like_table">
            <div class="like_td">
                <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                <p><span>Восстановить</span></p>
            </div>
        </div>
    </a>
    <div class="news-advpost__block is-rounded is-box-shadow is-mtop-20">
        <div class="news-post__wrapper">
            <div class="news-advpost__head">
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
                <?php if( $avatar ):?>
                    <a href="/partners/<?php echo $author_id;?>"  class="news-advpost__exdor-logo is-rounded">
                        <img src="/uploads/users/<?php echo $author_id;?>/avatar/80x80_<?php echo $avatar;?>" style="width: 100%; height: auto">
                    </a>
                <?php else:?>
                    <a href="/partners/<?php echo $author_id;?>"  class="news-advpost__exdor-logo is-rounded">
                        <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                    </a>
                <?php endif;?>
                <div class="news-advpost-head__descr">
                    <a href="<?php echo $author_id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                        <span><b><?php echo $name;?> <?php echo $last_name;?></b></span>
                    </a>

                    <div class="news-advpost-head__date">
                        <i class="far fa-newspaper i-left-20"></i>
                        <span><b><?php echo $date;?></b></span>
                    </div>
                </div>
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
                <?php foreach ($images as $n_img):?>
                    <div class="news__one_image">
                        <a href="/uploads/news/<?php echo $id;?>/<?php echo $n_img;?>" class="fancybox-thumb" data-fancybox="fancybox-thumb-modal-current-news">
                            <img src="/uploads/news/<?php echo $id;?>/large_r_<?php echo $n_img;?>" class="img-responsive" >
                        </a>
                    </div>
                <?php endforeach;?>
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
                    <span class="postlike__num"><?php echo $likes;?></span>
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
            <div class="news-advpost__form is-last-item clear">
                <a href="/partners/<?php echo $user->id;?>" class="reply__form-image is-rounded">
                    <?php if( $user->avatar ):?>
                        <img src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" class="img-responsive" alt="">
                    <?php else:?>
                        <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                    <?php endif;?>
                </a>
                <div class="reply__form-box">
                    <textarea class="reply__area is-rounded news-<?php echo $id;?>-replay" placeholder="Оставить комментарий" data-news-id="<?php echo $id;?>" data-author-id="<?php echo $user->id;?>"></textarea>
                    <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                        <input type="submit" class="reply__submit is-rounded ajax-news-leave-comment" value="Отправить" data-news-id="<?php echo $id;?>" data-author-id="<?php echo $user->id;?>">
                    </span>
                </div>
            </div>
            <!--    -->
        </div>
    </div>
</div>

