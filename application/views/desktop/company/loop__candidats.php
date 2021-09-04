<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.03.17
 * Time: 16:37
 */
?>

<div class="my-candidats-edit-row js__list__partner" data-partner-id="<?php echo $id;?>">

    <div class="my-partners__row" >
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

                <div class="my-partners__status"><?php echo $status;?></div>
            </div>
        </div>

        <div class="my-partners__rcell">
            <div>
                <a class="ajax-candidat-employer is-blue-link" data-candidat-id="<?php echo $id;?>">
                    <i class="fas fa-check i-left-15"></i>
                    <span>Подтвердить</span>
                </a>
            </div>

            <div>
                <a class="ajax__employer_remove is-or-link" data-employer-id="<?php echo $id;?>">
                    <i class="fas fa-trash-alt i-left-15"></i>
                    <span>Отклонить</span>
                </a>
            </div>

        </div>
    </div>

    <div class="js__employer__control__block__<?php echo $id;?>">
        <label for="" class="my-company-profile__line-label prop"><span>Роль в компании</span>
            <select name="candidat[<?php echo $id;?>][]" id="role_candidat-<?php echo $id;?>" class="is-placeholder js__candidat_data_insert" data-employer-id="<?php echo $id;?>" data-action="role">
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
            <input name="candidat[<?php echo $id;?>][]" id="profession_candidat-<?php echo $id;?>" type="text" class="my-company-profile__input js__candidat_data_insert" value="<?php echo $company_profession;?>" data-employer-id="<?php echo $id;?>" data-action="profession">
        </label>
    </div>

</div>