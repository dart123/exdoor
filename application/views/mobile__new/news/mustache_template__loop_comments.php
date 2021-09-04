<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.10.16
 * Time: 18:44
 */
?>
<script type="text/html" id="mustache__news_comments">
    {{#.}}
    <div class="reply news__comment-{{comment_id}}">

        <a class="ajax__undo_remove_news_comment after_removing_background is-or-link" data-comment-id="{{comment_id}}">
            <div class="like_table">
                <div class="like_td">
                    <p><i class="fa fa-undo" aria-hidden="true"></i></p>
                    <p><span>Восстановить</span></p>
                </div>
            </div>
        </a>

        <a class="lower-layer" data-name="{{name}}, " data-news-id="{{news_id}}" data-author-id="{{user_id}}"></a>
        {{#avatar}}
        <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
            <img src="/uploads/users/{{user_id}}/avatar/80x80_{{avatar}}" class="img-responsive">
        </a>
        {{/avatar}}
        {{^avatar}}
        <a href="/partners/{{user_id}}"  class="reply__image is-rounded">
            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
        </a>
        {{/avatar}}

        <div class="reply__content">
            <a href="/partners/{{user_id}}" class="is-blue-link">
                <span><b>{{name}} {{last_name}}</b></span>
            </a>
            <div class="reply__text">{{{comment}}}</div>
        </div>
        <div class="reply__date">
            {{m_date}}
        </div>

        <div class="reply__control">
            {{#is_author}}
                {{#editable}}
                    <a title="Редактировать" class="ajax-edit-message pointer is-blue-text" data-message-id="{{comment_id}}" onclick=""><i class="fa fa-pen"></i></a> |
                {{/editable}}
            {{/is_author}}
            {{#removable}}
                <a title="Удалить" class="ajax-remove-message pointer is-red-text" data-message-id="{{comment_id}}" onclick=""><i class="fa fa-trash-alt"></i></a>
            {{/removable}}
        </div>
    </div>
    {{/.}}
</script>