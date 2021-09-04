<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 13.11.16
 * Time: 23:05
 */
?>

<script type="text/html" id="mustache__equipment_loop">
    {{#.}}
    <li class="eq__item is-box-shadow is-rounded item-equipment-{{id}}">
        <a class="ajax__undo_remove_equipment after_removing_background is-rounded is-or-link" data-equipment-id="{{id}}">
            <div class="like_table">
                <div class="like_td">
                    <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                    <p><span>Восстановить</span></p>
                </div>
            </div>
        </a>
        <!-- Картинка карточки -->
        {{#thumbnail}}
            {{#thumbnail_out}}
                <div class="eq-desrc__image">
                    <img src="/uploads/equipment/{{id}}/medium_{{thumbnail_out}}" class="eq-photo img-responsive" alt="">
                </div>
            {{/thumbnail_out}}
        {{/thumbnail}}

        <!-- Текст карточки -->
        <div class="eq-desrc__text">
            <p>
                {{#model}}
                    <b>{{model}}</b>,
                {{/model}}
                {{brand_name}}
            </p>
            <p>{{appointment_name}}</p>

            <p>{{#serial_number}}SN — <b>{{serial_number}}</b>   |   {{/serial_number}}{{#year}}{{year}}{{/year}}</p>

            {{#engine}}
                <p>Двигатель — {{engine}}</p>
            {{/engine}}

            {{#section}}
                <p class="is-grey-text"><i class="fas fa-thumbtack"></i>{{section}}</p>
            {{/section}}

            <div class="req-item__helpers">
                <ul class="req-item__actions is-rounded is-box-shadow">
                    <li class="is-first-item ajax__edit_equipment" data-equipment-id="{{id}}">
                        Редактировать
                    </li>
                    <li class="is-last-item ajax__remove_equipment" data-equipment-id="{{id}}">
                        Удалить
                    </li>
                </ul>
            </div>
        </div>

        <div class="eq-desrc__create">
            <a href="/requests/add/?action=create_request_from_park&equipment_id={{id}}" class="create__request is-blue-link">
                <i class="fas fa-plus"></i><i class="fa fa-list-alt"></i>
                <span>Создать заявку</span>
            </a>
        </div>
    </li>
    {{/.}}
</script>
