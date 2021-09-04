<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.10.16
 * Time: 23:13
 */
?>


<main>
    <div class="js-user-info"
        <?php if($user->avatar):?>
            data-avatar="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>"
        <?php else:?>
            data-avatar="/assets/img/news-advpost-head__photo--empty.jpg"
        <?php endif;?>

        <?php if ($user->name || $user->last_name):?>
         data-name="<?php echo $user->name;?> <?php echo $user->last_name;?>">
        <?php else:?>
            data-name="<?php echo $user->phone;?>">
        <?php endif;?>
    </div>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <!-- Контент -->
        <section class="page-content">
            <div class="sub-menu">
                <ul class="sub-menu__list">
                    <li><a href="/news" class="sub-menu__news-item is-fade">Все новости</a></li>
                    <li><a href="/news/exdor" class="sub-menu__news-item active sub-menu__exdor-item is-fade">Новости проекта</a></li>
                </ul>
                <!--
                <a href="#add-news" class="fancybox clear sub-menu__add-news or-btn btn btn-info ripple-effect">
                    <i class="fas fa-plus"></i>
                    Добавить новость
                </a>
                -->
            </div>

            <!--  Пост от Exdor  -->

            <div class="ajax-news-container">
                <?php foreach ($news as $news_item):
                    $last_loaded_news   = $news_item->id;
                    ?>
                    <div class="news-advpost news-by-exdor">
                        <div class="news-advpost__block is-mbtm-30 is-rounded is-box-shadow is-mtop-20">
                            <div class="news-post__wrapper">
                                <!-- ссылка-слой для вызова fancy -->
                                <a href="#news-post<?php echo $news_item->id;?>" data-fancybox="news-group" class="lower-layer fancybox__adv-news"></a>
                                <!--    -->

                                <div class="news-advpost__head">
                                    <div class="req-item__helpers">
                                        <ul class="req-item__actions is-rounded is-box-shadow">
                                            <li class="is-first-item">Редактировать</li>
                                            <li class="is-last-item">Удалить</li>
                                        </ul>
                                    </div>
                                    <?php if( $news_item->avatar ):?>
                                        <a href="/partners/<?php echo $news_item->author_id;?>" class="news-advpost__exdor-logo is-rounded">
                                            <img src="/uploads/users/<?php echo $news_item->author_id;?>/avatar/80x80_<?php echo $news_item->avatar;?>" class="img-responsive">
                                        </a>
                                    <?php else:?>
                                        <a class="news-advpost__exdor-logo is-rounded">
                                            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                        </a>
                                    <?php endif;?>
                                    <div class="news-advpost-head__descr">
                                        <a href="/partners/<?php echo $news_item->author_id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                        <span>
                            <b><?php echo $news_item->name;?> <?php echo $news_item->last_name;?></b>
                        </span>
                                        </a>

                                        <a href="#news-post<?php echo $news_item->id;?>" data-fancybox="news-group" class="news-advpost-head__date fancybox__adv-news">
                                            <i class="far fa-newspaper i-left-20"></i>
                                            <span><b><?php echo $news_item->date;?></b></span>
                                        </a>
                                    </div>
                                </div>

                                <div class="news-advpost__text">
                                    <p>
                                        <?php echo $news_item->content;?>
                                    </p>
                                </div>

                                <?php if( $news_item->images ):?>
                                    <?php if ( count($news_item->images) == 1 ):?>
                                        <?php foreach ($news_item->images as $n_img):?>
                                            <div class="news-advpost__big-img">
                                                <img src="/uploads/news/<?php echo $news_item->id;?>/<?php echo $n_img;?>" alt="">
                                            </div>
                                        <?php endforeach;?>
                                    <?php elseif ( count($news_item->images) > 1 ):?>
                                        <div class="advpost__slider-class">
                                            <div class="frame" id="inner-page-slider-w" style="overflow: hidden;">
                                                <ul class="clearfix" style="transform: translateZ(0px) translateX(-939px); width: 1878px;">
                                                    <?php foreach ($news_item->images as $n_img):?>
                                                        <li>
                                                            <a href="/uploads/news/<?php echo $news_item->id;?>/<?php echo $n_img;?>" class="fancybox-thumb-w" data-fancybox="fancybox-thumb">
                                                                <img src="/uploads/news/<?php echo $news_item->id;?>/<?php echo $n_img;?>" alt="">
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
                                    <div class="feedback__comments">
                                        <?php if( $news_item->comments_count > 0):?>
                                            <i class="fas fa-comment"></i> <?php echo $news_item->comments_count;?> <?php echo $news_item->comments_count_text;?> <?php if($news_item->comments_count > 5):?><a class="js-show-all-comments show-all-comments" data-news-id="<?php echo $news_item->id;?>">(показать все)</a><?php endif;?>
                                        <?php else:?>
                                            <i class="far fa-comment"></i> <?php echo $news_item->comments_count_text;?>
                                        <?php endif;?>
                                    </div>
                                    <div class="feedback__postlike is-fade" data-news-id="<?php echo $news_item->id;?>" data-user-id="<?php echo $user->id;?>">
                                        <span class="postlike__num"><?php echo $news_item->likes;?></span>
                                        <?php if ($news_item->liked):?>
                                            <i class="fas fa-heart"></i>
                                        <?php else:?>
                                            <i class="far fa-heart"></i>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <div class="news_<?php echo $news_item->id;?>_replys">
                                    <?php if ($news_item->comments):?>
                                        <?php foreach ( $news_item->comments as $comment):
                                            ?>
                                            <div class="reply clear">
                                                <!-- нижний слой для клика по всему блоку   -->
                                                <a class="lower-layer" data-name="<?php echo $comment->name;?>, " data-news-id="<?php echo $news_item->id;?>"></a>
                                                <?php if($comment->avatar):?>
                                                    <a href="/partners/<?php echo $comment->user_id;?>" class="reply__image is-rounded">
                                                        <img src="/uploads/users/<?php echo $comment->user_id;?>/avatar/80x80_<?php echo $comment->avatar;?>" class="img-responsive">
                                                    </a>
                                                <?php else:?>
                                                    <a href="/partners/<?php echo $comment->user_id;?>" class="reply__image is-rounded">
                                                        <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                                                    </a>
                                                <?php endif;?>
                                                <div class="reply__content">
                                                    <a href="/partners/<?php echo $comment->user_id;?>" class="is-blue-link"><span><b><?php echo $comment->name;?> <?php echo $comment->last_name;?></b></span></a>
                                                    <div class="reply__text"><?php echo $comment->comment;?></div>
                                                </div>
                                                <div class="reply__date">
                                                    <?php echo $comment->date;?>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </div>



                                <!--  Добавить комментарий  -->
                                <div class="news-advpost__form is-last-item clear">
                                    <a href="/partners/<?php echo $user->id;?>" class="reply__form-image is-rounded">
                                        <?php if( $user->avatar ):?>
                                            <img class="author_avatar img-responsive" src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" alt="">
                                        <?php else:?>
                                            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                                        <?php endif;?>
                                    </a>
                                    <div class="reply__form-box">
                                        <textarea class="reply__area is-rounded news-<?php echo $news_item->id;?>-replay" placeholder="Оставить комментарий"></textarea>

                                        <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                        <input type="submit" class="reply__submit is-rounded ajax-news-leave-comment" value="Отправить" data-news-id="<?php echo $news_item->id;?>" data-author-id="<?php echo $user->id;?>">
                    </span>
                                    </div>
                                </div>
                                <!--    -->
                            </div>
                        </div>
                    </div>

                <?php endforeach;?>
            </div>

            <div class="load-more">
                <div class="cssload-container">
                    <div class="cssload-whirlpool"></div>
                </div>
                <span>Подгружаю ещё</span>
            </div>
        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>

        <!--  Создать новость  -->
        <div id="add-news" class="modal is-rounded">
            <div class="modal__head is-rounded">
                <div class="modal__title">Добавить новость</div>
                <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="author_id" id="ajax-input-author_id" value="<?php echo $user->id;?>">
                <div class="modal__body">
                    <div class="textarea--pre">
                        <textarea name="content" id="add-news__textarea" class="add-news__area is-rounded limit-1000" placeholder="Текст Вашей новости" maxlength="1000"></textarea>
                        <span class="textarea-count-label textarea-count is-lblue-text">1000</span>
                    </div>

                    <!-- загрузка фото -->
                    <div class="clear">
                        <input type="file" accept="image/jpeg,image/png*" id="fileElem" multiple="" style="display:none" onchange="handleFiles(this.files);" class="active">
                        <a href="#" id="fileSelect" class="is-blue-link add-requests__label" onclick="uploadImg(event);">
                            <i class="fa fa-paperclip i-left-20"></i>
                            <span>Прикрепить фото</span>
                        </a>
                        <ul id="filelist" class="сlear"></ul>
                    </div>
                    <!-- -->
                </div>
                <div class="modal__footer">
            <span class="add-news__submit--wrap is-last-item btn ripple-effect btn-primary2">
                <i class="fas fa-check"></i>
                <input type="submit" class="add-news__submit " value="Опубликовать">
            </span>
                </div>
            </form>
        </div>
        <!-- end Создать новость -->



        <?php foreach ($news as $news_item):
            ?>
            <!-- Новость news-post321 -->
            <div id="news-post<?php echo $news_item->id;?>" class="post-wrapper">
                <div class="news-advpost__block is-rounded is-box-shadow is-mtop-20">
                    <div class="news-post__wrapper">
                        <!-- ссылка-слой для вызова fancy -->
                        <!--    -->

                        <div class="news-advpost__head">
                            <div class="req-item__helpers">
                                <ul class="req-item__actions is-rounded is-box-shadow">
                                    <li class="is-first-item">Редактировать</li>
                                    <li class="is-last-item">Удалить</li>
                                </ul>
                            </div>
                            <?php if( $news_item->avatar ):?>
                                <a href="/partners/<?php echo $news_item->author_id;?>"  class="news-advpost__exdor-logo is-rounded">
                                    <img src="/uploads/users/<?php echo $news_item->author_id;?>/avatar/80x80_<?php echo $news_item->avatar;?>" style="width: 100%; height: auto">
                                </a>
                            <?php else:?>
                                <a href="/partners/<?php echo $news_item->author_id;?>"  class="news-advpost__exdor-logo is-rounded">
                                    <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                </a>
                            <?php endif;?>
                            <div class="news-advpost-head__descr">
                                <a href="<?php echo $news_item->author_id;?>" class="news-advpost-head__comname is-blue-link is-long-row">
                                    <span><b><?php echo $news_item->name;?> <?php echo $news_item->last_name;?></b></span>
                                </a>

                                <div class="news-advpost-head__date">
                                    <i class="far fa-newspaper i-left-20"></i>
                                    <span><b><?php echo $news_item->date;?></b></span>
                                </div>
                            </div>
                        </div>


                        <div class="news-advpost__text">
                            <p>
                                <?php echo $news_item->content;?>
                            </p>
                        </div>

                        <?php if( $news_item->images ):?>
                            <?php if ( count($news_item->images) == 1 ):?>
                                <?php foreach ($news_item->images as $n_img):?>
                                    <div class="news-advpost__big-img">
                                        <img src="/uploads/news/<?php echo $news_item->id;?>/<?php echo $n_img;?>" alt="">
                                    </div>
                                <?php endforeach;?>
                            <?php elseif ( count($news_item->images) > 1 ):?>
                                <div class="advpost__slider-class">
                                    <div class="frame" id="inner-page-slider-w" style="overflow: hidden;">
                                        <ul class="clearfix" style="transform: translateZ(0px) translateX(-939px); width: 1878px;">
                                            <?php foreach ($news_item->images as $n_img):?>
                                                <li>
                                                    <a href="/uploads/news/<?php echo $news_item->id;?>/<?php echo $n_img;?>" class="fancybox-thumb-w" data-fancybox="fancybox-thumb">
                                                        <img src="/uploads/news/<?php echo $news_item->id;?>/<?php echo $n_img;?>" alt="">
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
                            <div class="feedback__comments">
                                <?php if( $news_item->comments_count > 0):?>
                                    <i class="fas fa-comment"></i> <?php echo $news_item->comments_count;?> <?php echo $news_item->comments_count_text;?> (показать все)
                                <?php else:?>
                                    <i class="far fa-comment"></i> <?php echo $news_item->comments_count_text;?>
                                <?php endif;?>
                            </div>
                            <div class="feedback__postlike is-fade">
                                <span class="postlike__num"><?php echo $news_item->likes;?></span>
                                <i class="far fa-heart"></i>
                                <i class="fas fa-heart hidden-like"></i>
                            </div>
                        </div>
                        <div class="news_<?php echo $news_item->id;?>_replys">
                            <?php if ($news_item->comments):?>
                                <?php foreach ( $news_item->comments as $comment): ?>
                                    <div class="reply clear">
                                        <!-- нижний слой для клика по всему блоку   -->
                                        <a href="" class="lower-layer" data-name="<?php echo $comment->name;?>, " data-news-id="<?php echo $news_item->id;?>"></a>
                                        <?php if($comment->avatar):?>
                                            <a href="/partners/<?php echo $comment->user_id;?>" class="reply__image is-rounded">
                                                <img src="/uploads/users/<?php echo $comment->user_id;?>/avatar/80x80_<?php echo $comment->avatar;?>" style="width: 100%; height: auto">
                                            </a>
                                        <?php endif;?>
                                        <div class="reply__content">
                                            <a href="/partners/<?php echo $comment->user_id;?>" class="is-blue-link"><span><b><?php echo $comment->name;?> <?php echo $comment->last_name;?></b></span></a>
                                            <div class="reply__text"><?php echo $comment->comment;?></div>
                                        </div>
                                        <div class="reply__date">
                                            <?php echo $comment->date ;?>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
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
                                <textarea class="reply__area is-rounded news-<?php echo $news_item->id;?>-replay" placeholder="Оставить комментарий"></textarea>
                                <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                        <input type="submit" class="reply__submit is-rounded ajax-news-leave-comment" value="Отправить" data-news-id="<?php echo $news_item->id;?>" data-author-id="<?php echo $user->id;?>">
                    </span>
                            </div>
                        </div>
                        <!--    -->
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        <!-- Новость news-post321 -->

    </div>
