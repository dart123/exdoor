<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 31.10.16
 * Time: 16:44
 */
?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li class="active">Объявления</li>
</ol>

<div class="row">
    <div class="col-xs-8">
        <h1>
            Объявления
        </h1>
    </div>
    <div class="col-xs-4">
        <br>
        <form method="post" action="/backend/offers">
            <div class="input-group">
                <input type="text" name="keywords" class="form-control" placeholder="Поиск по объявлениям" value="<?php echo $this->session->backend__search_offers;?>">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Поиск</button>
                </span>
                <span class="input-group-btn">
                     <button type="submit" name="clear" value="clear_keywords" class="btn btn-danger">Сбросить</button>
                </span>
            </div><!-- /input-group -->
        </form>

    </div>
</div>

<p>
    Данные по объявлениям<br>
    <span class="badge">
        <i class="glyphicon glyphicon-list"></i>
        <?php echo $count_all_offers['active'];?>/<?php echo $count_all_offers['all'];?>
    </span>

    <span class="badge">
        <i class="glyphicon glyphicon-eye-open"></i>
        <?php echo $count_all_offers_views['active'];?>/<?php echo $count_all_offers_views['all'];?>
    </span>

    <span class="badge">
        <i class="glyphicon glyphicon-envelope"></i>
        <?php echo $count_all_offers_contacts['active'];?>/<?php echo $count_all_offers_contacts['all'];?>
    </span>



</p>
<br>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <?php if( $offers ):?>

            <table class="table table-striped table-bordered">
                <?php $this->load->view('backend/offers/list_header');

                foreach ( $offers as $offer ):
                    $this->load->view('backend/offers/list_item', $offer);
                endforeach;?>
            </table>
            <?php echo $pagination;?>
        <?php else:?>
            <div class="text-center">
                <p class="h3">Объявлений не найдено</p>
            </div>
        <?php endif;?>
    </div>
</div>

