<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.03.17
 * Time: 16:37
 */
?>


<div class="my-candidats-edit-row js__list__partner" data-partner-id="<?php echo $id;?>">
    <div class="my-partners__row">
        <div class="my-partners__lcell">
            <?php if($avatar):?>
                <a href="/partners/<?php echo $id;?>" class="my-partners__image my-partners__image--image_exists my-partners__image__company_list is-rounded">
                    <img src="/uploads/users/<?php echo $id;?>/avatar/80x80_<?php echo $avatar;?>" alt="">
                </a>
            <?php else:?>
                <a href="/partners/<?php echo $id;?>" class="my-partners__image my-partners__image__company_list is-rounded">

                </a>
            <?php endif;?>

            <div class="my-partners__content my-partners__content__company_list">
                <a href="/partners/<?php echo $id;?>" class="my-partners__name is-blue-link"><span><b><?php echo $name;?> <?php echo $last_name;?></b></span></a>
                <div>
                    <?php if ($company):?>
                        <a href="/company/id<?php echo $company->id;?>" class="my-partners__company-name is-grey-link">
                            <span class="ajax__company_edit__employer_profession__<?php echo $id;?>"><?php echo $company_profession;?></span>
                        </a>
                    <?php else:?>
                        <a class="my-partners__company-name">
                            <span>Физическое лицо</span>
                        </a>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <div class="my-partners__rcell">
            <div>
                <a class="js-employer--change_data is-blue-link" data-employer-id="<?php echo $id;?>">
                    <i class="fas fa-pen i-left-15"></i>
                    <span>Изменить данные</span>
                </a>
                <br>
                <?php if ( $company->director != $id):?>
                <a class="ajax__employer_remove is-or-link" data-employer-id="<?php echo $id;?>">
                    <i class="fas fa-trash-alt i-left-15"></i>
                    <span>Исключить из компании</span>
                </a>
                <?php endif;?>
            </div>
        </div>

    </div>

    <div class="employer__control__block js__employer__control__block__<?php echo $id;?>">
        <label for="" class="my-company-profile__line-label prop"><span>Роль в компании</span>
            <select name="employer[<?php echo $id;?>][]" class="ajax__employer_data_update <?php if ( !$company_role ): echo 'is-placeholder'; endif;?>" data-employer-id="<?php echo $id;?>" data-action="role">
                <option value="" disabled selected>Роль сотрудника</option>
                <?php foreach( $roles as $role ):?>
                    <option value="<?php echo $role->id;?>" <?php if ($role->id == $company_role ): echo 'selected'; endif;?> >
                        <?php echo $role->value;?>
                    </option>
                <?php endforeach;?>
            </select>
        </label>
        <!--  -->
        <label for="" class="my-company-profile__line-label prop"><span>Должность</span>
            <input name="employer[<?php echo $id;?>][]" type="text" class="ajax__employer_data_update my-company-profile__input" value="<?php echo $company_profession;?>" data-employer-id="<?php echo $id;?>" data-action="profession">
        </label>
    </div>
</div>