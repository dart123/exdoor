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
                    <?php if ( $page_content["company"] ):?>
                        <a href="/company/id<?php echo $page_content["company"]->id;?>" class="my-partners__company-name is-grey-link">
                            <span class="ajax__company_edit__employer_profession__<?php echo $id;?>"><?php echo $company_profession;?></span>
                        </a>
                    <?php else:?>
                        <a class="my-partners__company-name">
                            <span>Физическое лицо</span>
                        </a>
                    <?php endif;?>
                </div>

                <div class="is-mtop-10">
                    <p>
                        <a class="js-employer--change_data is-blue-link" data-employer-id="<?php echo $id;?>">
                            <i class="fa fa-pencil fa-2x i-left-15"></i>
                            <span>Изменить</span>
                        </a>
                    </p>

                    <?php if ( $page_content["company"]->director != $id):?>
                        <p class="is-mtop-5">
                            <a class="ajax__employer_remove is-or-link" data-employer-id="<?php echo $id;?>">
                                <i class="fa fa-trash-o fa-2x i-left-15"></i>
                                <span>Исключить</span>
                            </a>
                        </p>
                    <?php endif;?>
                </div>
            </div>
        </div>


    </div>

    <div class="employer__control__block js__employer__control__block__<?php echo $id;?>" style="display: none;">
        <label for="" class="my-company-profile__line-label prop"><span>Роль в компании</span>
            <select name="employer[<?php echo $id;?>][]" class="ajax__employer_data_update select select-box <?php if ( !$company_role ): echo 'is-placeholder'; endif;?>" data-employer-id="<?php echo $id;?>" data-action="role">
                <option value="" disabled selected>Роль сотрудника</option>
                <?php foreach( $page_content["roles"] as $role ):?>
                    <option value="<?php echo $role->id;?>" <?php if ($role->id == $company_role ): echo 'selected'; endif;?> >
                        <?php echo $role->value;?>
                    </option>
                <?php endforeach;?>
            </select>
        </label>
        <!--  -->
        <label for="" class="my-company-profile__line-label prop"><span>Должность</span>
            <input name="employer[<?php echo $id;?>][]" type="text" class="ajax__employer_data_update my-company-profile__input  input__type-text" value="<?php echo $company_profession;?>" data-employer-id="<?php echo $id;?>" data-action="profession">
        </label>
    </div>
</div>