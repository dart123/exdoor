<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.05.17
 * Time: 13:22
 */
?>

<div id="dndArea" style="position: absolute; top:0; left: 0; width: 100%; height: 100%; background: #fff; opacity: 0.4; z-index: 9000; display: none"></div>
<div class="cover-container-root__inner js-ajax-popup js-img-upload-container">
    <div class="cover-container-root__overlay js-overlay"></div>
    <div class="popup-container">


        <!-- Окно -->
        <div id="requests__add-eq" class="modal__img is-rounded">
            <form action="/file-upload" class="js-dnd-area">
                <div class="modal__head modal__head--dark is-first-item">
                    <a href="" class="modal__close-btn"><i class="fas fa-times"></i></a>
                </div>
                <!-- -->
                <div class="req-img__load">
                    <div id="uploader">

                        <div class="queueList">
                            <div class="placeholder is-rounded">

                                <i class="fa fa-picture-o"></i>
                                <p>Перетащите сюда новые фото или нажмите</p>

                                <!-- загрузка фото -->
                                <input type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/bmp" id="fileElem" class="" multiple="" style="display:none" onchange="handleFiles(this.files);">
                                <a id="fileSelect" class="pointer loaded-img__btn btn ripple-effect btn-primary2 is-rounded" onClick="uploadImg(event);">
                                    Загрузить с компьютера
                                </a>
                                <!-- -->
                            </div>
                        </div>


                            <div class="loaded-img__block">
                                <p>Выберите те фотографии, которые нужно использовать в описании позиции</p>

                                <ul id="filelist" class="scrollbar-inner has-edit clear">

                                    <?php if( !empty($equipment->images)):?>
                                        <?php foreach ($equipment->images as $img):?>
                                            <li class="js__existing_image">
                                                <img src="/uploads/equipment/<?php echo $request_data->eq_id;?>/158x158_<?php echo $img;?>?v=<?php echo uniqid();?>" data-original-src="<?php echo $img;?>">
                                                <a class="remove js__remove_from_library" data-image-original-name="<?php echo $img;?>"></a>
                                                <a class="edit js__image_edit__open_editor" data-image-original-url="<?=$this->config->item('base_url');?>/uploads/equipment/<?php echo $request_data->eq_id;;?>/lg1000_<?php echo $img;?>" data-image-original-name="<?php echo $img;?>"></a>
                                            </li>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </ul>
                            </div>


                    </div>
                </div>
                <!-- Футер окна -->
                <div>
                    <a class="js__requests_library__user_selected pointer req-img__submit is-last-item btn-primary2 btn ripple-effect">
                        <span>Использовать выбранное</span>
                    </a>
                </div>
            </form>
            <!-- end Футер окна -->
        </div>



    </div>
</div>
<!-- end Прикрепить еще фото -->
