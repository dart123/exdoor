<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 18:43
 */
?>
<script type="text/html" id="mustache__news_loop">

    {{#.}}

    <div class="news-advpost advpost__item item-news-{{id}}" id="js__news_list__news_{{id}}">

        <a class="ajax__undo_remove_news after_removing_background is-rounded is-or-link" data-news-id="{{id}}">
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
                <a href="/news/{{id}}" data-id="{{id}}" class="lower-layer"></a>
                <!--    -->

                <div class="news-advpost__head">

                    {{#company_news}}

                            {{#is_author}}
                                <div class="req-item__helpers">
                                    <ul class="req-item__actions is-rounded is-box-shadow">
                                        {{#editable}}
                                        <li class="ajax__news_edit is-first-item" data-id="{{id}}">Редактировать</li>
                                        {{/editable}}
                                        <li class="ajax__news_remove is-last-item" data-id="{{id}}">Удалить</li>
                                    </ul>
                                </div>
                            {{/is_author}}
                            {{#author}}
                                {{#logo}}
                                    <a href="/company/id{{id}}"  class="news-advpost__exdor-logo is-rounded">
                                        <img src="/uploads/companies/{{id}}/logo/{{logo}}" class="img-responsive">
                                    </a>
                                {{/logo}}
                                {{^logo}}
                                <a class="news-advpost__exdor-logo is-rounded">
                                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                </a>
                                {{/logo}}
                            {{/author}}
                            <div class="news-advpost-head__descr">
                                {{#author}}
                                    <a href="/company/id{{id}}" class="news-advpost-head__comname is-blue-link is-long-row">
                                    <span>
                                        <b>{{short_name}}</b>
                                    </span>
                                    </a>
                                {{/author}}
                                <div class="news-advpost-head__date">
                                    <span>{{date}}</span>
                                </div>
                            </div>


                    {{/company_news}}

                    {{^company_news}}


                        {{#is_author}}
                            <div class="req-item__helpers">
                                <ul class="req-item__actions is-rounded is-box-shadow">
                                    {{#editable}}
                                        <li class="ajax__news_edit is-first-item" data-id="{{id}}">Редактировать</li>
                                    {{/editable}}
                                    <li class="ajax__news_remove is-last-item" data-id="{{id}}">Удалить</li>
                                </ul>
                            </div>
                        {{/is_author}}
                        {{#author}}
                            {{#avatar}}
                                <a href="/partners/{{id}}" class="news-advpost__exdor-logo is-rounded">
                                    <img src="/uploads/users/{{id}}/avatar/80x80_{{avatar}}" class="img-responsive">
                                </a>
                            {{/avatar}}
                            {{^avatar}}
                                <a class="news-advpost__exdor-logo is-rounded">
                                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                                </a>
                            {{/avatar}}
                        {{/author}}
                        <div class="news-advpost-head__descr">
                            {{#author}}
                                <a href="/partners/{{id}}" class="news-advpost-head__comname is-blue-link is-long-row">
                                    <span>
                                        <b>{{name}} {{last_name}}</b>
                                    </span>
                                </a>
                            {{/author}}


                            <div class="news-advpost-head__date">
                                <span>{{date}}</span>
                            </div>
                        </div>

                    {{/company_news}}
                </div>


                <div class="news-advpost__text pointer">
                    {{#is_exdor_news}}
                        {{{content_html}}}
                        <div class="clear"></div>
                    {{/is_exdor_news}}

                    {{^is_exdor_news}}
                        {{{content}}}
                    {{/is_exdor_news}}
                </div>



                {{#double_images}}
                    <div class="news__two_images">
                        {{#images}}
                            {{#.}}
                                <div class="news__one_half_image">
                                    <img src="/uploads/news/{{id}}/medium_{{.}}" class="img-responsive" >
                                </div>
                            {{/.}}
                        {{/images}}
                    </div>
                {{/double_images}}
                {{^double_images}}
                    {{#slider}}
                        <div class="advpost__slider-class">
                            <div class="frame js-inner-page-slider-w" data-slider-id="{{id}}">
                                <ul class="clearfix">
                                    {{#images}}
                                    {{#.}}
                                    <li>

                                            <img src="/uploads/news/{{id}}/medium_{{.}}" class="img-responsive" >

                                    </li>
                                    {{/.}}
                                    {{/images}}
                                </ul>
                            </div>
                            <?php if( $this->agent->is_mobile() ):?>
                                <div class="pages"></div>
                            <?php endif;?>
                        </div>
                    {{/slider}}
                    {{^slider}}
                    {{#images}}
                        {{#.}}
                            <div class="news__one_image">
                                <img src="/uploads/news/{{id}}/lg1000_{{.}}" class="img-responsive" >
                            </div>
                        {{/.}}
                    {{/images}}
                {{/slider}}
                {{/double_images}}




            </div>

            <div class="news-post__sub">
                <div class="news-advpost__feedback is-grey-text">
                    <div class="feedback__comments" data-news-id="{{id}}" data-user-id="<?php echo $page_content["user"]->id;?>" data-is-liked="{{#liked}}1{{/liked}}{{^liked}}0{{/liked}}">
                        {{#comments_count}}
                        <i class="fa fa-comment"></i> <span>{{comments_count}} {{comments_count_text}}</span> {{#if_comments_count}}<a class="js-show-all-comments show-all-comments" data-news-id="{{id}}">(показать все)</a>{{/if_comments_count}}
                        {{/comments_count}}
                        {{^comments_count}}
                        <i class="fa fa-comment-o"></i> <span>{{comments_count_text}}</span>
                        {{/comments_count}}
                    </div>
                    <div class="feedback__postlike is-fade" data-news-id="{{id}}" data-user-id="<?php echo $page_content["user"]->id;?>">
                        <span class="postlike__num" data-likes-count="{{likes}}">{{likes}}</span>
                        {{#liked}}
                        <i class="fa fa-heart"></i>
                        {{/liked}}
                        {{^liked}}
                        <i class="fa fa-heart-o"></i>
                        {{/liked}}
                    </div>
                </div>

                <?php /*
                <div class="news_{{id}}_replys">
                    {{#comments}}
                        <div class="reply news__comment-{{id}}">

                            <a class="ajax__undo_remove_news_comment after_removing_background is-or-link" data-comment-id="{{id}}">
                                <div class="like_table">
                                    <div class="like_td">
                                        <p><i class="fa fa-undo" aria-hidden="true"></i></p>
                                        <p><span>Восстановить</span></p>
                                    </div>
                                </div>
                            </a>

                            <a class="lower-layer" data-name="{{name}}, " data-news-id="{{news_id}}" data-author-id="{{user_id}}"></a>
                            {{#avatar}}
                            <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
                                <img src="/uploads/users/{{user_id}}/avatar/80x80_{{avatar}}" class="img-responsive">
                            </a>
                            {{/avatar}}
                            {{^avatar}}
                            <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
                                <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                            </a>
                            {{/avatar}}

                            <div class="reply__content">
                                <a href="/partners/{{user_id}}" class="is-blue-link">
                                    <span><b>{{name}} {{last_name}}</b></span>
                                </a>
                                <div class="reply__text">{{{comment}}}</div>
                            </div>
                            <div class="reply__date">
                                {{#is_author}}
                                    {{#editable}}
                                        <a title="Редактировать" class="ajax-edit-message is-blue-text" data-message-id="{{id}}" onclick=""><i class="fa fa-pencil"></i></a> |
                                    {{/editable}}
                                {{/is_author}}
                                {{#removable}}
                                    <a title="Удалить" class="ajax-remove-message is-red-text" data-message-id="{{id}}" onclick=""><i class="fa fa-trash-o"></i></a> |
                                {{/removable}}
                                {{date}}
                            </div>
                        </div>
                    {{/comments}}
                </div>


                <!--  Добавить комментарий  -->
                <div class="news-advpost__form is-last-item">
                    <a href="/partners/<?php echo $user->id;?>" class="reply__form-image is-rounded">
                        <?php if( $user->avatar ):?>
                            <img class="author_avatar img-responsive" src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" alt="">
                        <?php else:?>
                            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                        <?php endif;?>
                    </a>
                    <div class="reply__form-box">
                        <textarea class="js__news__add_comment reply__area is-rounded news-{{id}}-replay" placeholder="Оставить комментарий" data-news-id="{{id}}" data-author-id="<?php echo $user->id;?>"></textarea>

                        <span class="reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" class="reply__submit is-rounded ajax-news-leave-comment" value="Отправить" data-news-id="{{id}}" data-author-id="<?php echo $user->id;?>">
                        </span>
                    </div>
                </div>
                <!--    -->

                */?>
            </div>
        </div>
    </div>
    {{/.}}

</script>
