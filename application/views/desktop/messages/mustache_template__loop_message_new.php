<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.12.16
 * Time: 13:46
 */
?>
<script type="text/html" id="mustache__message_item">
    {{#.}}
    <tr class="conversation__row message-id-{{id}}">
        <td class="conversation__action">

            <a title="Удалить" class="ajax-remove-message is-red-text" data-message-id="{{id}}" data-chatroom-id="<?php echo $chatroom;?>" onclick=""><i class="fas fa-trash-alt"></i></a>

            {{#is_author}}
                {{#editable}}
                    <a title="Редактировать" class="ajax-edit-message is-blue-text" data-message-id="{{id}}" data-chatroom-id="<?php echo $chatroom;?>" onclick=""><i class="fas fa-pen"></i></a>
                {{/editable}}
            {{/is_author}}

        </td>
        <td class="conversation__author">
            <a href="/partners/{{author_id}}" class="is-rounded">
                {{#avatar}}
                    <img src="/uploads/users/{{author_id}}/avatar/80x80_{{avatar}}" style="height: 60px; width: 60px;" alt="">
                {{/avatar}}
                {{^avatar}}
                    <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                {{/avatar}}
            </a>
        </td>
        <td class="conversation__body">
            <div class="conversation__author-name">
                <a href="/partners/{{author_id}}" class="is-blue-link">
                    <span>{{name}} {{last_name}}</span>
                </a>
            </div>
            <div class="conversation__text" data-message-id="{{id}}">
                {{{message}}}
            </div>
            {{#images}}
                {{#.}}
                    <a href="/uploads/messages/<?php echo $chatroom;?>/lg1000_{{.}}" class="fancybox-thumb" data-fancybox="fancy-rel-{{id}}">
                        <img src="/uploads/messages/<?php echo $chatroom;?>/lg1000_{{.}}" class="img-responsive">
                    </a>
                {{/.}}
            {{/images}}
            <a class="ajax__restore_message after_removing_background is-or-link" data-message-id="{{id}}" data-chatroom-id="<?php echo $chatroom;?>">
                <div class="like_table">
                    <div class="like_td">
                        <p><i class="fas fa-undo" aria-hidden="true"></i></p>
                        <p><span>Восстановить</span></p>
                    </div>
                </div>
            </a>
        </td>
        <td class="conversation__date">{{date}}</td>
        <td class="conversation__rspace"></td>
    </tr>
    {{/.}}
</script>