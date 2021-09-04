<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.12.16
 * Time: 13:47
 */
?>
<script type="text/html" id="mustache__new_message_item">

    {{#.}}
    <tr class="conversation__row message-id-{{id}} message__unread">
        <!--
        <td class="conversation__action">
            <a title="Удалить" class="ajax-remove-message is-red-text" data-message-id="{{id}}" data-chatroom-id="<?php echo $page_content["chatroom"];?>" onclick=""><i class="fa fa-trash-o"></i></a>
            <a title="Редактировать" class="ajax-edit-message is-blue-text" data-message-id="{{id}}" data-chatroom-id="<?php echo $page_content["chatroom"];?>" onclick=""><i class="fa fa-pencil"></i></a>
        </td>
        -->
        <td class="conversation__author">
            <a href="/partners/{{author_id}}" class="is-rounded">
                {{#avatar}}
                    <img src="/uploads/users/{{author_id}}/avatar/80x80_{{avatar}}" style="height: 60px; width: 60px;" alt="">
                {{/avatar}}
                {{^avatar}}
                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                {{/avatar}}
            </a>
        </td>
        <td class="conversation__body">

            <div class="conversation__date">
                {{date}}
                <div class="req-item__helpers">
                    <ul class="req-item__actions is-rounded is-box-shadow">
                        <li class="ajax-remove-message is-last-item" data-message-id="{{id}}" data-chatroom-id="<?php echo $page_content["chatroom"];?>">Удалить</li>
                        <li class="ajax-edit-message is-blue-text" data-message-id="{{id}}" data-chatroom-id="<?php echo $page_content["chatroom"];?>">Редактировать</li>
                    </ul>
                </div>
            </div>

            <div class="conversation__author-name">
                <a href="/partners/{{author_id}}" class="is-blue-link">
                    <span>{{name}}</span>
                </a>
            </div>

            <div class="conversation__rspace"></div>

            <div class="conversation__text">
                {{{message}}}
            </div>

            {{#images}}
                {{#.}}
                    <a href="/uploads/messages/<?php echo $page_content["chatroom"];?>/lg1000_{{.}}" class="fancybox-thumb" rel="fancy-rel-{{id}}">
                        <img src="/uploads/messages/<?php echo $page_content["chatroom"];?>/lg1000_{{.}}" class="img-responsive">
                    </a>
                {{/.}}
            {{/images}}

            <a class="ajax__restore_message after_removing_background is-or-link" data-message-id="{{id}}" data-chatroom-id="<?php echo $page_content["chatroom"];?>">
                <div class="like_table">
                    <div class="like_td">
                        <p><i class="fa fa-undo" aria-hidden="true"></i> <span>Восстановить</span></p>
                    </div>
                </div>
            </a>
        </td>
    </tr>
    {{/.}}
</script>
