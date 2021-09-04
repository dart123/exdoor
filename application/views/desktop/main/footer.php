<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.16
 * Time: 0:45
 */
?>

    <a href="#" class="notify-trigger notify-trigger--success" data-notifyStyle="success" data-notifyDuration="3000" data-notifyTitle="Спасибо!" data-notifyText="Данные отправлены, действие выполнено" style="height: 0; width: 0; font-size: 0"></a>

    <a href="#" class="notify-trigger notify-trigger--alert" data-notifyStyle="alert" data-notifyDuration="5000" data-notifyTitle="Ошибка!" data-notifyText="Данное действие не подтверждено и не выполнено" style="height: 0; width: 0; font-size: 0"></a>




    <?php
        $this->load->view('desktop/misc/modal__bug_report');
        $this->load->view('desktop/misc/modal__auth_reg');
        $this->load->view('desktop/misc/js/bug_report');
    ?>

    <?php if ($is_home_page):?>
        <!-- Подвал -->
        <footer class="main-page-footer">
            <div class="container">
                <div class="footer__copyright">Exdor.ru © 2015 - 2019</div>
                <div class="footer__project-about">
                    <?php if ($footer_menu):?>
                        <?php foreach ( $footer_menu as $link ):?>
                            <a href="<?php echo $link["slug"]?>" class="is-fade"><?php echo $link["title"]?></a>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <?php echo $language_switcher;?>
            </div>
        </footer>
        </div>

        <!-- Overlay под видео -->
        <div class="md-overlay"></div>

    <?php else:?>
        <!-- Подвал -->
        <footer class="info-page-footer">
            <div class="container">
                <div class="footer__copyright">Exdor.ru © 2015 - 2017</div>
                <div class="footer__project-about">
                    <?php if ($footer_menu):?>
                        <?php foreach ( $footer_menu as $link ):?>
                            <a href="<?php echo $link["slug"]?>" class="is-fade"><?php echo $link["title"]?></a>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <?php echo $language_switcher;?>
            </div>
        </footer>
    <?php endif;?>

    <!-- Overlay под видео -->
    <div class="md-overlay"></div>

</body>
</html>