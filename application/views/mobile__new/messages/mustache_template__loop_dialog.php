<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.07.17
 * Time: 11:48
 */

?>
<script type="text/html" id="mustache__dialog_item">
    {{#.}}
        <a href="/messages/{{chatroom_id}}" class="my-dialogs__row is-fade my-dialogs__row__unread js__dialog_{{chatroom_id}}">
            <div href="" class="my-dialogs__image is-rounded">
                {{#avatar}}
                    <img src="/uploads/users/{{author_id}}/avatar/80x80_{{avatar}}" class="img-responsive" alt="">
                {{/avatar}}
                {{^avatar}}
                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                {{/avatar}}
            </div>
            <div class="my-dialogs__content">

                <div class="my-dialogs__name">{{name}} {{last_name}}</div>
                <div class="my-dialogs__text">
                        {{{message_preview}}}
                </div>
                <div class="my-dialogs__text__typing is-hidden">
                    {{typing_text}}
                </div>

            </div>
            <div class="my-dialogs__date">{{date}}</div>
        </a>
    {{/.}}
</script>
