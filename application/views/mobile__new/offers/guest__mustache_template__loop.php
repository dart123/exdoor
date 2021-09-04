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

            <div class="advpost__head clear">

                <p class="is-blue-text"><b>{{title}}</b></p>

                {{#keywords}}
                <p class="is-grey-text">{{keywords}}</p>
                {{/keywords}}


                {{#price}}
                    <p class="is-or-text offer__price">
                        <b>
                            {{price}} {{#max_price}}- {{max_price}} {{/max_price}}₽
                        </b>
                    </p>
                {{/price}}

                {{#boolean__barter}}
                    <p>
                        {{#barter_text}}
                        <span class="offers__barter">
                                    <span class="is-blue-text">
                                        <i class="fa fa-sync-alt" title="" aria-hidden="true"></i>
                                        <span>Возможен бартер:</span>
                                    </span>
                                    <span class="is-grey-text">
                                        <span>
                                            {{barter_text}}
                                        </span>
                                    </span>
                                </span>
                        {{/barter_text}}
                        {{^barter_text}}
                        <span class="offers__barter">
                                    <i class="fa fa-sync-alt" title="" aria-hidden="true"></i>
                                    <span class="is-blue-text">
                                        Возможен бартер
                                    </span>
                                </span>
                        {{/barter_text}}
                    </p>
                {{/boolean__barter}}

            </div>
            {{#slider}}
            <div class="advpost__slider-class">
                <div class="frame js-inner-page-slider-w" data-slider-id="{{id}}">
                    <ul>
                        {{#images}}
                        {{#.}}
                        <li>
                            <a href="/uploads/offers/{{id}}/lg1000_{{.}}" class="fancybox-thumb-w" rel="fancybox-thumb-{{id}}-m">
                                <img src="/uploads/offers/{{id}}/medium_{{.}}" alt="">
                            </a>
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

            <a href="/?action=author_connect" class="advpost__footer-r advpost__footer-author">
                <div class="is-blue-text">
                    <i class="fa fa-envelope i-left-15"></i>
                    <span>Связаться с автором</span>
                </div>
            </a>

        </div>
    </div>
    {{/.}}
</script>
