<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-21
 * Time: 19:02
 */
?>

<!-- Авторизация -->
<div id="modal__auth" class="modal__block is-rounded">
    <div class="modal__head modal__head--blue is-first-item">
        <div class="modal__title js-modal-auth-title"></div>
        <a href="" class="modal__close-btn"><?php echo $this->lang->line('cancel');?> <i class="fas fa-times"></i></a>
    </div>
    <form class="js-header-auth">
        <div class="modal__content send-code__block">
            <div class="js-modal-auth-description">
                <h2>&nbsp;</h2>
                <p>&nbsp;</p>
            </div>
            <div class="js-ajax__resend-code">
                <label for="" class="send-code__line-label js-ajax__auth-password-form">
                    <span class="send-code__placeholder" style="display: none"><?php echo $this->lang->line('password');?></span>
                    <input type="hidden" name="phone" value="" class="js-ajax__phone">
                    <input type="text" class="send-code__input" id="js-ajax__auth-password" name="password" placeholder="<?php echo $this->lang->line('password');?> *" required>
                </label>
                <input type="submit" class="send-code__submit or-btn btn btn-info is-rounded        js-ajax__auth" value="<?php echo $this->lang->line('login');?>">
                <p class="js-ajax-change_password" style="display: none">
                    <?php echo $this->lang->line('reset_password_text');?> <span class="send-code__counter js-auth-code-timer">90</span> <?php echo $this->lang->line('seconds');?>
                </p>
                <p class="js-ajax-change_password_link">
                    <a href="#" class="send-code__more is-blue-link">
                        <span><?php echo $this->lang->line('reset_password');?></span>
                    </a>
                </p>
            </div>
        </div>
    </form>
</div>
<!--  -->


<!-- Регистрация -->
<div id="modal__reg" class="modal__block is-rounded">
    <form class="body_reg_form" method="post" action="/auth">
        <div class="modal__head modal__head--blue is-first-item">
            <div class="modal__title js-modal-reg-title"></div>
            <a href="" class="modal__close-btn"><?php echo $this->lang->line('cancel');?> <i class="fas fa-times"></i></a>
        </div>
        <div class="modal__content send-code__block">
            <div class="js-modal-reg-description">
                <h2>&nbsp;</h2>
                <p>&nbsp;</p>
            </div>
            <div class="js-ajax__register-confirm-code">
                <label for="" class="send-code__line-label">
                    <span class="send-code__placeholder" style="display: none"><?php echo $this->lang->line('password');?></span>
                    <input type="hidden" name="phone" value="" class="js-ajax__phone">
                    <input type="text" class="send-code__input js-ajax__reg-password" id="" name="password" placeholder="<?php echo $this->lang->line('password');?> *" required>
                </label>
                <input type="submit" class="send-code__submit or-btn btn btn-info is-rounded        js-ajax__reg" value="Ок">
                <p class="js-ajax-repeat-sms" style="display: none">
                    <?php echo $this->lang->line('repeat_sms_text');?> <span class="send-code__counter js-reg-code-timer">40</span> <?php echo $this->lang->line('seconds');?>
                </p>
                <p class="js-ajax-repeat-sms_link">
                    <a href="" class="send-code__more is-blue-link">
                        <span><?php echo $this->lang->line('repeat_sms');?></span>
                    </a>
                </p>
            </div>
        </div>
    </form>
</div>
<!--  -->
