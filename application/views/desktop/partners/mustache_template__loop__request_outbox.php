<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 17.02.2017
 * Time: 17:19
 */

?>

<script type="text/html" id="mustache__partner__loop__request_outbox">

    {{#.}}

    <div class="my-partners__row js__list__partner" data-partner-id="{{id}}" >
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
            <div class="choosen-partner add-partner is-hidden">
                <a class="js-partner__send_request is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                    <i class="fas fa-plus i-left-15"></i>
                    <span>Добавить в партнеры</span>
                </a>
            </div>
            <div class="choosen-partner del-partner">
                <div>
                <span class="is-grey-text">
                    <i class="far fa-clock i-left-15"></i>
                    <span>Заявка еще не принята</span>
                </span>
                </div>

                <a class="js-partner__cancel_request is-or-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                    <i class="fas fa-times i-left-15"></i>
                    <span>Отменить заявку</span>
                </a>
            </div>
        </div>
    </div>

    {{/.}}

</script>


