<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.03.17
 * Time: 12:44
 */
?>

<script type="text/html" id="mustache__message_notification">
    {{#.}}
        <div class="bottom_notification-trigger__close">
            <i class="fas fa-times"></i>
        </div>
        <div class="bottom_notification-trigger__image">
            {{#avatar}}
                <img src="/uploads/users/{{author_id}}/avatar/80x80_{{avatar}}" style="height: 60px; width: 60px;" alt="">
            {{/avatar}}
            {{^avatar}}
                <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
            {{/avatar}}
        </div>
        <div class="bottom_notification-trigger__text">
            <h4 class="bottom_notification-trigger__title">{{name}} {{last_name}}</h4>
            <p class="bottom_notification-trigger__desc">{{{message}}}</p>
        </div>

    {{/.}}
</script>
