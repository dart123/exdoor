<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.09.17
 * Time: 17:04
 */
?>


    <main>
        <div class="js-user-info"
            <?php if($user->avatar):?>
                data-avatar="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>"
            <?php else:?>
                data-avatar="/assets/img/news-advpost-head__photo--empty.jpg"
            <?php endif;?>

            <?php if ($user->name || $user->last_name):?>
             data-name="<?php echo $user->name;?> <?php echo $user->last_name;?>">
            <?php else:?>
                data-name="<?php echo $user->phone;?>">
            <?php endif;?>
        </div>
        <div class="container">
            <div class="main-features">
                <?php $this->load->view('desktop/user/menu_user', $menu);?>
            </div>
            <section class="additional-features">
                <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
            </section>
            <section class="page-content">

                <?php
                if( isset($offer) && is_object($offer)):
                    $this->load->view('desktop/offers/loop__single', $offer);
                else:
                    ?>

                    Указаное объявление удалено, либо еще не создано

                    <?php
                endif;
                ?>
            </section>

            <!-- Кнопка Наверх -->
            <a href="#" class="back-to-top is-blue-link">
                <i class="fas fa-caret-up"></i>
                <span>Наверх</span>
            </a>

            <div id="add-advpost" class="modal is-rounded">
                <?php $this->load->view('desktop/offers/modal__add');?>
            </div>

        </div>
    </main>



<?php
$this->load->view('desktop/offers/mustache_template__loop');
$this->load->view('desktop/offers/mustache_template__loop_modal');
$this->load->view('desktop/offers/mustache_template__loop_full_width');

$this->load->view('desktop/misc/js/partners__open_chat');
$this->load->view('desktop/offers/js/functions');
$this->load->view('desktop/offers/js/get_item');
$this->load->view('desktop/offers/js/add_item', array('page' => 'offers'));
$this->load->view('desktop/offers/js/edit_item');
$this->load->view('desktop/offers/js/remove_item');