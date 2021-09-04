<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.07.17
 * Time: 17:51
 */
?>

<!--  Подверждение  -->
<div id="req__cancel__author" class="modal modal--middle is-rounded">

    <div class="modal__head modal__head--blue">
        <div class="modal__title">Отменить заявку?</div>
    </div>

    <div style="background: #fff;" class="modal-body">
        <p>Вы действительно хотите отменить данную заявку на этом этапе? Подтверждая свой выбор, Вы отправите заявку в архив.</p>
        <div class="confirm__block center is-mtop-20">
            <a class="js__request__author_denied pointer     bl-btn      confirm__block-btn btn ripple-effect btn-primary2 is-rounded" data-request-id="">
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

