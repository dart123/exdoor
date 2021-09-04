<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.08.16
 * Time: 21:11
 */

?>
<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li class="active">Компании</li>
</ol>

<div class="row">
    <div class="col-xs-8">
        <h1>Компании</h1>
    </div>
    <div class="col-xs-4">
        <br>
        <form method="post" action="/backend/companies">
            <div class="input-group">
                <input type="text" name="keywords" class="form-control" placeholder="Поиск по компаниям" value="<?php echo htmlspecialchars($this->session->backend__search_companies);?>">
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
    <ta class="col-xs-12">


        <?php if( $companies === false):?>
            <div class="well h3 text-center">
                <br>
                Не найдено ни одной компании
                <br>
                <br>
            </div>

        <?php else:?>

            <table class="table table-striped table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Директор</th>
                    <th>Статус</th>
                    <th class="text-right">Управление</th>
                </tr>


                <?php foreach ($companies as $company):?>
                    <tr>
                        <td>
                            <?php echo $company->id;?>
                        </td>
                        <td>
                            <a href="/backend/companies/<?php echo $company->id;?>">
                                <?php echo $company->short_name;?>
                            </a>
                        </td>
                        <td>
                            <a href="/backend/users/<?php echo $company->director;?>">
                                <?php echo $company->manager;?>
                            </a>
                        </td>
                        <td>
                            <?php if( !$company->active && $company->exdor_code != 0 ):?>
                                Ожидает подтверждения (Код: <?php echo $company->exdor_code;?>)
                            <?php elseif( $company->active && $company->approved == 'not_approved'):?>
                                На повторной модерции
                            <?php elseif( $company->active && $company->approved == 'approved'):?>
                                На модерции
                            <?php else:?>
                                Ошибка, требует вмешательства!
                            <?php endif;?>
                        </td>
                        <td>
                            <div class="text-right">
                                <?php if( $company->removed == '0' ):?>
                                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#switchActiveCompanyModal_<?php echo $company->id;?>">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </button>
                                <?php else:?>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#switchActiveCompanyModal_<?php echo $company->id;?>">
                                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                    </button>
                                <?php endif;?>

                                <a href="/company/id<?php echo $company->id;?>" target="_blank" class="btn btn-primary btn-sm">
                                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                                </a>
                                <a href="/backend/companies/<?php echo $company->id;?>" class="btn btn-success btn-sm">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>

                            </div>



                            <!-- Модальное окно для Активации/деактивации страницы -->
                            <div class="modal fade" id="switchActiveCompanyModal_<?php echo $company->id;?>" tabindex="-1" role="dialog" aria-labelledby="deleteCompanyModal">
                                <div class="modal-dialog" role="document">
                                    <form method="post">
                                        <input type="hidden" name="action" value="company_switch_active">
                                        <input type="hidden" name="companyID" value="<?php echo $company->id;?>">
                                        <?php if($company->removed == '1'):?>
                                            <input type="hidden" name="sub_action" value="activate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Активация</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Вы действительно хотите активировать эту компанию?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-success">Активировать</button>
                                                </div>
                                            </div>
                                        <?php elseif($company->removed == '0'):?>
                                            <input type="hidden" name="sub_action" value="deactivate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Деактивация</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Вы действительно хотите деактивировать эту компанию?
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

        <?php endif;?>

    </div>
</div>