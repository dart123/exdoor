<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:22
 */

?>


<script type="text/html" id="guest__mustache__news_loop">

    {{#.}}

    <div class="news-advpost item-news-{{id}}" id="js__news_list__news_{{id}}">

        <div class="news-advpost__block is-mbtm-30 is-rounded is-box-shadow">
            <div class="news-post__wrapper">

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
                    {{{content}}}
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
                                <a href="/uploads/news/{{id}}/lg1000_{{.}}" class="fancybox-thumb-w" rel="fancybox-thumb-{{id}}-m">
                                    <img src="/uploads/news/{{id}}/medium_{{.}}" class="img-responsive" >
                                </a>
                            </li>
                            {{/.}}
                            {{/images}}
                        </ul>
                    </div>
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
                    <div class="feedback__comments">
                        {{#comments_count}}
                        <i class="fa fa-comment"></i> <span>{{comments_count}} {{comments_count_text}}</span>
                        {{/comments_count}}
                        {{^comments_count}}
                        <i class="fa fa-comment-o"></i> <span>{{comments_count_text}}</span>
                        {{/comments_count}}
                    </div>
                    <div class="feedback__postlike is-fade">
                        <span class="postlike__num">{{likes}}</span>
                        <i class="fa fa-heart-o"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{/.}}

</script>

