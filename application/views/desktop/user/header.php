<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.16
 * Time: 17:06
 *
 */
?>
    <body class="<?php if( isset($body_class) ): echo $body_class; endif;?>">
        <header>
            <div class="header__bar">
                <div class="container">
                    <div class="header__logo--wrap">
                        <a href="/" class="header__logo">
                            <img src="/assets/img/header__logo.png" alt="">
                        </a>
                    </div>
                    <!-- Кнопки вызова виджета -->
                    <div class="header__widget"><!--
                            --><div  class="widget__exchange-value">
                            <span class="">$ — <span class="exchange-value__dollar"><?php echo $usd;?></span></span>
                            <span class="">€ — <span class="exchange-value__euro"><?php echo $eur;?></span></span>
                        </div><!--
                            -->
                        <a href="" class="widget__convert is-fade">
                            <div class="widget__convert-icon">
                                <div><i class="fas fa-euro-sign"></i><i class="fas fa-pound-sign"></i></div>
                                <div><i class="fas fa-dollar-sign"></i><i class="fas fa-ruble-sign"></i></div>
                            </div>
                            <span>Конвертер валют</span>
                        </a><!--
                        -->
                        <a href="#header__calc" class="widget__calc is-fade"><i class="fa fa-calculator"></i><span>Калькулятор</span></a><!--
                        -->
                        <a class="header__sign-out is-fade" href="/?logout=true"><span><?php echo $this->lang->line('logout');?></span></a><!--
                        -->
                    </div>
                    <!-- Поиск -->

                    <?php if( isset( $search_or_link ) && is_array( $search_or_link ) ):?>

                        <?php if( $search_or_link['type'] == 'link' ):?>

                            <a href="<?php echo $search_or_link['url'];?>" class="header__go-back is-white-link">
                                <i class="fa fa-caret-left"></i>
                                <span><?php echo $search_or_link['title'];?></span>
                            </a>

                        <?php elseif( $search_or_link['type'] == 'search' ):?>

                            <form action="/<?php echo $search_or_link["target"];?>/find" class="widget__search--wrap is-fade" method="get" id="">
                                <input type="search" name="query" id="search_<?php echo $search_or_link['target'];?>" class="widget__search is-rounded" autocomplete="off" placeholder="<?php echo $search_or_link['title'];?>"/>

                                <input type="submit" class="widget__submit" value="" title="Начать поиск">
                                <span class="search--active-cls" style="display: none"><i class="fas fa-times"></i></span>
                            </form>

                        <?php endif;?>

                    <?php endif;?>


                    <!-- Вызываемый Калькулятор -->
                    <div id="calculator" class="widget is-rounded is-box-shadow">
                        <div class="widget__head  is-first-item">
                            <div class="widget__title">Калькулятор</div>
                            <a href="" class="widget__close-btn">Закрыть <i class="fas fa-times"></i></a>
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

                    <!-- Вызываемый Конвертер валют -->
                    <div id="converter" class="widget is-rounded is-box-shadow">
                        <div class="widget__head  is-first-item">
                            <div class="widget__title">Конвертер валют</div>
                            <a href="" class="widget__close-btn">Закрыть <i class="fas fa-times"></i></a>
                        </div>
                        <div class="widget__body">
                            <div class="convert__currency is-rounded">
                                <div class="currency__1st-selected">
                                    <ul class="list__1st-selected  converter__from__container">
                                        <li>
                                            <a href="#" class="converter__from converter__currency_rub" data-currency="rub">
                                                <i class="fas fa-ruble-sign"></i> Рубли
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="#" class="converter__from converter__currency_usd" data-currency="usd">
                                                <i class="fas fa-dollar-sign"></i> Доллары
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="converter__from converter__currency_eur" data-currency="eur">
                                                <i class="fas fa-euro-sign"></i> Евро
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <a href="#" id="converter__reverse_currency" class="currency__equal-sign">
                                    <i class="fas fa-exchange-alt"></i>
                                </a>
                                <div class="currency__2nd-selected">
                                    <ul class="list__2nd-selected  converter__to__container">
                                        <li class="">
                                            <a href="#" class="converter__to converter__currency_usd" data-currency="usd">
                                                <i class="fas fa-dollar-sign"></i> Доллары
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="#" class="converter__to converter__currency_eur" data-currency="eur">
                                                <i class="fas fa-euro-sign"></i> в Евро
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#" class="converter__to converter__currency_rub" data-currency="rub">
                                                <i class="fas fa-ruble-sign"></i> в Рубли
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
                                    <li id="coverter__cbr_usd" data-value="<?php echo $usd;?>">Доллар – <i class="fas fa-dollar-sign"></i> <?php echo $usd;?></li>
                                    <li id="coverter__cbr_eur" data-value="<?php echo $eur;?>">Евро – <i class="fas fa-euro-sign"></i> <?php echo $eur;?></li>
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
                </div>
            </div>
        </header>

        <div class="preloader">
            <img src="/assets/img/preload.gif" alt="" class="preloader__img">
        </div>