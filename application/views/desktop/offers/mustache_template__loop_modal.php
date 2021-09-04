<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 16:38
 */
?>
<script type="text/html" id="mustache__ads_loop_modal">
    {{#.}}
        <div id="adv-post{{id}}" class="post-wrapper item-offer-{{id}}">
            <a class="ajax__undo_remove_offer after_removing_background is-rounded is-or-link" data-offer-id="{{id}}">
                <div class="like_table">
                    <div class="like_td">
                        <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                        <p><span>Восстановить</span></p>
                    </div>
                </div>
            </a>
            <div class="advpost__content is-rounded">

                <div class="adv-post__wrapper">
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
                                        <i class="fas fa-sync-alt" title="" aria-hidden="true"></i>
                                        Возможен бартер
                                    </span>
                                    <span class="is-black-text"> &mdash; {{barter_text}}</span>
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
                        <a href="/offers/<?php echo $type;?>?filter=true&type={{type}}&cat[]={{category}}" class="is-blue-link js__real-link">
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
        </div>
    {{/.}}
</script>