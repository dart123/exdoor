<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2018-12-03
 * Time: 16:16
 */

?>

<!--  Подверждение  -->
<div id="req__remove" class="modal  modal--middle">
    <div class="modal__head modal__head--blue ">
        <div class="modal__title">Начать заново?</div>
    </div>

    <div style="background: #fff;" class="modal-body">
        <p>Начать создание заявки с первого этапа? Текущие значения будут утеряны!</p>
        <div class="confirm__block center is-mtop-20">
            <a class="js__request__remove     bl-btn    pointer confirm__block-btn btn ripple-effect btn-primary2 is-rounded" <?php if(is_object($page_content["request_data"])):?>data-request-id="<?php echo $page_content["request_data"]->id;?>"<?php endif;?>>
                <i class="fa fa-check"></i>
                <span>Да</span>
            </a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a class="modal__close-btn pointer       confirm__block-btn btn ripple-effect or-btn btn-info is-rounded">
                <i class="fa fa-times"></i>
                <span>Нет</span>
            </a>
        </div>
    </div>
</div>
<!-- end Подверждение -->
