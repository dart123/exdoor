<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 03.03.17
 * Time: 18:15
 */
?>

<div class="js__new_employer__on_company_page">
    <?php if($candidats && $company->is_manager):?>
        <?php foreach ($candidats as $candidat):?>
            <div class="new-coworker is-mtop-20 is-rounded material-block-show js__candidat_employer__<?php echo $candidat->id;?>__company_page">
                <a href="/partners/<?php echo $candidat->id;?>" class="new-coworker__link clear">
                    <div class="new-coworker__photo is-rounded">
                        <?php if($candidat->avatar):?>
                            <img src="/uploads/users/<?php echo $candidat->id;?>/avatar/80x80_<?php echo $candidat->avatar;?>" alt="">
                        <?php endif;?>
                    </div>
                    <div class="new-coworker__name--cover">
                        <div class="new-coworker__name is-fade">
                            <?php if ($candidat->name && $candidat->last_name):?>
                                <?php echo $candidat->name;?> <?php echo $candidat->last_name;?>
                            <?php else:?>
                                Абонент <?php echo $candidat->phone;?>
                            <?php endif;?>
                        </div>
                    </div>
                </a>
                <div class="new-coworker__descr is-grey-text">
                    сообщил(а), что является сотрудником компании
                </div>
                <div class="new-coworker__role">
                    <select class="js-allow-add-employer is-placeholder" name="user-<?php echo $candidat->id;?>-role" id="role_candidat-<?php echo $candidat->id;?>" data-candidat-id="<?php echo $candidat->id;?>">
                        <option value="" disabled selected>Роль сотрудника</option>
                        <?php foreach( $roles as $role ):?>
                            <option value="<?php echo $role->id;?>">
                                <?php echo $role->value;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                    <input class="js-allow-add-employer" type="text" value="" placeholder="Должность" id="profession_candidat-<?php echo $candidat->id;?>" data-candidat-id="<?php echo $candidat->id;?>">
                </div>
                <div>
                    <a class="is-or-link new-coworker__accept ajax-candidat-employer" data-candidat-id="<?php echo $candidat->id;?>">
                        <i class="fas fa-check i-left-15"></i>
                        <span>Принять</span>
                    </a>
                    <a class="is-lgrey-link new-coworker__cancel ajax-candidat-noemployer" data-candidat-id="<?php echo $candidat->id;?>">
                        <i class="fas fa-times i-left-15"></i>
                        <span>Отказать</span>
                    </a>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>


<?php if($employers):?>
    <div class="main-coworkers is-mtop-20">

        <h2 class="section-title">Сотрудники <span class="section-title__sub ajax__employers_list__counter">(<?php echo $company->count_employers;?>)</span></h2>
        <div class="main-coworkers__block is-rounded">
            <ul class="main-coworkers__list coworkers-list ajax__employers_list">
                <?php foreach ($employers as $employer):?>
                    <li class="coworkers-list__item coworker-info" data-partner-id="<?php echo $employer->id;?>">
                        <a href="/partners/<?php echo $employer->id;?>" class="coworker-info__link">
                            <div class="coworker-info__photo is-rounded">
                                <?php if($employer->avatar):?>
                                    <img src="/uploads/users/<?php echo $employer->id;?>/avatar/80x80_<?php echo $employer->avatar;?>"  alt="">
                                <?php endif;?>
                            </div>
                            <div class="coworker-info__name is-fade">
                                <?php if($employer->name):?>
                                    <?php echo $employer->name;?>
                                <?php else :?>
                                    <?php echo $employer->phone;?>
                                <?php endif;?>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php endif;?>