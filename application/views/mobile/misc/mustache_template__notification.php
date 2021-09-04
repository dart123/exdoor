<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.03.17
 * Time: 9:03
 */

?>


<script type="text/html" id="mustache__notification">
    {{#.}}
        <div class="bottom_notification-trigger">
            {{#id}}
                <div class="bottom_notification-trigger__close pointer" data-noty-id="{{id}}">
                    <i class="fa fa-times"></i>
                </div>
            {{/id}}
            <div class="bottom_notification-trigger__image {{#url}}pointer{{/url}}" data-url="{{url}}">

                {{#from_id__avatar}}
                    {{#from_company}}
                        <img src="/uploads/companies/{{from_id}}/logo/{{from_id__avatar}}" style="height: 60px; width: 60px;" alt="">
                    {{/from_company}}
                    {{^from_company}}
                        <img src="/uploads/users/{{from_id}}/avatar/80x80_{{from_id__avatar}}" style="height: 60px; width: 60px;" alt="">
                    {{/from_company}}
                {{/from_id__avatar}}
                {{^from_id__avatar}}
                    <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                {{/from_id__avatar}}

            </div>
            <div class="bottom_notification-trigger__text {{#url}}pointer{{/url}}" data-url="{{url}}">
                <h4 class="bottom_notification-trigger__title">{{title}}</h4>
                <p class="bottom_notification-trigger__desc">{{{content}}}</p>
            </div>
        </div>
    {{/.}}
</script>

