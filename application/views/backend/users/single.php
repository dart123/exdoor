<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.08.16
 * Time: 0:20
 */
?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/users">Пользователи</a></li>
    <li class="active"><?php echo $user->name;?> <?php echo $user->last_name;?> <?php echo $user->second_name;?></li>
</ol>

<h1>Информация о пользователе</h1>
<h3><?php echo $user->name;?> <?php echo $user->last_name;?> <?php echo $user->second_name;?></h3>
<br>

<form method="POST">
    <input type="hidden" name="action" value="user_update">

    <div class="row">
        <div class="col-md-3">
            <?php if($user->avatar):?>
                <img src="/uploads/users/<?php echo $user->id;?>/avatar/180x180_<?php echo $user->avatar;?>" class="img-responsive img-thumbnail">
            <?php endif;?>
        </div>

        <div class="col-md-9">

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="inputLast_name">Фамилия</label>
                        <input type="text" name="last_name" class="form-control" id="inputLast_name" placeholder="Фамилия" value="<?php echo $user->last_name;?>">
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="inputName">Имя</label>
                        <input type="text" name="name" class="form-control" id="inputName" placeholder="Имя" value="<?php echo $user->name;?>">
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="inputSecond_name">Отчество</label>
                        <input type="text" name="second_name" class="form-control" id="inputSecond_name" placeholder="Отчество" value="<?php echo $user->second_name;?>">
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-xs-9">
                    <div class="form-group">
                        <label for="inputStatus">Статус</label>
                        <input type="text" name="status" class="form-control" id="inputStatus" placeholder="Статус" value="<?php echo $user->status;?>">
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="removed" value="1" <?php if($user->removed):?>checked<?php endif;?>>
                            Деактивирован
                        </label>
                    </div>
                </div>

            </div>

            <br>

            <div class="row">
                <div class="col-sm-4">
                    <p class="h3">Общее</p>
                    <br>

                    <label for="" class="my-pers-profile__line-label "><span>Населенный пункт</span>
                        <input type="hidden" id="js-input-city-hidden" name="city">
                        <input name="t_city" type="text" class="form-control my-pers-profile__input" id="js-autocomplete-city__profile" placeholder="Москва" value="<?php echo $user->city;?>" required>
                    </label>


                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="direction_sell" value="sell" <?php if($user->direction == "sell" || $user->direction == "all"):?>checked<?php endif;?>>
                            Продавец
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="direction_buy" value="buy" <?php if($user->direction == "buy" || $user->direction == "all"):?>checked<?php endif;?>>
                            Покупатель
                        </label>
                    </div>

                </div>
                <div class="col-sm-4">
                    <p class="h3">Контакты</p>
                    <br>

                    <div class="form-group">
                        <label for="inputPhone">Телефон</label>
                        <input type="phone" class="form-control" name="phone" id="inputPhone" placeholder="Телефон" value="<?php echo $user->phone;?>">
                    </div>

                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" value="<?php echo $user->email;?>">
                    </div>


                </div>
                <div class="col-sm-4">
                    <p class="h3">Производители</p>
                    <br>

                    <select id="js__select__brand_tags" name="brands[]" multiple class="demo-default" placeholder="Выберите производителей" required>
                        <?php foreach($brands as $brand):?>
                            <option id="brand-<?php echo $brand->id;?>" value="<?php echo $brand->id;?>"  <?php echo ( array_key_exists($brand->id, $user_brands) )? 'selected' :'';?>><?php echo $brand->value;?></option>
                        <?php endforeach;?>
                    </select>



                </div>
            </div>

            <hr>


            <h3>Информация о тарифе</h3>
            <div class="row">
                <div class="col-xs-4">
                    <label>Тариф</label>
                    <select name="tarif" class="form-control">
                        <option value="free" <?php if ($user->tarif == "free"):?>selected<?php endif;?>>Базовый</option>
                        <option value="premium_user" <?php if ($user->tarif == "premium_user"):?>selected<?php endif;?>>Премиум пользователь</option>
                        <option value="premium_company" <?php if ($user->tarif == "premium_company"):?>selected<?php endif;?>>Премиум компания</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <label>Действует до</label>
                    <input type="text" class="form-control" name="tarif_date_end" value="<?php echo $user->tarif_date_end;?>">
                    Осталось <?php echo $user->tarif_days_left;?> дн.
                </div>
                <div class="col-xs-4">
                    <label>Баланс</label>
                    <input type="text" class="form-control" name="balance" value="<?php echo $user->balance;?>">
                </div>
            </div>
            <br>
            <br>

            <input type="submit" class="btn btn-block btn-success" value="Сохранить">

            <hr>

            <div class="row">
                <div class="col-sm-3">
                    <p class="h3">Партнеры</p>
                </div>
                <div class="col-sm-3">
                    <p class="h3">
                        <?php echo $count_partners_all;?>
                        <?php if( $count_partners_all > 0 ):?>
                            <a href="#" data-toggle="modal" data-target="#list_partners_all">
                                <small>Всего</small>
                            </a>
                        <?php else:?>
                            <small>Всего</small>
                        <?php endif;?>
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="h3">
                        <?php echo $count_partners_inbox;?>
                        <?php if( $count_partners_inbox > 0 ):?>
                            <a href="#" data-toggle="modal" data-target="#list_partners_inbox">
                                <small>Входящие</small>
                            </a>
                        <?php else:?>
                            <small>Входящие</small>
                        <?php endif;?>
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="h3">
                        <?php echo $count_partners_outbox;?>
                        <?php if( $count_partners_outbox > 0 ):?>
                            <a href="#" data-toggle="modal" data-target="#list_partners_outbox">
                                <small>Исходящие</small>
                            </a>
                        <?php else:?>
                            <small>Исходящие</small>
                        <?php endif;?>
                    </p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-3">
                    <p class="h3">Заявки</p>
                </div>
                <div class="col-sm-3">
                    <p class="h3"><?php echo $count_requests_all;?> <small>Активных</small></p>
                    <ul class="list-unstyled">
                        <?php if($count_requests['archived']):?>
                            <li><?php echo $count_requests['archived'];?> В архиве</li>
                        <?php endif;?>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <p class="h3"><?php echo $count_requests_inbox;?> <small>Входящих</small></p>
                    <ul class="list-unstyled">
                        <?php if($count_requests['inbox']['formed']):?>
                            <li><?php echo $count_requests['inbox']['formed'];?> Сформированы</li>
                        <?php endif;?>
                        <?php if($count_requests['inbox']['process']):?>
                            <li><?php echo $count_requests['inbox']['process'];?> В работе</li>
                        <?php endif;?>
                        <?php if($count_requests['inbox']['done']):?>
                            <li><?php echo $count_requests['inbox']['done'];?> Завершены</li>
                        <?php endif;?>
                        <?php if($count_requests['inbox']['canceled']):?>
                            <li><?php echo $count_requests['inbox']['canceled'];?> Отменены</li>
                        <?php endif;?>


                    </ul>
                </div>
                <div class="col-sm-3">
                    <p class="h3"><?php echo $count_requests_outbox;?> <small>Исходящих</small></p>
                    <ul class="list-unstyled">
                        <?php if($count_requests['outbox']['formed']):?>
                            <li><?php echo $count_requests['outbox']['formed'];?> Сформированы</li>
                        <?php endif;?>
                        <?php if($count_requests['outbox']['process']):?>
                            <li><?php echo $count_requests['outbox']['process'];?> В работе</li>
                        <?php endif;?>
                        <?php if($count_requests['outbox']['done']):?>
                            <li><?php echo $count_requests['outbox']['done'];?> Завершены</li>
                        <?php endif;?>
                        <?php if($count_requests['outbox']['canceled']):?>
                            <li><?php echo $count_requests['outbox']['canceled'];?> Отменены</li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>

        </div>



    </div>

