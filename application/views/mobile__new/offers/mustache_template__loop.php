<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 16:13
 */
?>

<script type="text/html" id="mustache__ads_loop">
    {{#.}}
    <div class="advpost__content advpost__item is-rounded item-offer-{{id}}">
        <a class="ajax__undo_remove_offer after_removing_background is-rounded is-or-link" data-offer-id="{{id}}">
            <div class="like_table">
                <div class="like_td">
                    <p><i class="fa fa-undo" aria-hidden="true"></i></p>
                    <p><span>Восстановить</span></p>
                </div>
            </div>
        </a>
        <div class="adv-post__wrapper">

            <div class="advpost__head clear">
                {{#is_author}}
                    <div class="req-item__helpers">
                        <ul class="req-item__actions is-rounded is-box-shadow">
                            <li class="is-first-item ajax__edit_offer" data-offer-id="{{id}}">
                                Редактировать
                            </li>
                            <li class="ajax__remove_offer" data-offer-id="{{id}}">
                                Удалить
                            </li>
                            <li class="is-last-item    js__clipboard__copy_link" data-clipboard-text="<?=$this->config->item('base_url');?>/offers/{{type}}/{{id}}">
                                Скопировать ссылку
                            </li>
                        </ul>
                    </div>
                {{/is_author}}
                {{^is_author}}
                    <p class="offers__share_link is-blue-link        js__clipboard__copy_link" data-clipboard-text="<?=$this->config->item('base_url');?>/offers/{{type}}/{{id}}">
                        <i class="fa fa-share"></i>
                    </p>
                {{/is_author}}

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
            {{#is_author}}
                <div class="advpost__footer-r advpost__footer-my">
                    <i class="fa fa-circle"></i> Это Ваше объявление
                </div>
            {{/is_author}}
            {{^is_author}}
                <a class="js-partner__open_chat advpost__footer-r advpost__footer-author" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{author_id}}">
                    <div class="is-blue-text">
                        <i class="fa fa-envelope i-left-15"></i>
                        <span>Связаться с автором</span>
                    </div>
                </a>
            {{/is_author}}
        </div>
    </div>
    {{/.}}
</script>