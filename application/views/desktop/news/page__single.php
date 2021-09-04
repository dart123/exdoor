<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.08.17
 * Time: 21:42
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
            if( isset($news) && !empty($news)):
                $this->load->view('desktop/news/loop__single', $news);
            else:
                $last_loaded_news = false;
                ?>

                Указанная новость удалена, либо еще не создана

                <?php
            endif;
            ?>
        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>

        <div id="add-news" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__add');?>
        </div>
        <div id="edit-news-comment" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__edit_comment');?>
        </div>

    </div>
</main>

<?php
    $this->load->view('desktop/news/mustache_template__loop');
    $this->load->view('desktop/news/mustache_template__loop_comments');
    $this->load->view('desktop/news/mustache_template__loop_modal');
    $this->load->view('desktop/news/mustache_template__loop__news_only');