</main>

<input type="hidden" id="ajax-news-user_id" value="<?php echo $user->id;?>">
<input type="hidden" id="ajax-last_loaded_news" value="<?php echo $last_loaded_news;?>">


<?php
/*
  *
  *
  *
  *     Шаблоны для вывода json to html
  *
  *
  *
  */
?>
<script type="text/html" id="mustache__news_item">

    {{#.}}

    <div class="news-advpost">
        <div class="news-advpost__block is-mbtm-30 is-rounded is-box-shadow is-mtop-20">
            <div class="news-post__wrapper">
                <!-- ссылка-слой для вызова fancy -->
                <a href="#news-post{{id}}" data-fancybox="news-group" class="lower-layer fancybox__adv-news"></a>
                <!--    -->

                <div class="news-advpost__head">
                    <div class="req-item__helpers">
                        <ul class="req-item__actions is-rounded is-box-shadow">
                            <li class="is-first-item">Редактировать</li>
                            <li class="is-last-item">Удалить</li>
                        </ul>
                    </div>
                    {{#avatar}}
                    <a href="/partners/{{author_id}}"  class="news-advpost__exdor-logo is-rounded">
                        <img src="/uploads/users/{{author_id}}/avatar/80x80_{{avatar}}" class="img-responsive">
                    </a>
                    {{/avatar}}
                    {{^avatar}}
                    <a class="news-advpost__exdor-logo is-rounded">
                        <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                    </a>
                    {{/avatar}}
                    <div class="news-advpost-head__descr">
                        <a href="/partners/{{author_id}}" class="news-advpost-head__comname is-blue-link is-long-row">
                        <span>
                            <b>{{name}} {{last_name}}</b>
                        </span>
                        </a>

                        <a href="#news-post{{id}}" data-fancybox="news-group" class="news-advpost-head__date fancybox__adv-news">
                            <i class="far fa-newspaper i-left-20"></i>
                            <span><b>{{date}}</b></span>
                        </a>
                    </div>
                </div>


                <div class="news-advpost__text">
                    <p>
                        {{content}}
                    </p>
                </div>

                {{#images}}
                <br>
                {{#.}}
                <img src="/uploads/news/{{id}}/{{.}}" class="img-responsive">
                <br>
                {{/.}}
                {{/images}}


            </div>

            <div class="news-post__sub">
                <div class="news-advpost__feedback is-grey-text">
                    <div class="feedback__comments">
                        {{#comments_count}}
                        <i class="fas fa-comment"></i> {{comments_count}} {{comments_count_text}} {{#if_comments_count}}<a class="js-show-all-comments show-all-comments" data-news-id="{{id}}">(показать все)</a>{{/if_comments_count}}
                        {{/comments_count}}
                        {{^comments_count}}
                        <i class="far fa-comment"></i> {{comments_count_text}}
                        {{/comments_count}}
                    </div>
                    <div class="feedback__postlike is-fade" data-news-id="{{id}}" data-user-id="<?php echo $user->id;?>">
                        <span class="postlike__num">{{likes}}</span>
                        {{#liked}}
                        <i class="fas fa-heart"></i>
                        {{/liked}}
                        {{^liked}}
                        <i class="far fa-heart"></i>
                        {{/liked}}
                    </div>
                </div>

                <div class="news_{{id}}_replys">
                    {{#comments}}
                    <div class="reply clear">
                        <!-- нижний слой для клика по всему блоку   -->
                        <a class="lower-layer" data-name="{{name}}, " data-news-id="{{news_id}}"></a>
                        {{#avatar}}
                        <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
                            <img src="/uploads/users/{{user_id}}/avatar/80x80_{{avatar}}" class="img-responsive">
                        </a>
                        {{/avatar}}
                        {{^avatar}}
                        <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
                            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                        </a>
                        {{/avatar}}

                        <div class="reply__content">
                            <a href="/partners/{{user_id}}" class="is-blue-link">
                                    <span>
                                        <b>
                                            {{name}} {{last_name}}
                                        </b>
                                    </span>
                            </a>
                            <div class="reply__text">{{comment}}</div>
                        </div>
                        <div class="reply__date">
                            {{date}}
                        </div>
                    </div>
                    {{/comments}}
                </div>


                <!--  Добавить комментарий  -->
                <div class="news-advpost__form is-last-item clear">
                    <a href="/partners/<?php echo $user->id;?>" class="reply__form-image is-rounded">
                        <?php if( $user->avatar ):?>
                            <img class="author_avatar img-responsive" src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" alt="">
                        <?php else:?>
                            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                        <?php endif;?>
                    </a>
                    <div class="reply__form-box">
                        <textarea class="reply__area is-rounded news-{{id}}-replay" placeholder="Оставить комментарий"></textarea>

                        <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" class="reply__submit is-rounded ajax-news-leave-comment" value="Отправить" data-news-id="{{id}}" data-author-id="<?php echo $user->id;?>">
                        </span>
                    </div>
                </div>
                <!--    -->
            </div>
        </div>
    </div>
    {{/.}}

</script>


<script type="text/html" id="mustache__news_comments">
    {{#.}}
    <div class="reply clear">
        <a href="" class="lower-layer" data-name="{{name}}, " data-news-id="{{id}}"></a>
        {{#avatar}}
        <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
            <img src="/uploads/users/{{user_id}}/avatar/80x80_{{avatar}}" class="img-responsive">
        </a>
        {{/avatar}}
        {{^avatar}}
        <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
        </a>
        {{/avatar}}



        <div class="reply__content">
            <a href="/partners/{{user_id}}" class="is-blue-link">
                <span><b>{{name}} {{last_name}}</b></span>
            </a>
            <div class="reply__text">{{comment}}</div>
        </div>
        <div class="reply__date">{{date}}</div>
    </div>
    {{/.}}
</script>



<script>
    $(document).ready(function () {

        $('body').on( 'click', '.lower-layer', function () {
            var news_id = $(this).attr('data-news-id'),
                name    = $(this).attr('data-name');

            $('.news-'+news_id+ '-replay').val( name ).closest('div.news-advpost__form').addClass('show-reply');
        });

        $(window).scroll(function () {
            var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();

            if (scrollBottom == 0) {
                var last_loaded_news     = $('#ajax-last_loaded_news').val();

                $.post('/ajax/load_news',
                    { 'user_id':1, 'last_loaded_news': last_loaded_news, 'limit': 1 },
                    function(result) {
                        if (result) {

                            var data = $.parseJSON(result);
                            if (data) {
                                var template = $('#mustache__news_item').html(),
                                    output = Mustache.render(template, data);
                                $('.ajax-news-container').append(output);

                                data.forEach(function(item, i, data) {
                                    $('#ajax-last_loaded_news').val(item.id)
                                });
                            } else {
                                $('.load-more').hide();
                                $('.notify-trigger--alert').attr('data-notifyTitle', "Это все новости")
                                    .attr('data-notifyText',  'Вы загрузили все последние новости')
                                    .click();
                            }
                        }
                    }
                );
            }
        });



        $('body').on('click', '.js-show-all-comments', function (event) {

            var news_id     = $(this).attr('data-news-id'),
                this_obj    = $(this);

            $.post('/ajax/load_all_comments',
                { 'news_id': news_id },
                function(result) {
                    var data = $.parseJSON(result);
                    if (data) {
                        var template = $('#mustache__news_comments').html(),
                            output = Mustache.render(template, data);
                        $('.news_'+news_id+'_replys').prepend(output);
                        this_obj.hide();
                    }
                }
            );
        })
    });
</script>



