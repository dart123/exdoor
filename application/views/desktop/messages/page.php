<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.07.16
 * Time: 18:03
 */

?>
<main>
    <div class="container">
        <!-- Левый сайдбар -->
        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <!-- Контент -->
        <section class="page-content">

            <div class="sub-menu">
                <ul class="sub-menu__list">
                    <li><a class="active is-fade" id="js__messages__top_menu__new-messages">Мои переписки <span><?php if($menu['new_messages']):?>(<?php echo $menu['new_messages'];?>)<?php endif;?></span></a></li>
                    <li><a href="/messages/partners" class="is-fade">Мои собеседники</a></li>
                </ul>
                <a href="#write-new-msg" class="fancybox clear sub-menu__add-news or-btn btn btn-info ripple-effect">
                    <i class="fas fa-plus"></i>
                    Написать сообщение
                </a>
            </div>

            <!--  Блок Мои переписки  -->
            <div class="my-dialogs is-mtop-20">
                <!-- Отображать фон , если диалогов нет -->
                <?php if($dialogs):?>
                    <!-- Список диалогов -->
                    <div class="my-dialogs__block is-rounded  is-box-shadow js__dialogs_page__dialogs_list">
                        <?php
                        foreach ($dialogs as $dialog):
                            $this->load->view('desktop/messages/loop__dialog', $dialog);
                        endforeach;
                        ?>
                    </div>

                    <div class="my-dialogs__last is-no-select">Больше вы ни с кем не переписывались...</div>
                <?php else:?>
                    <div class="my-dialogs--empty">
                        <span class="no-dialogs">
                            <i class="far fa-envelope"></i>
                            <div class="is-no-select">Вы еще ни с кем не переписывались...</div>
                        </span>
                        <i class="fa fa-long-arrow-up"></i>
                    </div>
                <?php endif;?>

            </div>

            <!-- Кнопка Подгружаю еще  -->
        </section>
        <!-- Кнопка Наверх -->

        <!-- Написать сообщение -->
        <div id="write-new-msg" class="new-msg__modal">
            <div class="new-msg__top-line">
                <div class="new-msg__title">Кому напишем?</div>

                <div class="submit--rcover">
                    <input type="submit" class="new-msg__submit" value="">
                    <input type="search" id="js-autocomplete-partners" class="new-msg__search is-rounded" placeholder="Поиск по контактам">
                </div>

                <a href="" class="new-msg__close-btn"><i class="fas fa-times"></i></a>
            </div>
            <div class="new-msg__block is-rounded is-box-shadow">

                <?php

                /*
                 *
                 * Партнеры для диалогов
                 *
                 */

                ?>

            </div>
        </div>
        <!-- end Написать сообщение -->
    </div>
</main>


<script type="text/html" id="autocomplete-partners__template">
    {{#.}}
    <a class="js-partner__open_chat new-msg__row is-first-item pointer is-fade" data-user-id="<?php echo $this->session->user;?>" data-partner-id="{{partner_id}}">
        <div class="new-msg__image is-rounded">
            {{#avatar}}
            <img src="/uploads/users/{{partner_id}}/avatar/80x80_{{avatar}}" class="img-responsive" alt="">
            {{/avatar}}
            {{^avatar}}
            <img src="/assets/img/news-advpost-head__photo--empty.jpg" class="img-responsive" alt="">
            {{/avatar}}
        </div>
        <div class="new-msg__content">
            <div class="new-msg__name">{{name}} {{last_name}}</div>
        </div>
    </a>
    {{/.}}
</script>
<style>
    .autocomplete-suggestions {
        display: none !important;
    }
</style>
<script>
    $(document).ready( function () {
        $('#js-autocomplete-partners').autocomplete({

            serviceUrl:'/ajax/get_partners',
            minChars:3,
            noCache: false,
            onSearchStart:
                function () {
                    $('.new-msg__block').html('');
                },
            formatResult:
                function(suggestion, currentValue){
                    $('.new-msg__block').html('');
                    var template    = $('#autocomplete-partners__template').html(),
                        output      = Mustache.render(template, suggestion.data);
                    $('.new-msg__block').html(output);
                }
        });
    });
</script>

<?php

    $this->load->view('desktop/messages/mustache_template__loop_dialog');

    $this->load->view('desktop/misc/js/partners__open_chat');
