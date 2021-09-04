<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 08.11.2017
 * Time: 21:42
 */
?>


<tr>
    <td><?php echo $id;?></td>
    <td>
        <span class="label label-success">
            <?php echo $date;?>
        </span>
        &nbsp;
        <span class="badge">
            <i class="glyphicon glyphicon-eye-open"></i>  <?php echo $views;?>
        </span>

        <span class="badge">
            <i class="glyphicon glyphicon-envelope"></i> <?php echo $contacts;?>
        </span>
        <br>

        <?php echo $title;?>
    </td>
    <td>
        <a href="/backend/users/<?php echo $author_id;?>">
            <?php echo $name;?> <?php echo $last_name;?>
        </a>
    </td>
    <td>
        <?php
        switch( $type ) {
            case 'sell':
                echo "Продам";
                break;
            case 'buy':
                echo "Куплю";
                break;
            case 'service':
                echo "Услуга";
                break;
        }
        ?>
    </td>
    <td>
        <?php
        if( $category_text ):
            echo $category_text;
        else:
            echo '-';
        endif;
        ?>
    </td>
    <td>
        <?php
        if( $brand_text ):
            echo $brand_text;
        else:
            echo '-';
        endif;
        ?>
    </td>
    <td>
        <?php if( $boolean__barter ):?>
            <span class="label label-default">
                <span class="glyphicon glyphicon-refresh"></span> Возможен обмен
            </span><br>
        <?php endif;?>

        <?php
        if( $price && $max_price ):
            echo $price." - ". $max_price;
        elseif( $price ):
            echo $price;
        elseif( $max_price ):
            echo $max_price;
        else:
            echo "Цены не указаны";
        endif;

        ?>

    </td>

    <td>
        <div class="text-right">

            <?php if( $removed == '0' ):?>

                <a href="/offers/<?php echo $type.'/'.$id;?>" target="_blank" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                </a>

                <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActiveOffersModal_<?php echo $id;?>">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                </button>


            <?php else:?>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActiveOffersModal_<?php echo $id;?>">
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                </button>
            <?php endif;?>
            <a href="/backend/offers/<?php echo $id;?>" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
        </div>



        <!-- Модальное окно для Активации/деактивации страницы -->
        <div class="modal fade" id="switchActiveOffersModal_<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
            <div class="modal-dialog" role="document">
                <form method="post">
                    <input type="hidden" name="action" value="offer_switch_active">
                    <input type="hidden" name="offerID" value="<?php echo $id;?>">
                    <?php if($removed == '1'):?>
                        <input type="hidden" name="sub_action" value="activate">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Опубликовать объявление</h4>
                            </div>
                            <div class="modal-body">
                                Вы действительно хотите опубликовать это объявление?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-success">Опубликовать</button>
                            </div>
                        </div>
                    <?php elseif($removed == '0'):?>
                        <input type="hidden" name="sub_action" value="deactivate">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Скрыть объявление</h4>
                            </div>
                            <div class="modal-body">
                                Вы действительно хотите скрыть это объявление?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-danger">Скрыть</button>
                            </div>
                        </div>
                    <?php endif;?>

                </form>
            </div>
        </div>
    </td>
</tr>
