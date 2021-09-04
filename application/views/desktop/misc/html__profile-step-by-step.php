<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.08.16
 * Time: 22:32
 */


$current_date   = new DateTime('now');
$notice_date    = new DateTime( $user->notice_popup_time );

if ( $notice_date->getTimestamp() <=  $current_date->getTimestamp() ):

    $i      = 3;
    $show   = '';

    if( $user->name == '' && $user->notice_popup_count_name < $i ) {
        $i      = $user->notice_popup_count_name;
        $show   = 'name';
    }

    if( $user->last_name == '' && $user->notice_popup_count_lastname < $i ) {
        $i      = $user->notice_popup_count_lastname;
        $show   = 'last_name';
    }

    if( $user->second_name == '' && $user->notice_popup_count_secondname < $i ) {
        $i      = $user->notice_popup_count_secondname;
        $show   = 'second_name';
    }

    if( !$user->city && $user->notice_popup_count_city < $i ) {
        $i      = $user->notice_popup_count_city;
        $show   = 'city';
    }

    if( $user->email == '' && $user->notice_popup_count_email < $i ) {
        $i      = $user->notice_popup_count_email;
        $show   = 'email';
    }

    if( isset( $user_brands ) && empty( $user_brands ) && $user->notice_popup_count_brands < $i ) {
        $i      = $user->notice_popup_count_brands;
        $show   = 'brands';
    }

    if( $user->direction == 'none' && $user->notice_popup_count_direction < $i ) {
        $i      = $user->notice_popup_count_direction;
        $show   = 'direction';
    }

    ?>




    <?php if($show == 'name') :?>
        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Как Вас зовут?</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                <input type="text" class="personal-form__input is-rounded js__profile-sts__input" name="name" placeholder="Имя" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                        </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>
    <?php elseif ($show == 'last_name') :?>
        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Ваша фамилия?</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                <input type="text" class="personal-form__input is-rounded js__profile-sts__input" name="last_name" placeholder="Фамилия" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                        </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>
    <?php elseif ($show == 'second_name') :?>
        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Ваше отчество?</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                <input type="text" class="personal-form__input is-rounded js__profile-sts__input" name="second_name" placeholder="Отчество" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                        </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>
    <?php elseif ($show == 'city') : ?>
        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Из какого Вы города?</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                <input type="hidden" name="city_id" class="js__profile-sts__hidden_input" value="0">
                <input type="text" id="js-autocomplete-city__profile-sts" class="personal-form__input is-rounded js__profile-sts__input" name="city" placeholder="Город" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                        </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>

        <script>
            $('#js-autocomplete-city__profile-sts').autocomplete({

                serviceUrl:'/ajax/get_city',
                minChars:2,
                noCache: false,
                onSearchStart:
                    function () {
                        $('.js__profile-sts__hidden_input').val( '' );
                        //$(this).addClass('input__wrong_data');
                    },
                onSelect:
                    function(suggestion){
                        $('.js__profile-sts__hidden_input').val( suggestion.data.city_id );
                        $(this).removeClass('input__wrong_data');
                    },
                onSearchError:
                    function() {
                        $('.js__profile-sts__hidden_input').val( '' );
                        $(this).addClass('input__wrong_data');
                    },
                formatResult:
                    function(suggestion, currentValue){
                        return (suggestion.data.name+', '+ suggestion.data.region + ', ' +suggestion.data.country);
                    }
            });
        </script>
    <?php elseif ($show == 'email') : ?>
        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Укажите ваш E-mail</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                <input type="email" class="personal-form__input is-rounded js__profile-sts__input" name="email" placeholder="E-mail" required="">
                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                                <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                            </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>


    <?php elseif ($show == 'brands') : ?>



        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">С какими производителями Вы работаете?</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                <select id="js__select__brand_tags" name="brand[]" multiple class="demo-default js__profile-sts__input" placeholder="Выберите производителей" required="">
                    <?php foreach($brands as $brand):?>
                        <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"><?php echo $brand->value;?></option>
                    <?php endforeach;?>
                </select>
                <br>

                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                    <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>
        <script>
            $('#js__select__brand_tags').selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                create: false,
                onChange: function () {
                    $('.selectize-input').removeClass('input__wrong_data');
                }
            });
        </script>



    <?php elseif ($show == 'direction') : ?>


        <div class="personal-form is-rounded material-block-show js__profile-sts__block">
            <h2>Нет времени на заполнение анкеты? Давайте сделаем это постепенно!</h2>
            <form action="" class="personal-form__step personal-form__step-one">
                <div class="personal-form__title">Ваше направление деятельности?</div>
                <input type="hidden" name="user_id" value="<?php echo $user->id;?>">

                <div class="profile-sts__block__checkbox">
                    <div>
                        <input type="checkbox" class="show__checkbox js__profile-sts__input" id="com-type-1" name="direction[]" value="sell" <?php echo( $user->direction == 'sell' || $user->direction == 'all' ) ? 'checked' : '';?>>
                        <label class="show__label-c" for="com-type-1">Продавец</label>
                    </div>
                    <div>
                        <input type="checkbox" class="show__checkbox js__profile-sts__input" id="com-type-2" name="direction[]" value="buy" <?php echo( $user->direction == 'buy' || $user->direction == 'all' ) ? 'checked' : '';?>>
                        <label class="show__label-c" for="com-type-2">Покупатель</label>
                    </div>
                </div>

                <span class="is-over-submit btn ripple-effect btn-primary2 is-rounded">
                    <input type="submit" class="personal-form__submit is-rounded" value="Сохранить">
                </span>
                <a href="#" class="personal-form__close is-fade js__profile-sts__close_button">Скрыть</a>
            </form>
        </div>


    <?php endif; ?>
<?php endif;?>
