<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:43
 */

?>


<script type="text/html" id="guest__mustache__ads_loop_modal">
    {{#.}}
    <div id="adv-post{{id}}" class="post-wrapper item-offer-{{id}}">

        <div class="advpost__content is-rounded">
            <div class="adv-post__wrapper">
                <!-- ссылка-слой для вызова fancy -->
                <!--    -->
                <div class="advpost__head clear">

                    <p class="is-blue-text"><b>{{title}}</b></p>

                    {{#keywords}}
                    <p class="is-grey-text">{{keywords}}</p>
                    {{/keywords}}

                    <p class="is-or-text offer__price">
                        {{#price}}
                        <b>
                            {{price}} {{#max_price}}- {{max_price}} {{/max_price}}₽
                        </b>
                        {{/price}}

                    </p>

                </div>

                {{#boolean__barter}}
                    {{#barter_text}}
                        <div class="advpost__text">
                        <span class="is-blue-text">
                            <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                            Возможен бартер &mdash;
                        </span>
                            {{barter_text}}
                        </div>
                    {{/barter_text}}
                    {{^barter_text}}
                        <div class="advpost__text">
                        <span class="is-blue-text">
                            <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                            Возможен бартер
                        </span>
                        </div>
                    {{/barter_text}}
                {{/boolean__barter}}


                <div class="advpost__text">
                    {{{content}}}
                </div>

                {{#images}}
                <div class="news_offers__modal_images">
                    {{#.}}
                    <img src="/uploads/offers/{{id}}/lg1000_{{.}}" class="img-responsive">
                    {{/.}}
                </div>
                {{/images}}


            </div>
            <div class="advpost__descr is-last-item">
                <div class="advpost__footer-l">
                    <a href="/offers?filter=true&type={{type}}&cat[]={{category}}" class="is-blue-link js__real-link">
                        <span>{{category_text}}</span>
                    </a> — {{date}}
                </div>

                <span class="advpost__footer-r advpost__footer-author" style="opacity: .7; cursor: default">
                    <div class="is-blue-text">
                        <i class="fas fa-envelope i-left-15"></i>
                        Связаться с автором
                    </div>
                </span>

            </div>
        </div>
    </div>
    {{/.}}

</script>