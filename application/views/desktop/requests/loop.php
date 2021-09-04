<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.11.16
 * Time: 13:24
 */

?>

<li class="request__item req-item <?php echo $html_class;?>">
    <a href="/requests/<?php echo $id;?>" class="request__item--wrap">
        <p><b>#<?php echo $id;?>.</b> <span><?php echo $eq_brand;?>, <?php echo $eq_appointment;?>, <?php echo $eq_serial_number;?></span></p>
        <p class="req-item__descr">
            <?php
                if( $positions ):
                    foreach ($positions as $lst_position):
                        echo $lst_position->detail.', ';
                    endforeach;
                endif;
            ?>
        </p>
        <p class="is-last-el">
            <span>Статус: </span>
            <span class="req-item__status req-item__status--answered"><?php echo $status_text;?></span>
        </p>
    </a>

    <div class="req-item__helpers">
        <ul class="req-item__actions is-rounded is-box-shadow">
            <li class="is-first-item">
                <a href="/requests/<?php echo $id;?>/compare" >Сравнить предложения</a>
            </li>
            <li>
                <a href="/requests/<?php echo $id;?>">Редактировать</a>
            </li>
            <li class="is-last-item">
                <a href="#" target="_blank">Отменить</a>
            </li>
        </ul>
    </div>

    <?php
    if( $status == 'in_process' || $status == 'payed' ||  $status == 'delivered' || $status == 'done' ):
        if( $author == $this->session->user ):
            if( $rating_executor ):
                echo "<div class='req-item__rating'>Ваша оценка: <div class='company-profile__rating-level rate__lvl rate__lvl--".$rating_executor."'></div></div>";
            else:
                echo "<div class='req-item__rating'><a href='' class='is-blue-link'><i class='fa fa-star'></i> <span>Оценить</span></a></div>";
            endif;
        endif;

        if( $executor == $this->session->user ):
            if( $rating_author ):
                echo "<div class='req-item__rating'>Ваша оценка: <div class='company-profile__rating-level rate__lvl rate__lvl--".$rating_author."'></div></div>";
            else:
                echo "<div class='req-item__rating'><a href='' class='is-blue-link'><i class='fa fa-star'></i> <span>Оценить</span></a></div>";
            endif;
        endif;
    endif;?>

    <div class="req-item__time">
        <?php echo $date_output;?>
    </div>

</li>
