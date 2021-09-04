<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.05.16
 * Time: 15:57
 */


?>
<!-- Регистрация -->
<section class="registration">
    <div class="container">
        <div class="user-reg__wrap">

            <form action="/auth" method="POST"  class="body_reg_form user-reg__form">
                <span class="user-reg__title"><?php echo $this->lang->line('home_quick_reg');?></span>
                <div class="user-reg__inputs">
                    <div class="user-reg__city--wrap">
                        <select class="user-reg__city" id="selected-01" required name="phone-code">
                            <option value="+994">+994 (<?php echo $this->lang->line('country_AZ');?>)</option>
                            <option value="+374">+374 (<?php echo $this->lang->line('country_AR');?>)</option>
                            <option value="+375">+375 (<?php echo $this->lang->line('country_BY');?>)</option>
                            <option value="+7">+7 (<?php echo $this->lang->line('country_KZ');?>)</option>
                            <option value="+996">+996 (<?php echo $this->lang->line('country_KR');?>)</option>
                            <option value="+373">+373 (<?php echo $this->lang->line('country_ML');?>)</option>
                            <option selected value="+7">+7 (<?php echo $this->lang->line('country_RU');?>)</option>
                            <option value="+992">+992 (<?php echo $this->lang->line('country_TJ');?>)</option>
                            <option value="+993">+993 (<?php echo $this->lang->line('country_TR');?>)</option>
                            <option value="+998">+998 (<?php echo $this->lang->line('country_UZ');?>)</option>
                            <option value="+380">+380 (<?php echo $this->lang->line('country_UA');?>)</option>
                        </select>
                        <select id="reg-tmp-select">
                            <option id="reg-tmp-option"></option>
                        </select>
                    </div>
                    <input id="phone-number-middle" type="tel" name="phone-number" class="user-reg__phone-num" placeholder="<?php echo $this->lang->line('phone_number');?>" inputmode="numeric" required="true">
                        <span class="is-over-submit btn btn-info ripple-effect is-rounded">
                            <input type="submit" class="user-reg__submit or-btn btn btn-info is-rounded         js-ajax__reg" id="" value="<?php echo $this->lang->line('registration');?>">
                        </span>
                    <a href="#modal__reg" class="modal__reg fancybox" style="display: none"></a>
                </div>
            </form>
        </div>
        <div class="user-reg__benefits">
            <h2><?php echo $this->lang->line('home_reg_title');?></h2>
            <div class="benefits__item"><i class="fas fa-comments"></i><?php echo $this->lang->line('home_tizer_1');?></div>
            <div class="benefits__item"><i class="fas fa-list-alt"></i><?php echo $this->lang->line('home_tizer_2');?></div>
            <div class="benefits__item"><i class="fas fa-bullseye"></i><?php echo $this->lang->line('home_tizer_3');?></div>
            <div class="benefits__item"><i class="fas fa-sitemap"></i><?php echo $this->lang->line('home_tizer_4');?></div>
        </div>
    </div>
</section>
<!-- "Ещё больше возможностей" -->

<section class="opportunities">
    <div class="container">
        <?php if($slides):?>
        <h2><?php echo $this->lang->line('home_slider_title');?></h2>
        <div class="opportunities__slider-cover">

            <div class="frame" id="opportunities__slider-w">
                <ul>
                    <?php foreach ($slides as $slide):?>
                        <li>
                            <a href="/uploads/slides/<?php echo $slide->file_name;?>" class="fancybox-thumb" data-fancybox="fancybox-thumb">
                                <img src="<?php echo $slide->thumbnail;?>" alt="">
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <ul class="pages"></ul>
            <div class="controls center">
                <div class="prevPage"></div>
                <div class="nextPage"></div>
            </div>
        </div>
        <?php endif;?>
    </div>
</section>