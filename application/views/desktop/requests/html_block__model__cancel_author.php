<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.07.17
 * Time: 17:51
 */
?>

<!--  Подверждение  -->
<div id="req__cancel__author" class="modal__block is-rounded">
    <div class="modal__head modal__head--blue is-first-item">
        <div class="modal__title">Отменить заявку</div>
        <a href="" class="modal__close-btn">Отменить <i class="fas fa-times"></i></a>
    </div>

    <div class="modal__content">
        <h2>Отменить заявку?</h2>
        <p>Вы действительно хотите отменить данную заявку на этом этапе? Подтверждая свой выбор, Вы отправите заявку в архив.</p>
        <div class="confirm__block">
            <a class="js__request__author_denied pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded" data-request-id="">
                <i class="fas fa-check"></i>
                <span>Да, отменить</span>
            </a>

            <a class="modal__close-btn pointer confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                <i class="fas fa-times"></i>
                <span>Нет, оставить</span>
            </a>
        </div>
    </div>
</div>
<!-- end Подверждение -->

