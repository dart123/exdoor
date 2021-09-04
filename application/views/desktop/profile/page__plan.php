<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.08.17
 * Time: 15:29
 */
?>

<main>
    <div class="container">

        <div class="main-features">
            <?php $this->load->view('desktop/user/menu_user', $menu);?>
        </div>
        <!-- Правый сайдбар -->
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>

        <section class="page-content-form left-400">
            <div class="sub-menu is-mright-200">
                <ul class="sub-menu__list">
                    <li><a href="/profile" class="is-fade">Анкета</a></li>
                    <li><a href="/profile/company" class="is-fade">Моя компания</a></li>
                    <li><a href="/profile/security" class="is-fade">Безопасность</a></li>
                    <li><a class="active is-fade">Тарифный план</a></li>
                </ul>
            </div>

            <div class="page-content-form__left">
                <!--  Блок тарифа  -->
                <div class="is-mtop-20">
                    <!--  Левый блок с информацией о тарифе  -->
                    <div class="solution-about__block is-rounded is-box-shadow">
                        <div class="solution-about__name">
                            <b>
                                <?php
                                switch ( $user->tarif ) {
                                    case "free";
                                        echo "На пробу";
                                        break;
                                    case "premium_user":
                                        echo "Премиум &mdash; Пользователь";
                                        break;
                                    case "premium_company":
                                        echo "Премиум &mdash; Компания";
                                        break;
                                }
                                ?>
                            </b><span class="is-grey-text">- текущий тариф</span></div>
                        <div class="solution-about__price">Осталось <?php echo $user->tarif_days_left;?> дн.</div>
                        <a href="#plans__tarif__<?php echo $user->tarif;?>" class="fancybox solution-about__more is-blue-link"><span>информация о тарифе</span></a>
                    </div>

                    <div class="solution-descr__block is-rounded is-box-shadow is-mtop-20">
                        <div class="solution-descr__title">Подберите тариф</div>
                        <div class="solution-descr__choose">
                            <div class="solution-descr__name">
                                <b>Премиум &mdash; Пользователь</b><a href="#plans__tarif__premium_user" class="fancybox solution-about__more is-blue-link"><span>информация о тарифе</span></a>
                            </div>
                            <div class="solution-descr__price">
                                <input type="radio" class="radio" name="premium_user" id="solution-premium_fiz-01"  value="mounthly">
                                <label class="radio__label" for="solution-premium_fiz-01">1 000 <i class="fa fa-rub"></i> / мес</label>

                                <span class="solution-best">
                                    <input type="radio" class="radio" name="premium_user" id="solution-premium_fiz-02" checked  value="yearly">
                                    <label class="radio__label" for="solution-premium_fiz-02">10 000 <i class="fa fa-rub"></i> / год</label>
                                </span>
                                <span class="solution-info">дешевле на 2 000 <i class="fa fa-rub"></i></span>
                            </div>

                            <?php if ( $user->tarif != "premium_user" ):?>
                                <div class="solution__change">
                                    <a href="" class="or-btn btn btn-info ripple-effect       js__change_tarif__modal" data-type="user">Сменить тариф</a>
                                </div>
                            <?php else:?>
                                <div class="solution__change is-mtop-10 text-right">
                                    <span class="or-btn btn btn-info btn-block disabled" style="padding: 10px;">Это ваш тариф</span>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="solution-descr__choose">
                            <div class="solution-descr__name">
                                <b>Премиум &mdash; Компания</b><a href="#plans__tarif__premium_company" class="fancybox solution-about__more is-blue-link"><span>информация о тарифе</span></a>
                            </div>
                            <div class="solution-descr__price">
                                <input type="radio" class="radio" name="premium_company" id="solution-premium_company-01" value="mounthly">
                                <label class="radio__label" for="solution-premium_company-01">2 000 <i class="fa fa-rub"></i> / мес</label>

                                <span class="solution-best">
                                        <input type="radio" class="radio" name="premium_company" id="solution-premium_company-02" checked value="yearly">
                                <label class="radio__label" for="solution-premium_company-02">20 000 <i class="fa fa-rub"></i> / год</label>
                                    </span>
                                <span class="solution-info">дешевле на 4 000 <i class="fa fa-rub"></i> </span>
                            </div>

                            <?php if ( $user->tarif != "premium_company" ):?>
                                <div class="solution__change">
                                    <a href="" class="or-btn btn btn-info ripple-effect        js__change_tarif__modal" data-type="company">Сменить тариф</a>
                                </div>
                            <?php else:?>
                                <div class="solution__change is-mtop-10 text-right">
                                    <span class="or-btn btn btn-info btn-block disabled" style="padding: 10px;">Это ваш тариф</span>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- -->
                </div>
            </div>

            <div class="page-content-form__right">
                <!-- Правый блок тарифа -->
                <div class="solution-time__block is-mtop-20 is-rounded is-box-shadow">
                    <div class="half-counter--ver-wrap">
                        <div id="remind-days" class="counter half-counter">
                        </div>
                    </div>
                    <?php if ($user->tarif == "free"):?>
                        <div class="solution-time__title"><span>До окончания пробного периода <b id="remindVal" style="display: none;"></b></span></div>
                        <div class="solution-time__info">В течение этого времени Вам бесплатно доступны Премиум-возможности сети Exdor. <a href="" class="is-blue-link"><span>Подробнее</span></a></div>
                    <?php else:?>
                        <div class="solution-time__title"><span>Ваш тариф будет действовать еще <b id="remindVal" style="display: none;"></b></span></div>
                    <?php endif;?>
                </div>

                <div class="solution-pay__block is-rounded is-box-shadow is-mtop-20">
                    <p style="padding: 15px; display: inline-block; font-weight: bold; font-size: 1.5em"><?php echo $user->balance;?> <small><i class="fa fa-rub"></i></small> </p>
                    <a href="#plans__tarif__payment_history" class="fancybox solution-pay__history is-blue-link "><span>История платежей</span></a>
                    <a href="#plans__invoice" class="fancybox solution-pay__fill is-last-item btn-primary2 btn ripple-effect">Пополнить</a>
                </div>
            </div>

            <!-- Кнопка Подгружаю еще -->
        </section>
        <!-- Кнопка Наверх -->
    </div>
