<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.08.16
 * Time: 0:39
 */

if ($company->approved == 'not_approved') {
    $approved_text = 'Компания ожидает модерации';
} else {
    $approved_text = 'Компания авторизована';
}

?>

<ol class="breadcrumb">
    <li><a href="/backend">Главная</a></li>
    <li><a href="/backend/companies">Компании</a></li>
    <li class="active"><?php echo $company->short_name;?></li>
</ol>


<h1>Информация о компании</h1>
<h3><?php echo $company->short_name;?> <small>(<?php echo $approved_text;?>)</small></h3>
<br>



<div class="row">

    <div class="col-md-8">

        <h4>Руководитель</h4>
        <dl class="dl-horizontal">
            <dt>Ф.И.О.:</dt>
            <dd>
                <a href="/backend/users/<?php echo $company->director;?>"><?php echo $company->manager;?></a>
            </dd>

            <dt>Должность:</dt>
            <dd><?php echo $company->manager_post;?></dd>
        </dl>
        <br>

        <h4>Контакты</h4>
        <dl class="dl-horizontal">
            <dt>Телефон:</dt>
            <dd><?php echo $company->phone;?></dd>

            <dt>Email:</dt>
            <dd><?php echo $company->email;?></dd>

            <dt>Сайт:</dt>
            <dd><?php echo $company->site;?></dd>
        </dl>
        <br>

        <h4>Адреса</h4>
        <dl class="dl-horizontal">
            <dt>Юридический:</dt>
            <dd><?php echo $company->u_address;?></dd>

            <dt>Фактический:</dt>
            <dd><?php echo $company->f_address;?></dd>

            <dt>Почтовый:</dt>
            <dd><?php echo $company->p_address;?></dd>
        </dl>
        <br>

        <h4>Описание</h4>
        <?php echo $company->description;?>
    </div>

    <div class="col-md-4">
        <?php if( !$company->active && $company->exdor_code):?>
            <div class="alert alert-info" role="alert">
                <h1><?php echo $company->exdor_code;?></h1>
                <p>Компания не активирована. Необходимо отправить письмо на почтовый адрес организации на имя директора с указанным кодом.</p>
                <br>
                <a href="#" class="btn btn-success">Письмо уже отправлено</a>
            </div>
            <br>
        <?php endif;?>
        <h4>Реквизиты компании</h4>
        <dl class="dl-horizontal">
            <dt>ИНН:</dt>
            <dd><?php echo $company->inn;?></dd>

            <dt>КПП:</dt>
            <dd><?php echo $company->kpp;?></dd>

            <dt>ОГРН:</dt>
            <dd><?php echo $company->ogrn;?></dd>

            <dt>Банк:</dt>
            <dd><?php echo $company->bank_name;?></dd>

            <dt>БИК:</dt>
            <dd><?php echo $company->bank_bik;?></dd>

            <dt>Расчетный счет:</dt>
            <dd><?php echo $company->r_account;?></dd>

            <dt>Коор. счет:</dt>
            <dd><?php echo $company->k_account;?></dd>
        </dl>
        <br>
    </div>
</div>



<?php if($employers):?>
    <hr>

    <h2>Сотрудники</h2>

    <br>

    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Контакты</th>
            <th>Должность</th>
        </tr>
        <?php foreach($employers as $user):?>
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
                        <?php echo $user->phone;?><br>
                        <small><?php echo $user->name;?> <?php echo $user->last_name;?></small>
                    </a>
                </td>
                <td>
                    <?php if($user->email):?>
                        <a href="mailto:<?php echo $user->email;?>"><?php echo $user->email;?></a><br>
                    <?php endif;?>
                </td>
                <td>
                    <?php echo $user->company_profession;?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>

<?php endif;?>