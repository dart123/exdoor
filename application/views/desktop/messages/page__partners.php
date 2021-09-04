<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 26.07.16
 * Time: 20:13
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
                    <li><a href="/messages/" class="is-fade" id="js__messages__top_menu__new-messages">Мои переписки <span><?php if($menu['new_messages']):?>(<?php echo $menu['new_messages'];?>)<?php endif;?></span></a></li>
                    <li><a class="active is-fade">Мои собеседники</a></li>
                </ul>
                <a href="#write-new-msg" class="fancybox clear sub-menu__add-news or-btn btn btn-info ripple-effect">
                    <i class="fas fa-plus"></i>
                    Написать сообщение
                </a>
            </div>

            <!--  Блок Мои переписки  -->
            <div class="my-dialogs is-mtop-20">

                <?php if( $partners ):?>
                    <div class="my-companion__form">
                        <form action="">
                            <div class="my-companion__select--wrap">
                                <select disabled class="my-companion__select select-box is-placeholder" id="selected-my-companion">
                                    <option selected value="">Все партнеры</option>
                                    <option value="">Компания и сервис A</option>
                                    <option value="">Компания B</option>
                                    <option value="">Inc C</option>
                                    <option value="">Company D</option>
                                </select>
                                <select id="tmp-select">
                                    <option id="tmp-option"></option>
                                </select>
                            </div>
                            <div class="submit--cover">
                                <input type="submit" class="my-companion__submit" value="">
                                <input type="search" class="js-autocomplete-partners-main my-companion__search is-rounded" placeholder="Поиск по контактам">
                            </div>
                        </form>
                    </div>
                    <!-- Список собеседников -->
                    <div class="js-autocomplete-partners-main__results my-companion__block is-rounded is-box-shadow is-mtop-20">
                        <?php
                            foreach ($partners as $partner):
                                $this->load->view('desktop/messages/loop__partners', $partner);
                            endforeach;
                        ?>
                    </div>
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

    <div class="temp_autocomplete_result_container" style="display: none">
        <?php
        foreach ($partners as $partner):
            $this->load->view('desktop/messages/loop__partners', $partner);
        endforeach;
        ?>
    </div>
</main>

<?php
    $this->load->view('desktop/messages/mustache_template__autocomplete_partners');

?>

<style>
    .autocomplete-suggestions {
        display: none !important;
    }
</style>
<script>
    $(document).ready( function () {
        $('.js-autocomplete-partners-main').autocomplete({
            serviceUrl:'/ajax/get_partners',
            minChars:1,
            noCache: false,
            onSearchStart:
                function () {
                    $('.js-autocomplete-partners-main__results').html('');

                },
            formatResult:
                function(suggestion, currentValue){
                    if( $('.js-autocomplete-partners-main').val().length >= 3 )
                    {
                        $('.js-autocomplete-partners-main__results').html('');
                        var template    = $('#autocomplete-partners__template').html(),
                            output      = Mustache.render(template, suggestion.data);
                        $('.js-autocomplete-partners-main__results').html(output);
                    }
                    else
                    {
                        var existing_static_result = $('.temp_autocomplete_result_container').html();
                        $('.js-autocomplete-partners-main__results').html( existing_static_result );
                    }

                },
            beforeRender:
                function (container, suggestions) {
                    if( $('.js-autocomplete-partners-main').val().length < 3 ) {
                        var existing_static_result = $('.temp_autocomplete_result_container').html();
                        $('.js-autocomplete-partners-main__results').html(existing_static_result);
                    }
                }
            }

        );

        $('#js-autocomplete-partners').autocomplete({
            serviceUrl:'/ajax/get_partners',
            minChars:1,
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
            }
        );
    });
</script>


<?php
    $this->load->view('desktop/misc/js/partners__open_chat');