<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.04.17
 * Time: 20:43
 */

?>



<div class="request__item req-item <?php echo $html_class;?>   ajax__request_<?php echo $id;?>   ajax__request-item_list__<?php echo $user_id;?>__<?php echo $id;?>">
    <a href="<?php echo $html_url;?>" class="request__item--wrap ">
        <p>
            <b><?php if( isset($archived_request_title) ): echo $archived_request_title; endif;?> #<?php echo $id;?>.</b> <span><?php echo $eq_brand_name;?>, <?php echo $eq_appointment_name;?>, <?php echo $eq_serial_number;?></span>
        </p>
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
            <li class="is-first-item js__requests__context_menu" data-href="/requests/<?php echo $id;?>">
                <a>Открыть</a>
            </li>

            <?php if( $can__compare ):?>
                <li class="js__requests__context_menu" data-href="<?php echo $html_compare_url;?>">
                    <a>Сравнить предложения</a>
                </li>
            <?php endif;?>

            <?php if( $can__set_rating ):?>
                <li class="js__requests__context_menu" data-href="<?=$this->config->item('base_url');?>/requests/<?php echo $id;?>?set_rating=true">
                    <?php if( $finished ):?>
                        <a>Завершить</a>
                    <?php else:?>
                        <a><?php if($show_rating):?>Изменить оценку<?php else:?>Оценить партнера<?php endif;?></a>
                    <?php endif;?>

                </li>
            <?php endif;?>

            <?php if( $can__clone ):?>
                <li class="ajax__request__copy" data-request-id="<?php echo $id;?>">
                    <a>Копировать</a>
                </li>
            <?php endif;?>

            <?php if( $can__archived ):?>
                <li class="is-last-item ajax__request__send_to_archive" data-request-id="<?php echo $id;?>">
                    <a>Отправить в архив</a>
                </li>
            <?php endif;?>

            <?php if( $can__cancel ): ?>
                <?php if( $is_author ):?>
                    <li class="is-last-item js__requests_list__author_denied" data-request-id="<?php echo $id;?>" data-page-reload="no">
                        <a>Отменить</a>
                    </li>
                <?php else:?>
                    <li class="is-last-item js__requests_list__partner_denied" data-request-id="<?php echo $id;?>" data-page-reload="no">
                        <a>Отклонить</a>
                    </li>
                <?php endif;?>
            <?php endif;?>

        </ul>
    </div>
    <?php

    if( $can__set_rating ):
        if( !$show_rating ):
            if( $finished )
                $text_set_rating = 'Завершить и оценить';
            else
                $text_set_rating = 'Оценить';
            echo "<div class='req-item__rating'><a href='/requests/".$id."?set_rating=true' class='is-blue-link'><i class='fa fa-star'></i> <span>".$text_set_rating."</span></a></div>";
        else :
            if( $is_author ):
                if( $rating_executor ):
                    echo "<div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--".$rating_executor." js__requests__context_menu' data-href='/requests/".$id."?set_rating=true'></div>";
                endif;
            endif;

            if( $is_executor ):
                if( $rating_author ):
                    echo "<div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--".$rating_author." js__requests__context_menu' data-href='/requests/".$id."?set_rating=true'></div>";
                endif;
            endif;

        endif;
    else:
        if( $show_rating):
            if( $is_author ):
                if( $rating_executor ):
                    echo "<div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--".$rating_executor."' ></div>";
                endif;
            endif;

            if( $is_executor ):
                if( $rating_author ):
                    echo "<div class='req-item__rating company-profile__rating-level rate__lvl rate__lvl--".$rating_author."' ></div>";
                endif;
            endif;
        endif;
    endif;

    ?>

    <div class="req-item__time">
        <?php if( $author_info):?>
            <span class="is-grey-text">
                <i class="fa fa-child"></i>
            </span>
            <a href="/partners/<?php echo $author;?>"  class="req-item__manager is-fade"><?php echo $author_info->name.' '.$author_info->last_name;?></a>
        <?php endif;?>
        <?php echo $date_output;?>
    </div>

</div>

