<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.17
 * Time: 15:02
 */

?>


<!--  Заголовок позициии -->
<div class="requests-step__line requests-single__equipment is-mtop-20">

    <a class="is-blue-link request-positions__print-button" href="#" onclick="window.print();return false;" >
        <i class="fa fa-print"></i>
        <span>Печать</span>
    </a>

    <div class="requests-step__title">
        Запрашиваемые позиции
    </div>

</div>


<!--  Запрашиваемые позиции -->

<div class="requests-eq__block is-box-shadow is-mtop-20">
    <!--  Позиция номер 1 -->
    <?php
    $r_i = 1;
    foreach ($page_content["request_positions"] as $r_position): ?>
        <div class="requests-eq__item">
            <div class="requests-eq__pos-row">
                <div class="requests-eq__no"><b>#<?php echo $r_i;?></b></div><!--
                 --><div class="requests-eq__pos-descr">
                    <div class="position-name">

                        <?php if( $r_position->detail ):?>
                            <p><?php echo $r_position->detail;?></p>
                        <?php endif;?>

                        <?php if( $r_position->catalog_num ):?>
                            <p>Номер в каталогах: <?php echo $r_position->catalog_num;?></p>
                        <?php endif;?>

                        <p class="request_position__amount js__amount__position_<?php echo $r_position->id;?>" data-amount="<?php echo $r_position->amount;?>">
                            <?php echo $r_position->amount;?> шт.
                        </p>

                    </div>

                    <div class="clear"></div>
                    <div style="height: 10px;"></div>

                    <?php if (!empty($r_position->images_arr)):?>
                        <div class="clear"></div>
                        <div class="is-mtop-10">
                            <a href="#" data-open-id="album-<?php echo $r_position->id;?>" class="is-mtop-10 requests-eq__img <?php if( count($r_position->images_arr) == 1):?>requests-eq__img--1<?php elseif( count($r_position->images_arr) == 2):?>requests-eq__img--2<?php elseif(count($r_position->images_arr) > 2):?>requests-eq__img--more<?php endif;?> open-album">
                                <div class="requests-eq__inner">
                                    <img src="/uploads/requests/<?php echo $page_content["request_data"]->id;?>/158x158_<?php echo $r_position->images_arr[0];?>" alt="">
                                </div>
                            </a>


                            <div class="modal modal__block">
                                <?php foreach ($r_position->images_arr as $img):?>
                                    <a rel="album-<?php echo $r_position->id;?>" class="image-show" href="/uploads/requests/<?php echo $page_content["request_data"]->id;?>/lg1000_<?php echo $img;?>">
                                        <img src="/uploads/requests/<?php echo $page_content["request_data"]->id;?>/lg1000_<?php echo $img;?>" alt=""/>
                                    </a>
                                <?php endforeach;?>
                            </div>
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



<?php
    $this->load->view("mobile/requests/html_block__print__positions");