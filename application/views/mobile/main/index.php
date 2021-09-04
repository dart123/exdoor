
<!-- <div class="preloader-bg js-preloader-bg"><img src="img/preload.svg" alt="" class="preloader-img js-preloader-img"></div> -->

<div class="index-container">

    <header class="main-page-header">
        <img src="/assets__old/img/header__exdor.png" class="exdor-logo m-hide" alt="Exdor">
        <img src="/assets__old/img/header__company--logo.png" class="exdor-logo t-hide" alt="Exdor">
        <a href="#presentation" class="exdor-presentation     fancybox-video"><?php echo $this->lang->line('service_presentation');?></a>
        <h1 class="t-hide"><?php echo $this->lang->line('title_line_1');?> <?php echo $this->lang->line('title_line_2');?></h1>
    </header>

    <section class="clear">
        <div class="index-registration">
            <div class="header__user-panel">
                <div class="main-page-title"><?php echo $this->lang->line('login');?> / <?php echo $this->lang->line('registration');?>:</div>
                <form action="" class="js-authorization    h-user-reg__form">
                    <div class="user-city__wrap">
                        <select class="js-authorization__input-code user-city" id="selected-head" required>
                            <option value="+994">+994</option>
                            <option value="+374">+374</option>
                            <option value="+375">+375</option>
                            <option value="+996">+996</option>
                            <option value="+373">+373</option>
                            <option selected value="+7">+7</option>
                            <option value="+992">+992</option>
                            <option value="+993">+993</option>
                            <option value="+998">+998</option>
                            <option value="+380">+380</option>
                        </select>
                        <select id="tmp-select">
                            <option id="tmp-option"></option>
                        </select>
                    </div>
                    <input type="tel" id="selected-head-number" class="js-authorization__input-phone   user-phone-num" placeholder="<?php echo $this->lang->line('phone_number');?>" inputmode="numeric" required>
                    <div class="js-authorization__button-modal    user-reg-submit btn btn-default is-rounded">
                        <span><?php echo $this->lang->line('login');?> / <?php echo $this->lang->line('registration');?></span>
                    </div>
                </form>
            </div>

            <div class="header__main">
                <div class="main-page-title"><?php echo $this->lang->line('title_without_reg');?>:</div>
                <ul class="header__project-about">
                    <?php
                        $numItems = count($page_footer["footer_menu"]);
                        $i = 0;
                        foreach ($page_footer["footer_menu"] as $key => $link): ?>

                            <a href="<?php echo $link["slug"];?>" class="<?php if(++$i === $numItems):?>is-last-item<?php endif;?> menu-links__item">
                                <?php echo $link["title"];?>
                            </a>

                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="index-benefits">
            <div class="user-reg__benefits">
                <div class="benefits__item"><i class="fa fa-comments-o"></i><?php echo $this->lang->line('home_tizer_1');?></div>
                <div class="benefits__item"><i class="fa fa-users"></i><?php echo $this->lang->line('home_tizer_2');?></div>
                <div class="benefits__item"><i class="fa fa-pencil-square-o"></i><?php echo $this->lang->line('home_tizer_3');?></div>
                <div class="benefits__item"><i class="fa fa-sm fa-street-view"></i><i class="fa fa-sm fa-building"></i><?php echo $this->lang->line('home_tizer_4');?></div>
            </div>
        </div>
    </section>

    <!-- Подвал -->
    <div class="main-page-footer">
        <div class="footer__copyright">Exdor.ru © 2019</div>
        <?php echo $page_footer['language_switcher'];?>
    </div>

</div>



<!-- modal video-->
<div id="presentation" style="display: none" class="modal  modal--middle" tabindex="-1" role="dialog">

    <div class="modal-content   embed-responsive embed-responsive-16by9">
        <div id="videoplayer"   class="embed-responsive-item"></div>
    </div>

</div>
<!-- END modal -->


