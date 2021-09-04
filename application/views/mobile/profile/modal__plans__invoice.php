<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.08.17
 * Time: 16:54
 */
?>
<div id="plans__invoice" class="modal">



    <div class="modal__head">
        <div class="modal__head__section">
            <div class="modal__head__close">
                <a href="#" class="modal__close-btn"><i class="fa fa-times"></i>
                    <span class="m-hide">Закрыть</span>
                </a>
            </div>
        </div>
        <div class="modal__head__section">
            <div class="modal__title">Пополнить счет</div>
        </div>

        <div class="modal__head__section">

        </div>
    </div>

    <div class="modal__body" style="background: #fff;">

        <form action="/profile/plan/invoice" method="POST">

            <div class="advpost__form" style="padding: 10px;">

                <div class="form-input-group">


                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Счет
                        </div>
                        <div class="form-input-group__input-block">
                            <div>
                                <input type="radio" class="radio" name="invoice_type" id="invoice_fiz" checked/>
                                <label for="invoice_fiz" class="radio__label no--width tarif__payment_type">На физическое лицо</label>
                            </div>
                            <div class="is-mtop-5">
                                <input type="radio" class="radio no--width" name="invoice_type" id="invoice_com"/>
                                <label for="invoice_com" class="radio__label no--width tarif__payment_type">На компанию</label>
                            </div>
                        </div>
                    </div>



                </div>








                <div class="invoice__fiz_line form-input-group">

                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Сумма
                        </div>
                        <div class="form-input-group__input-block">
                            <input type="text" class="input__type-text advpost__input" name="" id="" placeholder="В рублях" pattern="[0-9]{2}">
                        </div>
                    </div>


                    <?php
                        $fio    = '';

                        if ($page_content["user"]->last_name)
                            $fio    .= $page_content["user"]->last_name;

                        if ($page_content["user"]->name && $page_content["user"]->name != $page_content["user"]->phone)
                            $fio    .= " ".$page_content["user"]->name;

                        if ($page_content["user"]->second_name)
                            $fio    .= " ".$page_content["user"]->second_name;
                    ?>
                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Плательщик
                        </div>
                        <div class="form-input-group__input-block">
                            <input name="invoice_fio" class="input__type-text    advpost__input" placeholder="Фамилия имя и отчество" value="<?php echo $fio;?>">
                        </div>
                    </div>

                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Адрес плательщика
                        </div>
                        <div class="form-input-group__input-block">
                            <textarea id="advpost__ta-title" name="invoice_address" class="input__type-text      advpost__ta-title limit-100" maxlength="100" placeholder="Не используйте слова «продам», «куплю»"></textarea>
                        </div>
                    </div>
                </div>

                <div class="invoice__com_line    form-input-group" style="display: none">

                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Сумма
                        </div>
                        <div class="form-input-group__input-block">
                            <input type="text" class="input__type-text advpost__input" name="" id="" placeholder="В рублях" pattern="[0-9]{2}">
                        </div>
                    </div>

                    <?php
                        $fio    = '';

                        if ($page_content["user"]->last_name)
                            $fio    .= $page_content["user"]->last_name;

                        if ($page_content["user"]->name && $page_content["user"]->name != $page_content["user"]->phone)
                            $fio    .= " ".$page_content["user"]->name;

                        if ($page_content["user"]->second_name)
                            $fio    .= " ".$page_content["user"]->second_name;
                    ?>

                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Плательщик
                        </div>
                        <div class="form-input-group__input-block">
                            <input name="invoice_fio" class="input__type-text    advpost__input" placeholder="Фамилия имя и отчество" value="<?php echo $fio;?>">
                        </div>
                    </div>

                    <div class="form-input-group__container">
                        <div class="form-input-group__label">
                            Адрес плательщика
                        </div>
                        <div class="form-input-group__input-block">
                            <textarea id="advpost__ta-title" name="invoice_address" class="input__type-text      advpost__ta-title limit-100" maxlength="100" placeholder="Не используйте слова «продам», «куплю»"></textarea>
                        </div>
                    </div>
                </div>



            </div>

            <div class="modal__footer text-right" style="padding: 10px;">

                <button type="submit" class="btn btn-block bl-btn" value="">
                    <i class="fa fa-check"></i>
                    <span>Выставить счет</span>
                </button>

            </div>

        </form>

    </div>



</div>
