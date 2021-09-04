<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.06.16
 * Time: 14:15
 */

?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li class="active">Пользователи</li>
</ol>

<div class="row">
    <div class="col-xs-8">
        <h1>Пользователи</h1>
    </div>
    <div class="col-xs-4">
        <br>
        <form method="post" action="/backend/users">
            <div class="input-group">
                <input type="text" name="keywords" class="form-control" placeholder="Поиск по пользователям" value="<?php echo $this->session->backend__search_users;?>">
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
<div class="row">
    <div class="col-xs-12">
        <?php if($users):?>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Контакты</th>
                    <th>Тариф</th>
                    <th class="text-right">Управление</th>
                </tr>
                <?php foreach($users as $user):?>
                    <tr>
                        <td>
                            <?php echo $user->id;?>
                        </td>
                        <td>
                            <?php if($user->avatar):?>
                                <a href="/backend/users/<?php echo $user->id;?>" style="float: right; margin-left: 10px;">
                                    <img src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" style="width: 40px; height: 40px">
                                </a>
                            <?php endif;?>
                            <a href="/backend/users/<?php echo $user->id;?>">
                                <?php echo $user->last_name;?> <?php echo $user->name;?> <br>
                                <small><?php echo $user->phone;?></small>
                            </a>
                        </td>
                        <td>
                            <?php if( is_object($user->company) && property_exists($user->company, 'short_name') ):?>
                                <a href="/backend/companies/<?php echo $user->company->id;?>">
                                    <?php echo $user->company->short_name;?>
                                </a><br>
                            <?php endif;?>
                            <small>
                                <?php if($user->email):?>
                                    <a href="mailto:<?php echo $user->email;?>"><?php echo $user->email;?></a><br>
                                <?php endif;?>
                                <?php if($user->city):?>
                                    <?php echo $user->city;?><br>
                                <?php endif;?>
                            </small>
                        </td>
                        <td>
                            <?php
                                switch ($user->tarif) {
                                    case 'free':
                                        echo 'На пробу';
                                        break;
                                    case 'premium_user':
                                        $date__tarif_end = new DateTime($user->tarif_date_end);
                                        echo 'Премиум &mdash; пользователь<br>';
                                        echo '<small>Подписка активна до '.$date__tarif_end->format('d.m.Y').'</small>';
                                        break;
                                    case 'premium_company':
                                        $date__tarif_end = new DateTime($user->tarif_date_end);
                                        echo 'Премиум &mdash; компания<br>';
                                        echo '<small>Подписка активна до '.$date__tarif_end->format('d.m.Y').'</small>';
                                        break;
                                }
                                ?>
                        </td>
                        <td>
                            <div class="text-right">
                                <?php if( $user->removed == '0' ):?>
                                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActiveUserModal_<?php echo $user->id;?>">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </button>
                                <?php else:?>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActiveUserModal_<?php echo $user->id;?>">
                                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                    </button>
                                <?php endif;?>

                                <a href="/partners/<?php echo $user->id;?>" target="_blank" class="btn btn-primary btn-sm">
                                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                                </a>
                                <a href="/backend/users/<?php echo $user->id;?>" class="btn btn-success btn-sm">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>

                            </div>



                            <!-- Модальное окно для Активации/деактивации страницы -->
                            <div class="modal fade" id="switchActiveUserModal_<?php echo $user->id;?>" tabindex="-1" role="dialog" aria-labelledby="deletePageModal">
                                <div class="modal-dialog" role="document">
                                    <form method="post">
                                        <input type="hidden" name="action" value="user_switch_active">
                                        <input type="hidden" name="userID" value="<?php echo $user->id;?>">
                                        <?php if($user->removed == '1'):?>
                                            <input type="hidden" name="sub_action" value="activate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Активация</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Вы действительно хотите активировать этого пользователя?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-success">Активировать</button>
                                                </div>
                                            </div>
                                        <?php elseif($user->removed == '0'):?>
                                            <input type="hidden" name="sub_action" value="deactivate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Деактивация</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Вы действительно хотите деактивировать этого пользователя?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-danger">Деактивация</button>
                                                </div>
                                            </div>
                                        <?php endif;?>

                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>

            <?php echo $pagination;?>
        <?php else:?>
            <div class="well h3 text-center">
                <br>
                Пользователи отсутствуют
                <br>
                <br>
            </div>
        <?php endif;?>
    </div>
</div>