<!-- modal confirm password -->
<div class="js-authorization__modal  confirm__modal modal fade"   tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal__block is-rounded">
                <div class="modal__head modal__head--blue is-first-item">
                    <div class="js-authorization__modal-title modal__title js-modal-auth-title"><?php echo $this->lang->line('registration');?></div>
                   <?php /* <a href="" class="modal__close-btn">Отменить <i class="fa fa-times"></i></a> */ ?>
                </div>
                <form class="js-authorization__modal-form js-header-auth">
                    <div class="modal__content send-code__block">
                        <div class="modal__content-cover    js-modal-auth-description">
                            <h2 class="js-authorization__modal-title">&nbsp;</h2>
                            <p class="js-authorization__modal-description">&nbsp;</p>
                        </div>
                        <div class="js-ajax__resend-code">
                            <label for="" class="send-code__line-label js-ajax__auth-password-form">
                                <input type="text" class="js-authorization__input-password       send-code__input" name="password" placeholder="<?php echo $this->lang->line('password');?> *" required="">
                            </label>
                            <input type="submit" class="send-code__submit or-btn btn btn-info is-rounded js-ajax__auth" value="<?php echo $this->lang->line('login');?>">
                            <p class="js-ajax-change_password_link">
                                <a href="#" class="send-code__more is-blue-link">
                                    <span><?php echo $this->lang->line('reset_password');?></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- END modal -->

<!--  Триггер-ссылки нотификации -->
<a href="#" class="notify-trigger notify-trigger--success" data-notifyStyle="success" data-notifyDuration="3000" data-notifyTitle="Спасибо!" data-notifyText="Данные отправлены, действие выполнено" style="height: 0; width: 0; font-size: 0"></a>

<a href="#" class="notify-trigger notify-trigger--alert" data-notifyStyle="alert" data-notifyDuration="5000" data-notifyTitle="Ошибка!" data-notifyText="Данное действие не подтверждено и не выполнено" style="height: 0; width: 0; font-size: 0"></a>


<?php

    $this->load->view('mobile/main/js/auth.php');

    ?>

<script>
    /* подгрузка презентации из youtube  */
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubePlayerAPIReady() {
        player = new YT.Player('videoplayer', {
            height: 'auto',
            width: '100%',
            videoId: '<?php echo $page_head["video_id"];?>',
        });
    }
/*
    function onPlayerReady(event) {
        event.target.setVolume(100);
        event.target.playVideo();
    }
*/
    function stopVideo() {
        player.stopVideo();
    }
    /* end youtube */

    /* остановка ролика youtube и смена стилей модальных окон */
    $("html, body").click(function(e) {
        if (!$(e.target).hasClass('js-open-presentation') && $('body').hasClass('video')) {
            stopVideo();

            setTimeout(function(){
                    $('body').removeClass('video');
                },
                500);
        }
    })




</script>




<script>
    $(document).ready(function(){
        /* Запускаем и скрываем видео на главной */
        $('.header__exdor--play').click(function() {
            <?php if($video_source == 'vimeo'):?>
            $('.md-content').show().html('<iframe src="https://player.vimeo.com/video/<?php echo $video_id;?>?autoplay=1&color=eb4f1e&title=0&byline=0&portrait=0" width="800" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
            <?php elseif($video_source == 'youtube'):?>
            $('.md-content').show().html('<iframe width="800" height="450" src="https://www.youtube.com/embed/<?php echo $video_id;?>?rel=0&controls=0&showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
            <?php endif;?>
            setTimeout(function() {
                $('.md-modal').addClass('md-show').fadeIn('slow');
            }, 300);
        });
    })
</script>

<?php if( isset($_GET['action']) == "author_connect"):?>
<script>
    $(document).ready( function () {
        $('.notify-trigger--alert').attr('data-notifyTitle', 'Внимание!')
            .attr('data-notifyText',  'Чтобы связаться с автором, надо авторизоваться в системе')
            .click();

        $(".js-authorization__input-phone").focus();
    })
</script>
<?php endif;?>
</body>
</html>
