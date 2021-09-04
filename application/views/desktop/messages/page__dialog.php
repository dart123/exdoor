<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 13.08.16
 * Time: 17:55
 */
?>

<div class="preloader">
    <img src="/assets/img/preload.gif" alt="" class="preloader__img">
</div>


<main>
<div class="container">
<!-- Левый сайдбар -->
<div class="main-features">
    <?php $this->load->view('desktop/user/menu_user', $menu);?>
</div>
<!-- Правый сайдбар -->
<section class="additional-features">
    <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
</section>
<!-- Контент -->
<section class="page-content">
<!--  Блок одного диалога  -->
<div class="conversation">

    <table cellspacing="0" cellpadding="0" class="conversation__table ">
        <tbody class="ajax-messages-list">
        <?php

            $last_loaded_message = 0;

            if($messages):

                foreach ($messages as $message):

                    $this->load->view('desktop/messages/loop__message', $message);

                    if ( $last_loaded_message == 0 || ($last_loaded_message >= $message->id) ) {
                        $last_loaded_message     = $message->id;
                    }
                    $last_message_id        = $message->id;

                endforeach;

            endif;
        ?>
        </tbody>
    </table>
    <div id="conversation__res" class="" >

        <form action="" class="ajax-send-message">
            <input type="hidden" id="ajax-input-author" name="author_id" value="<?php echo $user->id;?>">
            <input type="hidden" id="ajax-input-chatroom" name="chatroom_id" value="<?php echo $chatroom;?>">
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
                                <?php if ($opponent->name):?>
                                    <?php echo $opponent->name;?> печатает...
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
                            <?php if( $user->avatar ):?>
                                <img src="/uploads/users/<?php echo $user->id;?>/avatar/80x80_<?php echo $user->avatar;?>" alt="" style="width: 60px; height: 60px">
                            <?php else:?>
                                <img src="/assets/img/news-advpost-head__photo--empty.jpg" alt="" style="width: 60px; height: 60px">
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
<!-- Кнопка Подгружаю еще -->
</section>
<!-- Кнопка Наверх -->

<!-- Написать сообщение -->
<!-- end Написать сообщение -->
</div>

</main>


<ul class="filelist__clone"></ul>
<div id="edit-message" class="modal is-rounded">
    <?php $this->load->view('desktop/messages/modal__edit');?>
</div>

<?php
    $this->load->view('desktop/messages/mustache_template__loop_message_new');
    $this->load->view('desktop/messages/mustache_template__loop_message_new__own');


    $this->load->view('desktop/misc/js/partners__open_chat');
    $this->load->view('desktop/messages/js/files_uploader');
    $this->load->view('desktop/messages/js/message_add');
    $this->load->view('desktop/messages/js/message_edit');
    $this->load->view('desktop/messages/js/message_loader');
    $this->load->view('desktop/messages/js/message_remove');
    $this->load->view('desktop/messages/js/message_typing');