</form>

<hr>

<h3>Контент пользователя</h3>
<br>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#news" aria-controls="news" role="tab" data-toggle="tab">
            Новости
            <span class="badge">
                <i class="glyphicon glyphicon-list"></i>
                <?php echo $count_news['active'];?>/<?php echo $count_news['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-comment"></i>
                <?php echo $count_news_comments['active'];?>/<?php echo $count_news_comments['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-heart"></i>
                <?php echo $count_news_likes['active'];?>/<?php echo $count_news_likes['all'];?>
            </span>

        </a>
    </li>
    <li role="presentation">
        <a href="#offers" aria-controls="offers" role="tab" data-toggle="tab">
            Объявления
            <span class="badge">
                <i class="glyphicon glyphicon-list"></i>
                <?php echo $count_offers['active'];?>/<?php echo $count_offers['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-eye-open"></i>
                <?php echo $count_offers_views['active'];?>/<?php echo $count_offers_views['all'];?>
            </span>

            <span class="badge">
                <i class="glyphicon glyphicon-envelope"></i>
                <?php echo $count_offers_contacts['active'];?>/<?php echo $count_offers_contacts['all'];?>
            </span>
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="news">


        <?php if( is_array($user_news) ):?>
            <table class="table table-striped table-bordered">
                <?php $this->load->view('backend/news/list_header');

                foreach ($user_news as $news_item):
                    $this->load->view('backend/news/list_item', $news_item);
                endforeach;?>
            </table>
        <?php else:?>
            <div class="well text-center">
                Новостей не найдено
            </div>
        <?php endif;?>


    </div>
    <div role="tabpanel" class="tab-pane" id="offers">



        <?php if( $user_offers ):?>

            <table class="table table-striped table-bordered">

                <?php $this->load->view('backend/offers/list_header');

                foreach ($user_offers as $offer):
                    $this->load->view('backend/offers/list_item', $offer);
                endforeach;?>

            </table>
        <?php else:?>
            <div class="text-center">
                <p class="h3">Объявлений не найдено</p>
            </div>
        <?php endif;?>



    </div>
</div>







<div class="modal fade" id="list_partners_all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Партнеры пользователя</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                    </tr>
                    <?php foreach($user_partners as $u_partner):?>
                        <tr>
                            <td>
                                <?php echo $u_partner->id;?>
                            </td>
                            <td>
                                <?php if($u_partner->avatar):?>
                                    <a href="/backend/users/<?php echo $u_partner->id;?>" style="float: right; margin-left: 10px;">
                                        <img src="/uploads/users/<?php echo $u_partner->id;?>/avatar/80x80_<?php echo $u_partner->avatar;?>" style="width: 40px; height: 40px">
                                    </a>
                                <?php endif;?>
                                <a href="/backend/users/<?php echo $u_partner->id;?>">
                                    <?php echo $u_partner->phone;?><br>
                                    <small><?php echo $u_partner->name;?> <?php echo $u_partner->last_name;?></small>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach;?>
                </table>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="list_partners_inbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Входящие заявки</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                    </tr>
                    <?php foreach($user_partners_inbox as $u_partner):?>
                        <tr>
                            <td>
                                <?php echo $u_partner->id;?>
                            </td>
                            <td>
                                <?php if($u_partner->avatar):?>
                                    <a href="/backend/users/<?php echo $u_partner->id;?>" style="float: right; margin-left: 10px;">
                                        <img src="/uploads/users/<?php echo $u_partner->id;?>/avatar/80x80_<?php echo $u_partner->avatar;?>" style="width: 40px; height: 40px">
                                    </a>
                                <?php endif;?>
                                <a href="/backend/users/<?php echo $u_partner->id;?>">
                                    <?php echo $u_partner->phone;?><br>
                                    <small><?php echo $u_partner->name;?> <?php echo $u_partner->last_name;?></small>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach;?>
                </table>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="list_partners_outbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Исходящие заявки</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                    </tr>
                    <?php foreach($user_partners_outbox as $u_partner):?>
                        <tr>
                            <td>
                                <?php echo $u_partner->id;?>
                            </td>
                            <td>
                                <?php if($u_partner->avatar):?>
                                    <a href="/backend/users/<?php echo $u_partner->id;?>" style="float: right; margin-left: 10px;">
                                        <img src="/uploads/users/<?php echo $u_partner->id;?>/avatar/80x80_<?php echo $u_partner->avatar;?>" style="width: 40px; height: 40px">
                                    </a>
                                <?php endif;?>
                                <a href="/backend/users/<?php echo $u_partner->id;?>">
                                    <?php echo $u_partner->phone;?><br>
                                    <small><?php echo $u_partner->name;?> <?php echo $u_partner->last_name;?></small>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach;?>
                </table>
            </div>

        </div>
    </div>
</div>


<script src="/assets/js/selectize.js-master/dist/js/standalone/selectize.min.js"></script>
<link href="/assets/js/selectize.js-master/dist/css/selectize.css" rel="stylesheet" />




<style>
    .autocomplete-suggestions {
        border: 1px solid #e5e5e5;
        background: #fff;
        color: #333;
    }
    .autocomplete-suggestion {
        padding: 7px;
    }
    .autocomplete-suggestion:hover {
        background: #4dcfe0;
        color: #fff;
        cursor: pointer;
    }
</style>

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




    $('#js-autocomplete-city__profile').autocomplete({

        serviceUrl:'/ajax/get_city',
        minChars:2,
        noCache: false,
        onSearchStart:
            function () {
                $('#js-input-city-hidden').val( '' );

            },
        onSelect:
            function(suggestion){
                $('#js-input-city-hidden').val( suggestion.data.city_id );
                $(this).removeClass('input__wrong_data');
            },
        onSearchError:
            function() {
                $('#js-input-city-hidden').val( '' );
                $(this).addClass('input__wrong_data');
            },
        formatResult:
            function(suggestion, currentValue){
                return (suggestion.data.name+', '+ suggestion.data.region + ', ' +suggestion.data.country);
            }
    });
</script>