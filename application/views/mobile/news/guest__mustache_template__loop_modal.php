<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:22
 */

?>


<script type="text/html" id="guest__mustache__news_loop_modal">
    {{#.}}
    <div id="news-post{{id}}" class="post-wrapper item-news-{{id}}">
        <div class="news-advpost__block is-rounded is-box-shadow is-mtop-20">
            <div class="news-post__wrapper">
                <!-- ссылка-слой для вызова fancy -->
                <a href="#news-post{{id}}" rel="news-group" class="lower-layer fancybox__adv-news"></a>
                <!--    -->

                <div class="news-advpost__head">













                    {{#company_news}}


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
                    <div class="news-advpost-head__descr">
                        <a href="/company/id{{id}}" class="news-advpost-head__comname is-blue-link is-long-row">
                                    <span>
                                        <b>{{short_name}}</b>
                                    </span>
                        </a>

                        <a href="#news-post{{id}}" rel="news-group-b" data-id="{{id}}" class="news-advpost-head__date fancybox__adv-news">
                            <i class="fa fa-newspaper-o i-left-20"></i>
                            <span><b>{{date}}</b></span>
                        </a>
                    </div>
                    {{/author}}

                    {{/company_news}}

                    {{^company_news}}


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
                    <div class="news-advpost-head__descr">
                        <a href="/partners/{{id}}" class="news-advpost-head__comname is-blue-link is-long-row">
                                <span>
                                    <b>{{name}} {{last_name}}</b>
                                </span>
                        </a>

                        <a class="news-advpost-head__date">
                            <i class="fa fa-newspaper-o i-left-20"></i>
                            <span><b>{{date}}</b></span>
                        </a>
                    </div>
                    {{/author}}





                    {{/company_news}}















                </div>


                <div class="news-advpost__text pointer">
                    {{{content}}}
                </div>
                {{#images}}
                <div class="news_offers__modal_images">
                    {{#.}}
                    <img src="/uploads/news/{{id}}/lg1000_{{.}}" class="img-responsive" >
                    {{/.}}
                </div>
                {{/images}}
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

