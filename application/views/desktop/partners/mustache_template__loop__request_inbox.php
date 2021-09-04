<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 17.02.2017
 * Time: 17:19
 */

?>


<script type="text/html" id="mustache__partner__loop__request_inbox">

    {{#.}}

        <div class="my-partners__row js__list__partner" data-partner-id="{{id}}">
            <div class="my-partners__lcell">
                <a href="/partners/{{id}}" class="my-partners__image is-rounded">
                    {{#avatar}}
                    <img src="/uploads/users/{{id}}/avatar/80x80_{{avatar}}" alt="">
                    {{/avatar}}
                </a>
                <div class="my-partners__content">
                    <a href="/partners/{{id}}" class="my-partners__name is-blue-link"><span><b>{{name}} {{last_name}}</b></span></a>
                    <div>
                        {{#company}}
                        {{#.}}
                        <a href="/company/id{{id}}" class="my-partners__company-name is-grey-link">
                            <span>{{short_name}}</span>
                        </a>
                        {{/.}}
                        {{/company}}
                        {{^company}}
                        <a class="my-partners__company-name">
                            <span>Физическое лицо</span>
                        </a>
                        {{/company}}
                    </div>
                    <div class="my-partners__status">{{status}}</div>
                </div>
            </div>

            <div class="my-partners__rcell">
                <a class="js-partner__add_user my-partners__accept is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                    <i class="fas fa-check i-left-15"></i>
                    <span>Принять заявку</span>
                </a>

                <a class="js-partner__cancel_request_inbox my-partners__cancel is-or-link" title="Отменить" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                    <i class="fas fa-times i-left-15"></i>
                </a>
            </div>
        </div>

    {{/.}}

</script>

