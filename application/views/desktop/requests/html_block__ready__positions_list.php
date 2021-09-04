<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.17
 * Time: 15:02
 */

?>


<!--  Заголовок позициии -->
<div class="requests-step__line is-mtop-20">
    <div class="requests-step__title">
        Запрашиваемые позиции
    </div>

    <a class="is-blue-link request-positions__print-button" href="#" onclick="window.print();return false;" >
        <i class="fa fa-print"></i>
        <span>Печать</span>
    </a>
</div>
<!--  Запрашиваемые позиции -->
<div class="requests-eq__block is-rounded is-box-shadow is-mtop-20">
    <!--  Позиция номер 1 -->
    <?php
    $r_i = 1;
    foreach ($request_positions as $r_position): ?>
        <div class="requests-eq__item">
            <div class="requests-eq__pos-row">
                <div class="requests-eq__no"><b>#<?php echo $r_i;?></b></div><!--
                 --><div class="requests-eq__pos-descr">
                    <div class="position-name is-grey-text">
                        <?php if( $r_position->detail ):?>
                            <p>Деталь:</p>
                        <?php endif;?>
                        <?php if( $r_position->catalog_num ):?>
                            <p>Номер в каталогах:</p>
                        <?php endif;?>
                    </div>
                    <div class="position-name">

                        <?php if( $r_position->detail ):?>
                            <?php if( mb_strlen( $r_position->detail, 'utf8' ) >= 12 ):?>
                                <span class="tooltip tooltip__request_positions">
                                    <p><?php echo $r_position->detail;?></p>
                                    <span class="tooltip__msg">
                                        <?php echo $r_position->detail;?>
                                    </span>
                                </span>
                            <?php else:?>
                                <p><?php echo $r_position->detail;?></p>
                            <?php endif;?>
                        <?php endif;?>

                        <?php if( $r_position->catalog_num ):?>
                            <?php if( mb_strlen( $r_position->catalog_num, 'utf8' ) >= 12 ):?>
                                <span class="tooltip tooltip__request_positions">
                                    <p>
                                        <?php echo $r_position->catalog_num;?>
                                    </p>
                                    <span class="tooltip__msg">
                                        <?php echo $r_position->catalog_num;?>
                                    </span>
                                </span>
                            <?php else:?>
                                <p><?php echo $r_position->catalog_num;?></p>
                            <?php endif;?>
                        <?php endif;?>

                        <p class="request_position__amount js__amount__position_<?php echo $r_position->id;?>" data-amount="<?php echo $r_position->amount;?>">
                            <?php echo $r_position->amount;?> шт.
                        </p>

                    </div>
                    <?php if (!empty($r_position->images_arr)):?>
                        <a href="#" data-open-id="album-<?php echo $r_position->id;?>" class="requests-eq__img <?php if( count($r_position->images_arr) == 1):?>requests-eq__img--1<?php elseif( count($r_position->images_arr) == 2):?>requests-eq__img--2<?php elseif(count($r_position->images_arr) > 2):?>requests-eq__img--more<?php endif;?> open-album">
                            <div class="requests-eq__inner">
                                <img src="/uploads/requests/<?php echo $request_data->id;?>/158x158_<?php echo $r_position->images_arr[0];?>" alt="">
                            </div>
                        </a>


                        <div class="modal__block">
                            <?php foreach ($r_position->images_arr as $img):?>
                                <a data-fancybox="album-<?php echo $r_position->id;?>" class="image-show" href="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>">
                                    <img src="/uploads/requests/<?php echo $request_data->id;?>/lg1000_<?php echo $img;?>" alt=""/>
                                </a>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php
        $r_i++;
    endforeach;
    ?>

</div>

<div class="print">
    <div class="print__logo">
        <img src="/assets/img/header__company--logo_backend.png">
    </div>
    <p class="print__h1">Список позиций для заявки <?php echo $request_positions[0]->request_id;?></p>

    <table>
        <tr>
            <th>№</th>
            <th>Деталь</th>
            <th>Номер в каталогах</th>
            <th>Количество</th>
            <th>Для пометок</th>
        </tr>
        <?php $r_i = 1;?>
        <?php foreach ($request_positions as $r_position):  ?>
            <tr>
                <td>
                    <?php echo $r_i;?>
                </td>
                <td>
                    <?php if( $r_position->detail ) echo $r_position->detail; ?>
                </td>
                <td>
                    <?php if( $r_position->catalog_num ) echo $r_position->catalog_num; ?>
                </td>
                <td>
                    <?php echo $r_position->amount;?> шт.
                </td>
                <td>

                </td>
            </tr>
            <?php $r_i++; ?>
        <?php endforeach; ?>
    </table>
</div>