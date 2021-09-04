<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29.06.16
 * Time: 17:06
 */
?>

<?php if( $this->agent->is_mobile() && $this->session->has_userdata('pc_view') ):?>
    <div class="clear"></div>

    <div style="text-align: center" class=" is-mtop-30">
        <a href="#" class="js__set_mobile_version is-grey-text">
            <span>Вернуть мобильную версию</span>
        </a>
    </div>
<?php endif;?>

        <!--  Триггер-ссылки нотификации -->
        <a href="#" class="notify-trigger notify-trigger--success" data-notifyStyle="success" data-notifyDuration="3000" data-notifyTitle="Спасибо!" data-notifyText="Данные отправлены, действие выполнено" style="height: 0; width: 0; font-size: 0"></a>

        <a href="#" class="notify-trigger notify-trigger--alert" data-notifyStyle="alert" data-notifyDuration="5000" data-notifyTitle="Ошибка!" data-notifyText="Данное действие не подтверждено и не выполнено" style="height: 0; width: 0; font-size: 0"></a>




        <?php
            $this->load->view('desktop/misc/mustache_template__notification');
            $this->load->view('desktop/partners/mustache_template__loop__partner');
            $this->load->view('desktop/partners/mustache_template__loop__request_inbox');
            $this->load->view('desktop/partners/mustache_template__loop__request_outbox');

            $this->load->view('desktop/user/footer__scripts');
            $this->load->view('desktop/misc/js/socket.io.php');

        ?>


        <?php if( isset( $notifications ) && is_array( $notifications ) ):?>
        <script type="text/javascript">
            $(document).ready(function () {


                <?php foreach ( $notifications as $noty ):?>

                    <?php if ( !isset($noty_to_hide) || ( is_array($noty_to_hide) && !in_array( $noty->type, $noty_to_hide ) ) ):?>

                        var template    = $('#mustache__notification').html();
                        var output      = Mustache.render(template, <?php echo $noty->noty_json;?>);

                        noty({
                            text        : 'bottomRight',
                            type        : 'alert',
                            dismissQueue: true,
                            layout      : 'bottomRight',
                            theme       : 'relax',
                            template    : output,
                            timeout     : false,
                            closeWith   : ['button'],
                            animation: {
                                open: {opacity: 'show'},
                                close: {opacity: 'hide'},
                                easing: 'linear',
                                speed:  300 // opening & closing animation speed
                            }


                        });
                    <?php endif;?>

                <?php endforeach;?>
            });

        </script>
        <?php endif;?>
    </body>
</html>