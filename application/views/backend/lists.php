<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.08.16
 * Time: 17:04
 */
?>
<h1>Справочники</h1>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <h2>Должности</h2>
        <p>Должности используются физическими лицами в <b>профиле пользователя</b></p>
        <form class="form-horizontal" method="post">
            <div class="js-form-professions">
                <?php foreach( $professions as $profession):?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            <input type="checkbox" name="active[<?php echo $profession->id;?>]" value="1" <?php if($profession->active == 1):?>checked<?php endif;?>>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="profession[<?php echo $profession->id;?>]" class="form-control" id="input-profession-<?php echo $profession->id;?>"  value="<?php echo $profession->value;?>">
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="js-add-profession-field btn btn-primary">Добавить поле</button>
                    <button type="submit" class="btn btn-default">Сохранить</button>

                </div>
            </div>
        </form>
    </div>

    <div class="col-xs-12 col-sm-6">
        <h2>Роли</h2>
        <p>Роли используются директором при добавлении сотрудников в компанию</p>
        <form class="form-horizontal" method="post">
            <div class="js-form-roles">
                <?php foreach( $roles as $role):?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            <input type="checkbox" name="active[<?php echo $role->id;?>]" value="1" <?php if($role->active == 1):?>checked<?php endif;?>>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="role[<?php echo $role->id;?>]" class="form-control" id="input-role-<?php echo $role->id;?>"  value="<?php echo $role->value;?>">
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="js-add-role-field btn btn-primary">Добавить поле</button>
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <h2>Производители</h2>
        <p>Производители (бренды) используются для <b>профиля компании</b>, <b>объявлений</b>, <b>парка техники</b> и <b>заявок</b></p>
        <form class="form-horizontal" method="post">
            <div class="js-form-brands">
                <?php foreach( $brands as $brand):?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            <input type="checkbox" name="active[<?php echo $brand->id;?>]" value="1" <?php if($brand->active == 1):?>checked<?php endif;?>>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="brand[<?php echo $brand->id;?>]" class="form-control" id="input-brand-<?php echo $brand->id;?>"  value="<?php echo $brand->value;?>">
                        </div>
                    </div>
                <?php endforeach;?>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="js-add-brand-field btn btn-primary">Добавить поле</button>
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6">
        <h2>Категории объявлений</h2>
        <p>Категории используются для сортировки <b>объявлений</b></p>
        <form class="form-horizontal" method="post">
            <div class="js-form-offer-category">
                <?php foreach( $offer_catеgory as $offer_cat):?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            <input type="checkbox" name="active[<?php echo $offer_cat->id;?>]" value="1" <?php if($offer_cat->active == 1):?>checked<?php endif;?>>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="offer-category[<?php echo $offer_cat->id;?>]" class="form-control" id="input-offer-category-<?php echo $offer_cat->id;?>"  value="<?php echo $offer_cat->value;?>">
                        </div>
                    </div>
                <?php endforeach;?>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="js-add-offer-category-field btn btn-primary">Добавить поле</button>
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-6">
        <h2>Назначение техники</h2>
        <p>Назначение техники используется в <b>парке техники</b></p>
        <form class="form-horizontal" method="post">
            <div class="js-form-offer-eq_a">
                <?php foreach( $eq_appointment as $eq_a):?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            <input type="checkbox" name="active[<?php echo $eq_a->id;?>]" value="1" <?php if($eq_a->active == 1):?>checked<?php endif;?>>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="eq_a[<?php echo $eq_a->id;?>]" class="form-control" id="input-eq_a-<?php echo $eq_a->id;?>"  value="<?php echo $eq_a->value;?>">
                        </div>
                    </div>
                <?php endforeach;?>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="js-add-offer-eq_a-field btn btn-primary">Добавить поле</button>
                    <button type="submit" class="btn btn-default">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.js-add-profession-field').click( function() {
            $('.js-form-professions').append('<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="text" name="new_profession[]" class="form-control" placeholder="Наименование"> </div></div>');
        });
        $('.js-add-role-field').click( function() {
            $('.js-form-roles').append('<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="text" name="new_role[]" class="form-control" placeholder="Наименование"> </div></div>');
        });
        $('.js-add-brand-field').click( function() {
            $('.js-form-brands').append('<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="text" name="new_brand[]" class="form-control" placeholder="Наименование"> </div></div>');
        });
        $('.js-add-offer-category-field').click( function() {
            $('.js-form-offer-category').append('<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="text" name="new_offer-category[]" class="form-control" placeholder="Наименование"> </div></div>');
        });
        $('.js-add-offer-eq_a-field').click( function() {
            $('.js-form-offer-eq_a').append('<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="text" name="new_eq_a[]" class="form-control" placeholder="Наименование"> </div></div>');
        });
    })
</script>