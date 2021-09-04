<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.04.2018
 * Time: 18:24
 */

?>
<?php /*
        <script src="/assets__old/js/bootstrap.min.js"></script>
        <script src="/assets__old/js/app.js"></script>
        <script>
            /* подгрузка презентации из youtube  *
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/player_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            var player;
            function onYouTubePlayerAPIReady() {
                player = new YT.Player('videoplayer', {
                  height: '360',
                  width: '640',
                  videoId: 'S6RO8aNWCm0'
                });
            };

            function stopVideo() {
                player.stopVideo();
            };
            /* end youtube */

            /* остановка ролика youtube и смена стилей модальных окон *
            $("html, body").click(function(e) {
                if (!$(e.target).hasClass('js-open-presentation') && $('body').hasClass('video')) {
                    player.stopVideo();

                    setTimeout(function(){
                        $('body').removeClass('video');
                    },
                        500);
                }
            })
        </script>
*/ ;?>


        <!-- Вызываемый Конвертер валют -->
        <div id="converter" class="widget is-rounded is-box-shadow">
            <div class="widget__head  is-first-item">
                <div class="widget__title">Конвертер валют</div>
                <a href="" class="widget__close-btn">Закрыть <i class="fa fa-times"></i></a>
            </div>
            <div class="widget__body">
                <div class="convert__currency is-rounded">
                    <div class="currency__1st-selected">
                        <ul class="list__1st-selected  converter__from__container">
                            <li>
                                <a href="#" class="converter__from converter__currency_rub" data-currency="rub">
                                    <i class="fa fa-rub"></i> Рубли
                                </a>
                            </li>
                            <li class="active">
                                <a href="#" class="converter__from converter__currency_usd" data-currency="usd">
                                    <i class="fa fa-usd"></i> Доллары
                                </a>
                            </li>
                            <li>
                                <a href="#" class="converter__from converter__currency_eur" data-currency="eur">
                                    <i class="fa fa-eur"></i> Евро
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="#" id="converter__reverse_currency" class="currency__equal-sign">
                        <i class="fa fa-exchange"></i>
                    </a>
                    <div class="currency__2nd-selected">
                        <ul class="list__2nd-selected  converter__to__container">
                            <li class="">
                                <a href="#" class="converter__to converter__currency_usd" data-currency="usd">
                                    <i class="fa fa-usd"></i> Доллары
                                </a>
                            </li>
                            <li class="active">
                                <a href="#" class="converter__to converter__currency_eur" data-currency="eur">
                                    <i class="fa fa-eur"></i> в Евро
                                </a>
                            </li>
                            <li class="">
                                <a href="#" class="converter__to converter__currency_rub" data-currency="rub">
                                    <i class="fa fa-rub"></i> в Рубли
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="convert__rate is-rounded is-mtop-10">
                    <ul class="rate__wtitle">
                        <li class="active"><a href="">Курс ЦБ</a></li>
                    </ul>
                    <ul class="rate__wnum">
                        <li id="coverter__cbr_usd" data-value="<?php echo $page_header['usd'];?>">Доллар – <i class="fa fa-usd"></i> <?php echo $page_header['usd'];?></li>
                        <li id="coverter__cbr_eur" data-value="<?php echo $page_header['eur'];?>">Евро – <i class="fa fa-eur"></i> <?php echo $page_header['eur'];?></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="convert__enter-summ is-rounded is-mtop-10">
                    <div class="enter-summ__wtitle">Сколько <span id="converter__how_much_text">долларов</span>?</div>
                    <div class="enter-summ__wnum">
                        <input type="number" inputmode="numeric" id="converter__how_much_value" placeholder="Укажите число">
                    </div>
                </div>
                <div class="convert__res-summ is-rounded is-mtop-10">
                    <div class="res-summ__wtitle">Будет в <span id="converter__result_text">рублях</span></div>
                    <div class="res-summ__wnum" id="converter__result_value">0</div>
                </div>
            </div>
        </div>



        <!-- Вызываемый Калькулятор -->
        <div id="calculator" class="widget is-rounded is-box-shadow">
            <div class="widget__head  is-first-item">
                <div class="widget__title">Калькулятор</div>
                <a href="" class="widget__close-btn">Закрыть <i class="fa fa-times"></i></a>
            </div>
            <div class="widget__body">
                <table class="widget__table is-rounded is-box-shadow">
                    <tr class="">
                        <td colspan="4"  >
                            <div class="calculator__display--wrap">
                                <div id="calculator__display"></div>
                                <span class="calculator__history"></span>
                                <span class="calculator__memory__1"></span>
                                <span class="calculator__memory__2"></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="calc_backspace()" class="is-calc-btn is-calc-btn--d"><i class="fa fa-caret-left"></i></a></td>
                        <td colspan="2"><a href="#" onclick="reset()"  class=" is-calc-btn is-calc-btn--d">C</a></td>
                        <td><a href="#" onclick="calc('division')"  class="is-calc-btn is-calc-btn--m">/</a></td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="percent()" class="is-calc-btn is-calc-btn--l">%</a></td>
                        <td><a href="#" onclick="memory('m1')" id="calculator__m1" class="is-calc-btn is-calc-btn--l">M1</a></td>
                        <td><a href="#" onclick="memory('m2')" id="calculator__m2" class="is-calc-btn is-calc-btn--l">M2</a></td>
                        <td><a href="#" onclick="calc('multiplication')" class="is-calc-btn is-calc-btn--m">*</a></td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="prnt(7)" class="is-calc-btn is-calc-btn--l">7</a></td>
                        <td><a href="#" onclick="prnt(8)" class="is-calc-btn is-calc-btn--l">8</a></td>
                        <td><a href="#" onclick="prnt(9)" class="is-calc-btn is-calc-btn--l">9</a></td>
                        <td><a href="#" onclick="calc('subtraction')" class="is-calc-btn is-calc-btn--m">-</a></td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="prnt(4)" class="is-calc-btn is-calc-btn--l">4</a></td>
                        <td><a href="#" onclick="prnt(5)" class="is-calc-btn is-calc-btn--l">5</a></td>
                        <td><a href="#" onclick="prnt(6)" class="is-calc-btn is-calc-btn--l">6</a></td>
                        <td><a href="#" onclick="calc('addition')" class="is-calc-btn is-calc-btn--m">+</a></td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="prnt(1)" class="is-calc-btn is-calc-btn--l">1</a></td>
                        <td><a href="#" onclick="prnt(2)" class="is-calc-btn is-calc-btn--l">2</a></td>
                        <td><a href="#" onclick="prnt(3)" class="is-calc-btn is-calc-btn--l">3</a></td>
                        <td rowspan="2"><a href="#" onclick="result()" id="calculator__result" data-repeat="false" class="is-calc-btn is-calc-btn--m is-calc-res is-br-item">=</a></td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="#" onclick="prnt(0)" class="is-calc-btn is-calc-btn--l is-bl-item">0</a></td>
                        <td><a href="#" onclick="prnt('.')" class="is-calc-btn is-calc-btn--l">,</a></td>
                    </tr>
                </table>
            </div>
        </div>




        <!--  Триггер-ссылки нотификации -->
        <a href="#" class="notify-trigger notify-trigger--success" data-notifyStyle="success" data-notifyDuration="3000" data-notifyTitle="Спасибо!" data-notifyText="Данные отправлены, действие выполнено" style="height: 0; width: 0; font-size: 0"></a>

        <a href="#" class="notify-trigger notify-trigger--alert" data-notifyStyle="alert" data-notifyDuration="5000" data-notifyTitle="Ошибка!" data-notifyText="Данное действие не подтверждено и не выполнено" style="height: 0; width: 0; font-size: 0"></a>




        <?php
            $this->load->view('mobile/misc/mustache_template__notification');
            $this->load->view('desktop/partners/mustache_template__loop__partner');
            $this->load->view('desktop/partners/mustache_template__loop__request_inbox');
            $this->load->view('desktop/partners/mustache_template__loop__request_outbox');

            $this->load->view('mobile/user/footer__scripts');
            $this->load->view('mobile/misc/js/socket.io.php');
        ?>


        <?php if( isset( $notifications ) && is_array( $notifications ) ):?>
            <script type="text/javascript">
                $(document).ready(function () {
                    <?php foreach ( $notifications as $noty ):?>

                        <?php if ( !isset($noty_to_hide) || ( is_array($noty_to_hide) && !in_array( $noty->type, $noty_to_hide ) ) ):?>

                            var template    = $('#mustache__notification').html();
                            var output      = Mustache.render(template, <?php echo $noty->noty_json;?>);

                            noty({
                                text        : 'bottomLeft',
                                type        : 'alert',
                                dismissQueue: true,
                                layout      : 'bottomLeft',
                                theme       : 'relax_mobile',
                                template    : output,
                                timeout     : false,
                                closeWith   : ['button'],
                                animation: {
                                    open: {opacity: 'show'},
                                    close: {opacity: 'hide'},
                                    easing: 'linear',
                                    speed:  300 // opening & closing animation speed
                                }
                            });

                        <?php endif;?>

                    <?php endforeach;?>
                });
            </script>
        <?php endif;?>
    </body>
</html>