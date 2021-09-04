<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 21.06.17
 * Time: 15:47
 */
?>

<main>
    <div class="container">
        <div class="main-features">
            <ul class="main-menu__list">
                <?php $this->load->view('desktop/misc/guest__html__menu', $menu);?>
            </ul>
        </div>
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <section class="page-content">

            <div class="sub-menu">
                <ul class="sub-menu__list">
                    <li>
                        <a class="sub-menu__news-item sub-menu__exdor-item active is-fade">
                            Новости проекта
                        </a>
                    </li>
                </ul>
            </div>
            <!--  Пост от Exdor  -->

            <div class="ajax__news_container">
                <?php
                if( isset($news) && !empty($news)):
                    foreach ($news as $news_item):
                        $last_loaded_news   = $news_item->id;
                        $this->load->view('desktop/news/guest__loop', $news_item);
                    endforeach;
                else:
                    $last_loaded_news = false;
                    ?>
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

        <div class="ajax__news_modal_container">
            <?php
            if( isset($news) && !empty($news)):
                foreach ($news as $news_item):
                    $this->load->view('desktop/news/guest__loop__modal', $news_item);
                endforeach;
            endif;
            ?>
        </div>
    </div>
</main>

<input type="hidden" id="ajax__last_loaded_news" value="<?php echo $last_loaded_news;?>">


<?php
$this->load->view('desktop/news/guest__mustache_template__loop');
$this->load->view('desktop/news/guest__mustache_template__loop_modal');

$this->load->view('desktop/news/guest__js__scripts');
