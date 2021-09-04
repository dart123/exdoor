<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 17:23
 */
?>
<script type="text/html" id="mustache__ads_loop_full_width">
    {{#.}}
        <div class="advpost is-mbtm-30 is-rounded is-box-shadow item-offer-{{id}}">
            <a class="ajax__undo_remove_offer after_removing_background is-rounded is-or-link" data-offer-id="{{id}}">
                <div class="like_table">
                    <div class="like_td">
                        <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                        <p><span>Восстановить</span></p>
                    </div>
                </div>
            </a>
            {{#first_image}}
                <div class="advpost_bg">
                    <div class="ie-cover"></div>
                    <img src="/uploads/offers/{{id}}/lg1000_{{first_image}}" />
                </div>
            {{/first_image}}

            <div class="advpost__icon"><i class="fa fa-bullhorn"></i> Объявление</div>

            {{#is_author}}
                <div class="advpost__actions">
                    {{#pinned}}
                        <a href="" class="ajax__pinned_offer slide-out" data-id="{{id}}" data-pinned="true">
                            <i class="fas fa-thumbtack"></i>
                            <span class="slide-out__fix is-b-left slide-out__fix--pin"><span>Закреплено</span></span>
                        </a>
                    {{/pinned}}
                    {{^pinned}}
                        <a href="" class="ajax__pinned_offer slide-out" data-id="{{id}}" data-pinned="false">
                            <i class="fas fa-thumbtack"></i>
                            <span class="slide-out__fix is-b-left"><span>Закрепить в начале</span></span>
                        </a>
                    {{/pinned}}
                </div>
            {{/is_author}}

            <div class="advpost__content is-rounded">
                <div class="adv-post__wrapper">
                    <!-- ссылка-слой для вызова fancy -->
                    <a href="#adv-post{{id}}" data-fancybox="adv-group" data-id="{{id}}" class="lower-layer fancybox__adv-news"></a>
                    <!--    -->

                    <div class="advpost__head clear">
                        {{#is_author}}
                        <div class="req-item__helpers">
                            <ul class="req-item__actions is-rounded is-box-shadow">
                                <li class="is-first-item ajax__edit_offer" data-offer-id="{{id}}">
                                    Редактировать
                                </li>
                                <li class="is-last-item ajax__remove_offer" data-offer-id="{{id}}">
                                    Удалить
                                </li>
                            </ul>
                        </div>
                        {{/is_author}}


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
                        <p>{{{content}}}</p>
                    </div>
                </div>
                <div class="advpost__descr is-last-item">
                    <div class="advpost__footer-l">
                        <a href="/offers/{{type}}?filter=true&type={{type}}&cat[]={{category}}" class="is-blue-link js__real-link">
                            <span>{{category_text}}</span>
                        </a> — {{date}}
                    </div>
                    {{#is_author}}
                    <div class="advpost__footer-r advpost__footer-my">
                        <i class="fa fa-circle"></i> Это Ваше объявление
                    </div>
                    {{/is_author}}
                    {{^is_author}}
                    <a class="js-partner__open_chat advpost__footer-r advpost__footer-author" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{author_id}}">
                        <div class="is-blue-text">
                            <i class="fas fa-envelope i-left-15"></i>
                            <span>Связаться с автором</span>
                        </div>
                    </a>
                    {{/is_author}}
                </div>
            </div>
            <div class="advpost--type_label">
                {{#type_buy}}Покупка{{/type_buy}}
                {{#type_sell}}Продажа{{/type_sell}}
                {{#type_service}}Услуга{{/type_service}}

            </div>
        </div>
    {{/.}}
</script>