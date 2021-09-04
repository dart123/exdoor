<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30.10.2017
 * Time: 22:51
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
            <div class="my-partners__search-rslt">

                Результаты поиска

            </div>

            <!--  Пост от Exdor  -->

            <div class="ajax__news_container is-mtop-20">
                <?php
                if( isset($news) && !empty($news)):
                    foreach ($news as $news_item):
                        $last_loaded_news   = $news_item->id;
                        $this->load->view('desktop/news/loop', $news_item);
                    endforeach;
                else:
                    $last_loaded_news = false;  ?>

                    <div class="my-partners__last is-no-select">
                        Новостей нет
                    </div>


                    <?php
                endif;
                ?>
            </div>

            <div class="load-more">
                <div class="cssload-container">
                    <div class="cssload-whirlpool"></div>
                </div>
                <span>Подгружаю ещё</span>
            </div>
        </section>
        <!-- Кнопка Наверх -->
        <a href="#" class="back-to-top is-blue-link">
            <i class="fas fa-caret-up"></i>
            <span>Наверх</span>
        </a>

        <input type="hidden" id="ajax__news-user_id" value="<?= $user->id;?>">
        <input type="hidden" id="ajax__last_loaded_news" value="<?= $last_loaded_news;?>">
        <input type="hidden" id="ajax__last_loaded_news" value="<?= $last_loaded_news;?>">
        <input type="hidden" id="ajax__news-keyword" value="<?= $keyword;?>">


        <div id="add-news" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__add');?>
        </div>
        <div id="edit-news-comment" class="modal is-rounded">
            <?php $this->load->view('desktop/news/modal__edit_comment');?>
        </div>

        <div class="ajax__news_modal_container">

            <?php
            if( isset($news) && !empty($news)):
                foreach ($news as $news_item):
                    $this->load->view('desktop/news/loop__modal', $news_item);
                endforeach;
            endif;
            ?>
        </div>
    </div>
</main>


<?php
$this->load->view('desktop/news/mustache_template__loop');
$this->load->view('desktop/news/mustache_template__loop_comments');
$this->load->view('desktop/news/mustache_template__loop_modal');
$this->load->view('desktop/news/mustache_template__loop__news_only');
