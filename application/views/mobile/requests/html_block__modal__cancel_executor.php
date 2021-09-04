<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.07.17
 * Time: 17:50
 */

?>


<!--  Подверждение  -->
<div id="req__cancel__executor" class="modal modal--middle is-rounded">
    <div class="modal__head modal__head--blue">
        <div class="modal__title">Отклонить заявку?</div>
    </div>

    <div class="modal__content">
          <p>
            Вы действительно хотите отклонить данную заявку? Это действие пошлет запрос автору заявки на отклонение. После подтвержения отмены статус заявки изменится на "Отменена".
        </p>
        <div class="confirm__block center is-mtop-20">
            <a class="js__request__partner_denied pointer     bl-btn    confirm__block-btn btn ripple-effect btn-primary2 is-rounded" data-request-id="">
                <i class="fa fa-check"></i>
                <span>Да</span>
            </a>

            <a class="modal__close-btn pointer confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                <i class="fa fa-times"></i>
                <span>Нет</span>
            </a>
        </div>
    </div>
</div>
<!-- end Подверждение -->
