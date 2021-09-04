<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.03.17
 * Time: 16:28
 */
?>



<script type="text/html" id="mustache_template__new_employer__edit_page">

    {{#.}}

    <div class="my-candidats-edit-row js__list__partner" data-partner-id="{{id}}">
        <div class="my-partners__row">
            <div class="my-partners__lcell">
                <a href="/partners/{{id}}" class="my-partners__image my-partners__image__company_list is-rounded">
                    {{#avatar}}
                        <img src="/uploads/users/{{id}}/avatar/80x80_{{avatar}}" alt="">
                    {{/avatar}}
                </a>
                <div class="my-partners__content my-partners__content__company_list">
                    <a href="/partners/{{id}}" class="my-partners__name is-blue-link"><span><b>{{name}} {{last_name}}</b></span></a>
                    <div>
                        <a class="my-partners__company-name is-grey-link">
                            <span>{{company_profession}}</span>
                        </a>
                    </div>

                    <div class="is-mtop-10">
                        <p>
                            <a class="js-employer--change_data is-blue-link" data-employer-id="{{id}}">
                                <i class="fa fa-pencil i-left-15"></i>
                                <span>Изменить данные</span>
                            </a>
                        </p>

                        <p class="is-mtop-5">
                            <a class="ajax__employer_remove is-or-link" data-employer-id="{{id}}">
                                <i class="fa fa-trash-o i-left-15"></i>
                                <span>Исключить из компании</span>
                            </a>
                        </p>

                    </div>
                </div>
            </div>


        </div>

        <div class="employer__control__block js__employer__control__block__{{id}}">
            <label for="" class="my-company-profile__line-label prop"><span>Роль в компании</span>
                <select name="employer[{{id}}][]" class="ajax__employer_data_update" data-employer-id="{{id}}" data-action="role">
                    <option value="" disabled selected>Роль сотрудника</option>
                    <?php foreach( $roles as $role ):?>
                        <option value="<?php echo $role->id;?>" >
                            <?php echo $role->value;?>
                        </option>
                    <?php endforeach;?>
                </select>
            </label>
            <!--  -->
            <label for="" class="my-company-profile__line-label prop"><span>Должность</span>
                <input name="employer[{{id}}][]" type="text" class="ajax__employer_data_update my-company-profile__input" value="{{company_profession}}" data-employer-id="{{id}}" data-action="profession">
            </label>
        </div>

    </div>
    {{/.}}
</script>