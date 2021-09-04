<?php
/**
 * Created by developer with PhpStorm.
 * Date: 10.09.2018 10:36
 *
 *
 */
?>
<body>
<?php $this->load->view('mobile/misc/preloader');?>
<aside class="sidebar">
    <?php
    $this->load->view('mobile/user/page__header', $page_content['menu']);
    $this->load->view('mobile/user/menu_user', $page_content['menu']);
    ?>

</aside>
<div class="sidebar-cover"></div>


<header class="header">
    <div class="container">
        <!-- блоки, видимые на мобильном -->
        <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>
        <div class="header__page-title t-hide">Сообщения</div>
        <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>

    </div>
</header>


<div class="content">
    <div class="conversation">

        <table cellspacing="0" cellpadding="0" class="conversation__table ">
            <tbody class="ajax-messages-list">
            <?php

            $last_loaded_message = 0;

            if( $page_content["messages"] ):

                foreach ($page_content["messages"] as $message):

                    $this->load->view('mobile/messages/loop__message', $message);

                    if ( $last_loaded_message == 0 || ($last_loaded_message >= $message->id) ) {
                        $last_loaded_message     = $message->id;
                    }
                    $last_message_id        = $message->id;

                endforeach;

            endif;
            ?>
            </tbody>
        </table>
        <?php /*
        <div id="conversation__res" class="" >

            <form action="" class="ajax-send-message">
                <input type="hidden" id="ajax-input-author" name="author_id" value="<?php echo $page_content["user"]->id;?>">
                <input type="hidden" id="ajax-input-chatroom" name="chatroom_id" value="<?php echo $page_content["chatroom"];?>">
                <input type="hidden" id="ajax-last_loaded_message" name="last_loaded_message" value="<?php echo $last_loaded_message;?>">
                <input type="hidden" id="ajax-input-last_message_id" name="last_message" value="<?php if(isset($last_message_id)) echo $last_message_id;?>">

                <table  cellspacing="0" cellpadding="0" class="conversation__reply-box reply-tbox is-box-shadow">
                    <tbody>
                    <tr class="">
                        <td colspan="2">

                        </td>
                        <td colspan="3">
                            <small>
                                <i id="js__opponent_typing" class="messages__opponent_typing">
                                    <?php if ($page_content["opponent"]->name):?>
                                        <?php echo $page_content["opponent"]->name;?> печатает...
                                    <?php else:?>
                                        Вам печатают...
                                    <?php endif;?>
                                </i>&nbsp;
                            </small>
                        </td>
                    </tr>
                    <tr class="reply-tbox__row">
                        <td class="reply-tbox__cell" width="40px"></td>
                        <td class="reply-tbox__cell reply-tbox__author--wrap"  width="70px">
                        <span class="reply-tbox__author is-rounded">
                            <?php if( $page_content["user"]->avatar ):?>
                                <img src="/uploads/users/<?php echo $page_content["user"]->id;?>/avatar/80x80_<?php echo $page_content["user"]->avatar;?>" alt="" style="width: 60px; height: 60px">
                            <?php else:?>
                                <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" alt="" style="width: 60px; height: 60px">
                            <?php endif;?>
                        </span>

                        </td>
                        <td class="reply-tbox__cell reply-tbox__form-box ">
                            <div class="resizer-bar">
                                <div class="resizer_line"></div>
                                <div class="resizer_line"></div>
                                <div class="resizer_line"></div>
                            </div>

                            <textarea id="ajax-input-message" name="message" class="reply-tbox__area is-rounded" placeholder="Введите Ваше сообщение"></textarea>

                            <!-- загрузка фото с превью -->
                            <ul id="filelist_msg" class="clear"></ul>
                            <div class="attachment-count-list js-attachment-count-list">Добавлено файлов: <span>0</span></div>
                            <div class="reply-tbox__file">
                                <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem_msg" multiple=""  style="display:none" onchange="handleFiles_msg(this.files);">
                                <a href="#" id="fileSelect_msg" class="is-blue-link add-requests__label" onClick="uploadImg_msg(event);">
                                    <i class="fa fa-paperclip i-left-20"></i>
                                    <span>Прикрепить фото</span>
                                </a>
                            </div>
                            <!--  -->
                            <span class="reply-tbox__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <input type="submit" id="dialog__send_message__submit" class="reply-tbox__submit is-rounded" value="Отправить">
                        </span>

                        </td>
                        <td class="reply-tbox__cell"  width="100px"></td>
                        <td class="reply-tbox__cell"  width="40px"></td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <div class="hide-artifact"></div>
        </div>
        */ ?>

        <form action="" class="ajax-send-message">
            <input type="hidden" id="ajax-input-author" name="author_id" value="<?php echo $page_content["user"]->id;?>">
            <input type="hidden" id="ajax-input-chatroom" name="chatroom_id" value="<?php echo $page_content["chatroom"];?>">
            <input type="hidden" id="ajax-last_loaded_message" name="last_loaded_message" value="<?php echo $last_loaded_message;?>">
            <input type="hidden" id="ajax-input-last_message_id" name="last_message" value="<?php if(isset($last_message_id)) echo $last_message_id;?>">



            <div class="m-news-add-comment">
                <div class="content">
                    <!--  Добавить комментарий  -->
                    <div class="news-advpost__form is-last-item">

                        <a href="/partners/<?php echo $page_content["user"]->id;?>" class="m-news-add-comment__avatar      reply__form-image is-rounded">
                            <?php if( $page_content["user"]->avatar ):?>
                                <img class="author_avatar img-responsive" src="/uploads/users/<?php echo $page_content["user"]->id;?>/avatar/80x80_<?php echo $page_content["user"]->avatar;?>" alt="">
                            <?php else:?>
                                <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive author_avatar">
                            <?php endif;?>
                        </a>

                        <span class="m-news-add-comment__submit-container      ajax-news-leave-comment       reply__submit--wrap is-over-submit btn ripple-effect btn-primary2 is-rounded">
                            <button type="submit" class="m-news-add-comment__submit       reply-tbox__submit       reply__submit is-rounded" value="Отправить"  data-author-id="<?php echo $page_content["user"]->id;?>">
                                <i class="fa fa-send"></i>
                            </button>
                        </span>

                        <div class="reply__form-box">
                            <textarea id="ajax-input-message" name="message" class="m-news-add-comment__textarea     js__news__add_comment reply__area is-rounded" placeholder="Текст сообщения" data-author-id="<?php echo $page_content["user"]->id;?>"></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>




    </div>
</div>




<ul class="filelist__clone"></ul>
<div id="edit-message" class="modal">
    <?php $this->load->view('mobile/messages/modal__edit');?>
</div>

<?php
    $this->load->view('mobile/messages/mustache_template__loop_message_new');
    $this->load->view('mobile/messages/mustache_template__loop_message_new__own');

    $this->load->view('mobile/misc/js/partners__open_chat');
    $this->load->view('mobile/messages/js/files_uploader');
    $this->load->view('mobile/messages/js/message_add');
    $this->load->view('mobile/messages/js/message_edit');
    $this->load->view('mobile/messages/js/message_loader');
    $this->load->view('mobile/messages/js/message_remove');
    $this->load->view('mobile/messages/js/message_typing');