<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.17
 * Time: 15:11
 */
?>

<!--  Заголовок заявки -->
<div class="requests-step__line">
    <div class="requests-step__title">
        <b>Заявка #<?php echo $page_content["request_data"]->id;?>.</b> <?php echo $page_content["request_data"]->eq_brand_name;?>, <?php echo $page_content["request_data"]->eq_appointment_name;?>, <?php echo $page_content["request_data"]->eq_serial_number;?>
    </div>
</div>
