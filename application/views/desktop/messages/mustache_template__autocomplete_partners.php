<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.12.16
 * Time: 16:59
 */
?>
<script type="text/html" id="autocomplete-partners__template">
    {{#.}}
    <a class="js-partner__open_chat pointer new-msg__row is-first-item is-fade" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{partner_id}}">
        <div class="new-msg__image is-rounded">
            {{#avatar}}
            <img src="/uploads/users/{{partner_id}}/avatar/80x80_{{avatar}}" style="width: 100%; height: auto" alt="">
            {{/avatar}}
            {{^avatar}}
            <img src="/assets/img/news-advpost-head__photo--empty.jpg" style="width: 100%; height: auto" alt="">
            {{/avatar}}
        </div>
        <div class="new-msg__content">
            <div class="new-msg__name">{{name}} {{second_name}} {{last_name}}</div>
        </div>
    </a>
    {{/.}}
</script>
