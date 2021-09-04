<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.11.2017
 * Time: 11:28
 */
?>


<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/offers">Объявления</a></li>
    <li class="active"><?php echo $offer->title;?></li>
</ol>

<h1>
    <?php echo $offer->title;?>
</h1>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <form method="POST">
            <input type="hidden" name="action" value="update_offer">
            <input type="hidden" name="offer_id" value="<?php echo $offer->id;?>">
            <div class="row h4">

                <div class="col-xs-4">
                    <span class="label label-success">
                        <?php echo $offer->date;?>
                    </span>
                    &nbsp;
                    <span class="badge">
                        <i class="glyphicon glyphicon-eye-open"></i>  <?php echo $offer->views;?>
                    </span>

                    <span class="badge">
                        <i class="glyphicon glyphicon-envelope"></i> <?php echo $offer->contacts;?>
                    </span>
                </div>

                <div class="col-xs-5">

                    <a href="/backend/users/<?php echo $offer->author_id;?>">
                        <?php echo $offer->name;?> <?php echo $offer->last_name;?>
                    </a>

                </div>


                <div class="col-xs-3 text-right">

                    <?php if( $offer->removed == '0' ):?>

                        <a href="/offers/<?php echo $offer->type.'/'.$offer->id;?>" target="_blank" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                        </a>

                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActiveNewsModal_<?php echo $offer->id;?>">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </button>
                    <?php else:?>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActiveNewsModal_<?php echo $offer->id;?>">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </button>
                    <?php endif;?>

                </div>
            </div>


            <div class="row">
                <div class="col-xs-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="type" value="sell" <?php if($offer->type == 'sell') echo 'checked';?>>
                            Продажа
                        </label>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="type" value="buy" <?php if($offer->type == 'buy') echo 'checked';?>>
                            Покупка
                        </label>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="type" value="service" <?php if($offer->type == 'service') echo 'checked';?>>
                            Услуга
                        </label>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-xs-6">
                    <select class="form-control" name="brand">
                        <?php foreach( $brands as $brand):?>
                            <option value="<?php echo $brand->id;?>" <?php if($offer->brand == $brand->id):?>selected<?php endif;?>>
                                <?php echo $brand->value;?>
                            </option>

                        <?php endforeach;?>
                    </select>
                </div>

                <div class="col-xs-6">
                    <select class="form-control" name="category">
                        <?php foreach( $offer_catеgory as $category):?>
                            <option value="<?php echo $category->id;?>" <?php if($offer->category == $category->id):?>selected<?php endif;?>>
                                <?php echo $category->value;?>
                            </option>

                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <br>

            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="barter" value="1" aria-label="..." <?php if( $offer->barter ): echo "checked"; endif; ?>>
                    &nbsp;Бартер
                </span>
                <input type="text" name="barter_text" class="form-control" aria-label="..." value="<?php echo $offer->barter_text;?>">
            </div>

            <br>

            <div class="row">

                <div class="col-xs-4 col-xs-offset-4 ">
                    <div class="input-group">
                        <div class="input-group-addon">от</div>
                        <input class="form-control" type="text" name="price" value="<?php echo $offer->price;?>">
                        <div class="input-group-addon">руб</div>
                    </div>

                </div>

                <div class="col-xs-4">
                    <div class="input-group">
                        <div class="input-group-addon">до</div>
                        <input class="form-control" type="text" name="max_price" value="<?php echo $offer->max_price;?>">
                        <div class="input-group-addon">руб</div>
                    </div>
                </div>
            </div>

            <br>

            <textarea class="form-control" name="content"><?php echo $offer->content;?></textarea>

            <br>

            <div class="text-right">
                <input type="submit" class="btn btn-success" value="Сохранить">
            </div>
        </form>


    </div>
    <div class="col-xs-12 col-sm-4">

    </div>
</div>





<!-- Модальное окно для Активации/деактивации страницы -->
<div class="modal fade" id="switchActiveNewsModal_<?php echo $offer->id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
    <div class="modal-dialog" role="document">
        <form method="post">
            <input type="hidden" name="action" value="offer_switch_active">
            <input type="hidden" name="offerID" value="<?php echo $offer->id;?>">
            <?php if($offer->removed == '1'):?>
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
            <?php elseif($offer->removed == '0'):?>
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



<script>
    $(function () {
        $('#date_add_input').datetimepicker({
            locale: 'ru',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });
    $(".js-url-input").keyup(function() {
        this.value = this.value.replace(/[^a-z0-9-_]/i, "");
    });

</script>