<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.08.17
 * Time: 20:27
 */
?>


<script type="text/html" id="mustache__company__new_employer__modal">


    <div class="new-coworker is-mtop-20 is-rounded material-block-show js__candidat_employer__{{id}}__company_page">
        <a href="/partners/{{id}}" class="new-coworker__link clear">
            <div class="new-coworker__photo is-rounded">
                {{#avatar}}
                    <img src="/uploads/users/{{id}}/avatar/80x80_{{avatar}}" alt="">
                {{/avatar}}
            </div>
            <div class="new-coworker__name--cover">
                <div class="new-coworker__name is-fade">
                    {{name}} {{last_name}}
                </div>
            </div>
        </a>
        <div class="new-coworker__descr is-grey-text">
            сообщил(а), что является сотрудником компании
        </div>
        <div class="new-coworker__role">
            <select class="js-allow-add-employer is-placeholder" name="user-{{id}}-role" id="role_candidat-{{id}}" data-candidat-id="{{id}}">
                <option value="" disabled selected>Роль сотрудника</option>
                <?php foreach( $roles as $role ):?>
                    <option value="<?php echo $role->id;?>">
                        <?php echo $role->value;?>
                    </option>
                <?php endforeach;?>
            </select>
            <input class="js-allow-add-employer" type="text" value="" placeholder="Должность" id="profession_candidat-{{id}}" data-candidat-id="{{id}}">
        </div>
        <div>
            <a class="is-or-link new-coworker__accept ajax-candidat-employer" data-candidat-id="{{id}}">
                <i class="fas fa-check i-left-15"></i>
                <span>Принять</span>
            </a>
            <a class="is-lgrey-link new-coworker__cancel ajax-candidat-noemployer" data-candidat-id="{{id}}">
                <i class="fas fa-times i-left-15"></i>
                <span>Отказать</span>
            </a>
        </div>
    </div>


</script>
