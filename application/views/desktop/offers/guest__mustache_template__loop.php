<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 16:43
 */
?>


<script type="text/html" id="guest__mustache__ads_loop">
    {{#.}}
    <div class="advpost__content advpost__item is-rounded item-offer-{{id}}">
        <div class="adv-post__wrapper">
            <!-- ссылка-слой для вызова fancy -->
            <a href="#adv-post{{id}}" data-fancybox="adv-group" data-id="{{id}}" class="lower-layer fancybox"></a>
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
                    {{#boolean__barter}}
                        {{#barter_text}}
                            <span class="is-blue-text offers__barter">
                                <span class="tooltip tooltip_offers">
                                    <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                    Возможен бартер
                                    <span class="tooltip__msg is-rounded is-box-shadow is-fade">
                                        {{barter_text}}
                                    </span>
                                </span>
                            </span>
                        {{/barter_text}}
                        {{^barter_text}}
                            <span class="is-blue-text offers__barter">
                                <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                Возможен бартер
                            </span>
                        {{/barter_text}}
                    {{/boolean__barter}}
                </p>

            </div>
            {{#slider}}
            <div class="advpost__slider-class">
                <div class="frame js-inner-page-slider-w" data-slider-id="{{id}}">
                    <ul>
                        {{#images}}
                        {{#.}}
                        <li>
                            <a href="/uploads/offers/{{id}}/lg1000_{{.}}" class="fancybox-thumb-w" data-fancybox="fancybox-thumb-{{id}}-m">
                                <img src="/uploads/offers/{{id}}/medium_{{.}}" alt="">
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
            <div class="image__frame-10">
                <img src="/uploads/offers/{{id}}/medium_{{.}}" class="img-responsive">
            </div>
            {{/.}}
            {{/images}}
            {{/slider}}
            <div class="advpost__text">
                {{{content}}}
            </div>
        </div>
        <div class="advpost__descr is-last-item">
            <div class="advpost__footer-l">
                <a href="" class="is-blue-link"><span>{{category_text}}</span></a> — {{date}}
            </div>
            <a class="js-guest__go-login advpost__footer-r advpost__footer-author" href="javascript:void(0)">
                <div class="is-blue-text">
                    <i class="fas fa-envelope i-left-15"></i>
                    <span>Связаться с автором</span>
                </div>
            </a>

        </div>
    </div>
    {{/.}}
</script>
