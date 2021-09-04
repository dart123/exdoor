<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 17.02.2017
 * Time: 17:19
 */
?>

<script type="text/html" id="mustache__partner__loop">

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
                <div>
                    <a class="js-partner__open_chat is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                        <i class="fas fa-envelope i-left-15"></i>
                        <span>Написать сообщение</span>
                    </a>
                </div>
                <?php /*
                <div>
                    <a href="index-16.html" target="_blank" class="is-blue-link">
                        <i class="fa fa-search i-left-15"></i>
                        <span>Найти его коллег</span>
                    </a>
                </div>
                */;?>

                <a class="js-partner__remove_user my-partners__del is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                    <i class="fas fa-trash-alt i-left-15"></i>
                    <span>Убрать из партнеров</span>
                </a>

                <a class="js-partner__undo_remove_user my-partners__del is-blue-link is-hidden" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{id}}">
                    <i class="fas fa-plus i-left-15"></i>
                    <span>Вернуть в партнеры</span>
                </a>

            </div>
        </div>

    {{/.}}

</script>
