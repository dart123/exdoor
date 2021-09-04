<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.08.17
 * Time: 16:54
 */
?>
<div id="plans__invoice" class="modal__block is-rounded">
    <div class="modal__head is-rounded">
        <div class="modal__title">Пополнить счет</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>
    <form action="/profile/plan/invoice" method="POST">
        <div class="modal__body">
            <div class="advpost__form">

                <div class="advpost__radio--line clear"><b>Выставить счет</b>
                    <div class="advpost__radio--cover">

                        <input type="radio" class="radio" name="invoice_type" id="invoice_fiz" checked/>
                        <label for="invoice_fiz" class="radio__label no--width tarif__payment_type">На физическое лицо</label>

                        <input type="radio" class="radio no--width" name="invoice_type" id="invoice_com"/>
                        <label for="invoice_com" class="radio__label no--width tarif__payment_type">На компанию</label>

                    </div>
                </div>

                <div class="invoice__fiz_line">


                    <label for="" class="advpost__line-label clear"><span>Сумма</span>
                        <input type="text" class="advpost__input" name="" id="invoice__price_fiz" placeholder="В рублях" pattern="[0-9]{*}">

                        <span class="advpost__new-input">
                            <a href="" class="is-or-link js__profile-plan__fast-price-link" data-value="1000" data-type="fiz">
                                <span>1 000 <i class="fa fa-rub"></i></span>
                            </a>
                            <a href="" class="is-or-link js__profile-plan__fast-price-link" data-value="10000" data-type="fiz">
                                <span>10 000 <i class="fa fa-rub"></i></span>
                            </a>
                        </span>

                    </label>

                    <?php
                    $fio    = '';

                    if ($user->last_name)
                        $fio    .= $user->last_name;

                    if ($user->name && $user->name != $user->phone)
                        $fio    .= " ".$user->name;

                    if ($user->second_name)
                        $fio    .= " ".$user->second_name;
                    ?>

                    <label for="" class="advpost__line-label clear"><span>Плательщик</span>
                        <input name="invoice_fio" class="advpost__input" style="width: 350px; margin-right: 0px" placeholder="Фамилия имя и отчество" value="<?php echo $fio;?>">
                    </label>


                    <label for="advpost__ta-title" class="advpost__line-label clear"><span>Адрес плательщика</span>
                        <textarea id="advpost__ta-title" name="invoice_address" class="advpost__ta-title limit-100" maxlength="100" placeholder="Не используйте слова «продам», «куплю»"></textarea>
                        <span class="textarea-count-label is-or-text">100</span>
                    </label>
                </div>

                <div class="invoice__com_line" style="display: none">
                    <label for="" class="advpost__line-label clear"><span>Сумма</span>
                        <input type="text" class="advpost__input" name="" id="invoice__price_com" placeholder="В рублях" pattern="[0-9]{*}">

                        <span class="advpost__new-input">
                            <a href="" class="is-or-link js__profile-plan__fast-price-link" data-value="2000" data-type="com">
                                <span>2 000 <i class="fa fa-rub"></i></span>
                            </a>
                            <a href="" class="is-or-link js__profile-plan__fast-price-link" data-value="20000" data-type="com">
                                <span>20 000 <i class="fa fa-rub"></i></span>
                            </a>
                        </span>

                    </label>

                    <?php
                    $fio    = '';

                    if ($user->last_name)
                        $fio    .= $user->last_name;

                    if ($user->name && $user->name != $user->phone)
                        $fio    .= " ".$user->name;

                    if ($user->second_name)
                        $fio    .= " ".$user->second_name;
                    ?>

                    <label for="" class="advpost__line-label clear"><span>Плательщик</span>
                        <input name="invoice_fio" class="advpost__input" style="width: 350px; margin-right: 0px" placeholder="Фамилия имя и отчество" value="<?php echo $fio;?>">
                    </label>


                    <label for="advpost__ta-title" class="advpost__line-label clear"><span>Адрес плательщика</span>
                        <textarea id="advpost__ta-title" name="invoice_address" class="advpost__ta-title limit-100" maxlength="100" placeholder="Не используйте слова «продам», «куплю»"></textarea>
                        <span class="textarea-count-label is-or-text">100</span>
                    </label>
                </div>



            </div>

            <!-- -->
        </div>
        <div class="modal__footer">
            <span class="add-equipment__submit--wrap is-last-item btn ripple-effect btn-primary2 ajax__offer_add pointer">
                <i class="fas fa-check"></i>
                <input type="submit" class="add-equipment__submit" value="Выставить">
            </span>
        </div>
        <ul class="filelist__clone filelist__clone_offers"></ul>
    </form>
</div>
