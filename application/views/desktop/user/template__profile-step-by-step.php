<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.08.16
 * Time: 22:32
 */

$current_date   = new DateTime('now');
$notice_date    = new DateTime( $user->notice_popup_time );
?>

<?php if ( $notice_date->getTimestamp() !=  $current_date->getTimestamp() ):?>
    <?php if($user->name == '') {?>
        <div class="personal-form is-rounded material-block-show">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Как Вас зовут?</div>
                <input type="text" class="personal-form__input is-rounded" placeholder="Имя" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
            </span>
                <a href="#" class="personal-form__close is-fade">Скрыть</a>
            </form>
        </div>
    <?php } elseif ($user->last_name == '') {?>
        <div class="personal-form is-rounded material-block-show">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Ваша фамилия?</div>
                <input type="text" class="personal-form__input is-rounded" placeholder="Фамилия" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
            </span>
                <a href="#" class="personal-form__close is-fade">Скрыть</a>
            </form>
        </div>
    <?php } elseif ($user->second_name == '') {?>
        <div class="personal-form is-rounded material-block-show">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Ваше отчество?</div>
                <input type="text" class="personal-form__input is-rounded" placeholder="Фамилия" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
            </span>
                <a href="#" class="personal-form__close is-fade">Скрыть</a>
            </form>
        </div>
    <?php } elseif ($user->city == '') { ?>
        <div class="personal-form is-rounded material-block-show">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Из какого Вы города?</div>
                <input type="text" class="personal-form__input is-rounded" placeholder="Город" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
            </span>
                <a href="#" class="personal-form__close is-fade">Скрыть</a>
            </form>
        </div>
    <?php } elseif ($user->email == '') { ?>
        <div class="personal-form is-rounded material-block-show">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Укажите ваш Email</div>
                <input type="text" class="personal-form__input is-rounded" placeholder="Город" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
            </span>
                <a href="#" class="personal-form__close is-fade">Скрыть</a>
            </form>
        </div>
    <?php } ?>

<?php endif;?>