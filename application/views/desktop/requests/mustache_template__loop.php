<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.03.17
 * Time: 23:49
 */
?>
<script type="text/html" id="mustache__request_loop">
    {{#.}}
        <li class="request__item req-item is-first-item is-first-item {{html_class}}">
            <a href="/requests/{{id}}" class="request__item--wrap">
                <p>
                    <b>#{{id}}.</b> <span>

                            {{$eq_brand}}, {{eq_appointment}}, {{eq_serial_number}}</span>

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
                    <li class="is-first-item">
                        <a href="/requests/{{id}}/compare" >Сравнить предложения</a>
                    </li>
                    <li>
                        <a href="/requests/{{id}}">Редактировать</a>
                    </li>
                    <li class="is-last-item">
                        <a href="#" target="_blank">Отменить</a>
                    </li>
                </ul>
            </div>
            <div class="req-item__time">
                {{date_output}}
            </div>
        </li>
    {{/.}}
</script>