</main>







<!--  Подверждение  -->
<div id="change_plan" class="modal  modal__block is-rounded">
    <div class="modal__head modal__head--blue is-first-item">
        <div class="modal__title">Сменить тариф?</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>

    <div class="modal__content">

        <p>После того, как Вы подтвердите действие, мы мгновенно переведем Вас на новый тариф и спишем с баланса указаную стоимость.</p>
        <div class="confirm__block center is-mtop-20">
            <a href="#" data-type="" data-period=""  class="btn-inline    confirm__block-btn btn ripple-effect bl-btn btn-primary2 is-rounded     js__change_plan">
                <i class="fas fa-check"></i>
                <span>Да, сменить</span>
            </a>

            <a href="#" class="btn-inline    confirm__block-btn btn ripple-effect or-btn btn-info is-rounded"  onclick="$.fancybox.close();">
                <i class="fas fa-times"></i>
                <span>Нет, не менять</span>
            </a>
        </div>

    </div>
</div>
<!-- end Подверждение -->

<?php

    $this->load->view('desktop/profile/modal__plans__invoice');
    $this->load->view('desktop/profile/modal__plans__check_download');
    $this->load->view('desktop/profile/modal__plans__payment_history');

    $this->load->view('desktop/profile/modal__plans__tarif__free');
    $this->load->view('desktop/profile/modal__plans__tarif__premium_user');
    $this->load->view('desktop/profile/modal__plans__tarif__premium_company');

    $this->load->view('desktop/profile/js/profile_tarif');

?>



<script type="text/javascript">

    $(document).ready(function(){

        $("#remind-days").roundSlider({
            sliderType: "min-range",
            radius: 50,
            width: 2,
            value: 20,
            min: 1,
            max: <?php echo $user->tarif_days_range;?>,
            handleSize: 0,
            handleShape: "square",
            circleShape: "half-right",
            showTooltip: false,
            editableTooltip: false,
            tooltipFormat: "tooltipVal3"
        });

        $("#remind-days").roundSlider("option", "value", <?php echo $user->tarif_days_left;?>);
    });

    $(window).load(function() {
        var inputVal = $("#remind-days input").val();
        var title    = declOfNum(inputVal,[' день',' дня',' дней']);
        $('#remindVal').text(inputVal + title).fadeIn(500);
    });

</script>