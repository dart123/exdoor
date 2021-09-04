<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 09.07.17
 * Time: 18:36
 */

?>

<script type="text/html" id="mustache__news_loop__news_only">

    {{#.}}

        <div class="news-post__wrapper">
            <!-- ссылка-слой для вызова fancy -->
            <a href="#news-post{{id}}" rel="news-group" data-id="{{id}}" class="lower-layer fancybox__adv-news"></a>
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
                    <a href="#news-post{{id}}" rel="news-group-b" data-id="{{id}}" class="news-advpost-head__date fancybox__adv-news">
                        <i class="fa fa-newspaper i-left-20"></i>
                        <span><b>{{date}}</b></span>
                    </a>
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


                    <a href="#news-post{{id}}" rel="news-group-b" data-id="{{id}}" class="news-advpost-head__date fancybox__adv-news">
                        <i class="fa fa-newspaper i-left-20"></i>
                        <span><b>{{date}}</b></span>
                    </a>
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

    {{/.}}

</script>

