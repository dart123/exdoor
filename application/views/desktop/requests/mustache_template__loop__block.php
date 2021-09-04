<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 06.04.17
 * Time: 12:20
 */

?>

<script type="text/html" id="mustache__request_loop__block">
    {{#.}}
    <div class="request__item req-item {{html_class}}  ajax__request_{{id}} ajax__request-item_list__{{user_id}}__{{id}}">
        <a href="{{html_url}}" class="request__item--wrap">
            <p>
                <b>{{#archived_request_title}}{{archived_request_title}} {{/archived_request_title}}#{{id}}.</b> <span>
                {{eq_brand_name}}, {{eq_appointment_name}}, {{eq_serial_number}}</span>
            </p>
            <p class="req-item__descr">
                {{#positions}}
                {{detail}};
                {{/positions}}
            </p>
            <p class="is-last-el">
                <span>Статус: </span>
                <span class="req-item__status req-item__status--answered">{{status_text}}</span>
            </p>
        </a>

        <div class="req-item__helpers">
            <ul class="req-item__actions is-rounded is-box-shadow">

                <li class="is-first-item js__requests__context_menu" data-href="/requests/{{id}}">
                    <a>Открыть</a>
                </li>

                {{#can__compare}}
                    <li class="js__requests__context_menu" data-href="{{html_compare_url}}">
                        <a>Сравнить предложения</a>
                    </li>
                {{/can__compare}}

                {{#can__set_rating}}
                    <li class="js__requests__context_menu" data-href="/requests/{{id}}?set_rating=true">
                        <a>
                            {{#finished}}
                                Завершить
                            {{/finished}}
                            {{^finished}}
                                {{#show_rating}}Изменить оценку{{/show_rating}}
                                {{^show_rating}}Оценить партнера{{/show_rating}}
                            {{/finished}}
                        </a>
                    </li>
                {{/can__set_rating}}

                {{#can__clone}}
                    <li class="ajax__request__copy" data-request-id="{{id}}">
                        <a>Копировать</a>
                    </li>
                {{/can__clone}}


                {{#can__archived}}
                    <li class="is-last-item ajax__request__send_to_archive" data-request-id="{{id}}">
                        <a>Отправить в архив</a>
                    </li>
                {{/can__archived}}

                {{#can__cancel}}

                    {{#is_author}}
                        <li class="is-last-item js__requests_list__author_denied" data-request-id="{{id}}" data-page-reload="no">
                            <a>Отменить</a>
                        </li>
                    {{/is_author}}
                    {{^is_author}}
                        <li class="is-last-item js__requests_list__partner_denied" data-request-id="{{id}}" data-page-reload="no">
                            <a>Отклонить</a>
                        </li>
                    {{/is_author}}

                {{/can__cancel}}
            </ul>
        </div>
        {{#can__set_rating}}
            {{^show_rating}}
                <div class='req-item__rating'>
                    <a href='/requests/{{id}}?set_rating=true' class='is-blue-link'>
                        <i class='fa fa-star'></i> <span>{{#finished}}Завершить и оценить{{/finished}}{{^finished}}Оценить{{/finished}}</span>
                    </a>
                </div>
            {{/show_rating}}

            {{#show_rating}}
                {{#is_author}}
                    {{#rating_executor}}
                        <div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--{{rating_executor}} js__requests__context_menu' data-href="/requests/{{id}}?set_rating=true"></div>
                    {{/rating_executor}}
                {{/is_author}}


                {{#is_executor}}
                    {{#rating_author}}
                        <div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--{{rating_author}} js__requests__context_menu' data-href="/requests/{{id}}?set_rating=true"></div>
                    {{/rating_author}}
                {{/is_executor}}
            {{/show_rating}}

        {{/can__set_rating}}

        {{^can__set_rating}}
            {{#show_rating}}
                {{#is_author}}
                    {{#rating_executor}}
                        <div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--{{rating_executor}}'></div>
                    {{/rating_executor}}
                {{/is_author}}


                {{#is_executor}}
                    {{#rating_author}}
                        <div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--{{rating_author}}'></div>
                    {{/rating_author}}
                {{/is_executor}}

            {{/show_rating}}
        {{/can__set_rating}}


        <div class="req-item__time">
            {{date_output}}
        </div>
    </div>
    {{/.}}
</script>

