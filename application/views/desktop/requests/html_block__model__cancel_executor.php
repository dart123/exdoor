<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.07.17
 * Time: 17:50
 */

?>


<!--  Подверждение  -->
<div id="req__cancel__executor" class="modal__block is-rounded">
    <div class="modal__head modal__head--blue is-first-item">
        <div class="modal__title">Отклонить заявку</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>

    <div class="modal__content">
        <h2>Отклонить заявку?</h2>
        <p>
            Вы действительно хотите отклонить данную заявку? Это действие пошлет запрос автору заявки на отклонение. После подтвержения отмены статус заявки изменится на "Отменена".
        </p>
        <div class="confirm__block">
            <a class="js__request__partner_denied pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded" data-request-id="">
                <i class="fas fa-check"></i>
                <span>Да, отклонить</span>
            </a>

            <a class="modal__close-btn pointer confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                <i class="fas fa-times"></i>
                <span>Нет, отмена</span>
            </a>
        </div>
    </div>
</div>
<!-- end Подверждение -->
