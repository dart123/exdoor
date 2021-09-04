<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.05.16
 * Time: 1:18
 */
?>

<h1>
    Настройки главной страницы
</h1>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update_options">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">

            <div class="input-group">
                <span class="input-group-addon">Meta Title</span>
                <input type="text" class="form-control" name="home_meta_title_ru" value="<?php echo $meta_title_ru;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Keywords</span>
                <input type="text" class="form-control" name="home_meta_keywords_ru" value="<?php echo $meta_keywords_ru;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Description</span>
                <input type="text" class="form-control" name="home_meta_description_ru" value="<?php echo $meta_description_ru;?>">
            </div>
            <br>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">

            <div class="input-group">
                <span class="input-group-addon">Meta Title</span>
                <input type="text" class="form-control" name="home_meta_title_en" value="<?php echo $meta_title_en;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Keywords</span>
                <input type="text" class="form-control" name="home_meta_keywords_en" value="<?php echo $meta_keywords_en;?>">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Meta Description</span>
                <input type="text" class="form-control" name="home_meta_description_en" value="<?php echo $meta_description_en;?>">
            </div>
            <br>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h2>Видео-презентация</h2>
            <div class="well">
                <label>Источник видео</label>
                <div class="radio">
                    <label>
                        <input type="radio" class="radio-video-source-ru" name="video_source_ru" id="radio-youtube-ru" value="youtube" <?php echo ($video_source_ru == 'youtube') ? 'checked' : '';?> >
                        YouTube
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" class="radio-video-source-ru" name="video_source_ru" id="radio-vimeo-ru" value="vimeo" <?php echo ($video_source_ru == 'vimeo') ? 'checked' : '';?> >
                        Vimeo
                    </label>
                </div>

                <label for="basic-url">Код видео</label>
                <div class="input-group">
                    <span class="input-group-addon" id="video_url_prefix_ru"><?php echo ($video_source_ru == 'vimeo') ? 'https://player.vimeo.com/video/' : 'https://www.youtube.com/watch?v=';?></span>
                    <input type="text" class="form-control" name="video_id_ru" id="video-url-input" aria-describedby="video_url_prefix" value="<?php echo $video_id_ru;?>">
                </div>
            </div>

            <h2>Слайды</h2>
            <div class="well">
                <div class="form-group" id="slides-ru-container">
                    <?php
                    if($slides_ru):
                        foreach($slides_ru as $slide_ru): ?>
                            <div style="position: relative">
                                <img src="<?php echo $slide_ru->thumbnail;?>" class="img-thumbnail">
                                <a class="js-remove-slide-ru" data-thumbnail="<?php echo $slide_ru->thumbnail;?>">Удалить</a>
                            </div>

                    <?php
                        endforeach;
                    endif;?>
                    <?php if ($json_slides_ru):?>
                        <input type="hidden" name="json_slides_ru" value='<?php echo $json_slides_ru;?>'>
                    <?php endif;?>
                    <br><br>
                    <label for="exampleInputFile">Добавить слайды</label>
                    <p class="help-block">Загрузка файлов в тестовом режиме. <a href="javascript:void(0)" id="add-another-slide-ru">Добавить еще полей</a></p>
                    <input type="file" name="slides_ru[]"><br>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <h2>Video</h2>
            <div class="well">
                <label>Source</label>
                <div class="radio">
                    <label>
                        <input type="radio" class="radio-video-source-en" name="video_source_en" id="radio-youtube-en" value="youtube" <?php echo ($video_source_en == 'youtube') ? 'checked' : '';?>>
                        YouTube
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" class="radio-video-source-en" name="video_source_en" id="radio-vimeo-en" value="vimeo" <?php echo ($video_source_en == 'vimeo') ? 'checked' : '';?>>
                        Vimeo
                    </label>
                </div>

                <label for="basic-url">Video ID</label>
                <div class="input-group">
                    <span class="input-group-addon" id="video_url_prefix_en"><?php echo ($video_source_en == 'vimeo') ? 'https://player.vimeo.com/video/' : 'https://www.youtube.com/watch?v=';?></span>
                    <input type="text" class="form-control" name="video_id_en" id="video-url-input" aria-describedby="video_url_prefix" value="<?php echo $video_id_en;?>">
                </div>
            </div>

            <h2>Slides</h2>
            <div class="well">
                <div class="form-group" id="slides-en-container">

                    <?php
                    if($slides_en):
                        foreach($slides_en as $slide_en):?>
                            <div style="position: relative">
                                <img src="<?php echo $slide_en->thumbnail;?>" class="img-thumbnail">
                                <a class="js-remove-slide-en" data-thumbnail="<?php echo $slide_en->thumbnail;?>">Удалить</a>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    <?php if ($json_slides_en):?>
                        <input type="hidden" name="json_slides_en" value='<?php echo $json_slides_en;?>'>
                    <?php endif;?>
                    <br><br>
                    <label for="exampleInputFile">Добавить слайды</label>
                    <p class="help-block">Загрузка файлов в тестовом режиме. <a href="javascript:void(0)" id="add-another-slide-en">Добавить еще полей</a></p>
                    <input type="file" name="slides_en[]" multiple="true"><br>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right">
        <hr>
        <button class="btn btn-success" type="submit">Сохранить изменения</button>
    </div>
</form>


<script>
    $(document).ready(function () {
        $('.radio-video-source-ru').change( function() {
            if( $(this).attr("value") == 'youtube' ){
                $('#video_url_prefix_ru').text('https://www.youtube.com/watch?v=');
            }
            else if( $(this).attr("value") == 'vimeo' ){
                $('#video_url_prefix_ru').text('https://player.vimeo.com/video/');
            } else {

            }
        });

        $('.radio-video-source-en').change( function() {
            if( $(this).attr("value") == 'youtube' ){
                $('#video_url_prefix_en').text('https://www.youtube.com/watch?v=');
            }
            else if( $(this).attr("value") == 'vimeo' ){
                $('#video_url_prefix_en').text('https://player.vimeo.com/video/');
            } else {

            }
        });

        $('#add-another-slide-ru').click( function() {
            $('#slides-ru-container').append("<input type='file' name='slides_ru[]'><br>");
        });
        $('#add-another-slide-en').click( function() {
            $('#slides-en-container').append("<input type='file' name='slides_en[]'><br>");
        });


        $('.js-remove-slide-ru').click(function () {
            var slides_ru = JSON.parse( $('input[name="json_slides_ru"]').val() );
            console.log(slides_ru);
            var thumbnail = $(this).attr('data-thumbnail');
            slides_ru.forEach(function(item, i, slides_ru) {
                if(item.thumbnail == thumbnail){
                    slides_ru.splice(i,1);
                }
            });
            $(this).closest('div').fadeOut();
            $('input[name="json_slides_ru"]').val(  JSON.stringify(slides_ru)  );

        });

        $('.js-remove-slide-en').click(function () {
            var slides_en = JSON.parse( $('input[name="json_slides_en"]').val() );
            console.log(slides_en);
            var thumbnail = $(this).attr('data-thumbnail');
            slides_en.forEach(function(item, i, slides_en) {
                if(item.thumbnail == thumbnail){
                    slides_en.splice(i,1);
                }
            });
            $(this).closest('div').fadeOut();
            $('input[name="json_slides_en"]').val(  JSON.stringify(slides_en)  );

        });

    })
</script>