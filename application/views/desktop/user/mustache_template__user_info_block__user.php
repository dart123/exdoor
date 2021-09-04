<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.06.17
 * Time: 21:57
 */
?>

<script type="text/html" id="mustache__user_info_block__user">

    <div class="section-user-info is-rounded is-box-shadow js__user_info_block">
        <div class="section-user-info__portrait user-portrait">

            <div class="user-portrait__space"></div>
            <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="choose-portrait-img" class="ajax-upload-avatar">

            <label for="choose-portrait-img" class="is-or-link user-portrait__helpers helpers-signs js__avatar_label">
                {{#avatar}}
                <div class="user-portrait__img user-portrait__img--image_exists user-portrait__img__editable">
                    <img src="/uploads/users/{{id}}/avatar/180x180_{{avatar}}" style="width: 100%; height: auto;">
                    <div class="user-portrait__img__edit"><i class="fas fa-pen"></i></div>
                </div>
                {{/avatar}}
                {{^avatar}}
                <div class="helpers-signs__content">
                    <div class="helpers-signs__icons"><i class="fas fa-plus"></i><i class="fa fa-camera"></i></div>
                    <span>Добавьте свой портрет</span>
                </div>
                {{/avatar}}
            </label>

        </div>

        <div class="section-user-info__profile user-profile">
            <div class="user-profile__contact">{{name}} {{second_name}} {{last_name}}</div>
            {{#company_profession}}
                {{#company}}
                    <div class="user-profile__title">
                        {{company_profession}}, <a href="/company/id{{id}}" class="is-blue-link"><span>{{short_name}}</span></a>
                    </div>
                {{/company}}
            {{/company_profession}}


            {{#this_user}}
                <span class="js__profile-status__text profile-status__text pointer" data-user="{{id}}" {{#status}}data-status="unset"{{/status}}>{{#status}}{{status}}{{/status}} {{^status}}<span class='is-grey-text'>yкажите статус</span>{{/status}}</span> &nbsp;<i class="js__profile-status__text__edit_icon fas fa-pen" style="display: none;"></i>
            {{/this_user}}
            {{^this_user}}
                <span class="profile-status__text pointer"><span class='is-grey-text'>{{status}}</span></span>
            {{/this_user}}

            <div class="user-profile__text">
                {{#city}}
                    <p>
                        <span class="profile-ind is-grey-text">Город:</span>
                        <span class="profile-descr">{{city}}</span>
                    </p>
                {{/city}}
                {{#email}}
                    <p>
                        <span class="profile-ind is-grey-text">E-mail:</span>
                        <span class="profile-descr">{{email}}</span>
                    </p>
                {{/email}}
                {{#phone}}
                    <p>
                        <span class="profile-ind is-grey-text">Телефон:</span>
                        <span class="profile-descr">{{phone}}</span>
                    </p>
                {{/phone}}
            </div>
        </div>

        {{#this_user}}
        <div class="section-user-info__actions user-actions">
            <a href="/profile" class="user-actions__add-form is-b-left is-or-link">
                <span>Заполнить анкету</span><i class="fas fa-pen"></i>
            </a>
        </div>
        {{/this_user}}
    </div>
</script>
