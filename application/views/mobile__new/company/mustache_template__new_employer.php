<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.03.17
 * Time: 0:46
 */
?>

<script type="text/html" id="mustache__company__new_employer">

    {{#.}}
        <li class="coworkers-list__item coworker-info">
            <a href="/partners/{{id}}" class="coworker-info__link">
                <div class="coworker-info__photo is-rounded">
                    {{#avatar}}
                        <img src="/uploads/users/{{id}}/avatar/80x80_{{avatar}}" alt="">
                    {{/avatar}}
                </div>
                <div class="coworker-info__name is-fade">
                    {{#name}}
                        {{name}}
                    {{/name}}
                </div>
            </a>
        </li>
    {{/.}}
</script>