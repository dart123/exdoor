<?php
/**
 * Created by developer with PhpStorm.
 * Date: 25.08.2018 19:56
 */
?>

<div class="some-container" style="z-index: 19000;position: relative;">
    <pixie-editor></pixie-editor>
</div>

<link rel="stylesheet" href="/assets/js/pixie2/pixie/styles.min.css">
<script src="/assets/js/pixie2/pixie/scripts.min.js"></script>


<script>
    var pixie = new Pixie({
        ui: {
            nav: {
                position: 'bottom',
                replaceDefault: true,
                items: [
                    {name: 'text', icon: 'text-box-custom', defaultText: 'Нажмите для изменения', action: 'text'},
                    {type: 'separator'},
                    {name: 'draw', icon: 'pencil-custom', action: 'draw'},
                    {type: 'separator'},
                    {name: 'crop', icon: 'crop-custom', action: 'crop'},
                    {name: 'transform', icon: 'transform-custom', action: 'rotate'},
                    {type: 'separator'},
                    {name: 'Отменить', icon: 'undo', action: function () {
                            if( pixie.getTool('history').canUndo() )
                                pixie.getTool('history').undo();
                        }},
                    {name: 'Вернуть', icon: 'redo', action: function () {
                            if( pixie.getTool('history').canRedo() )
                                pixie.getTool('history').redo();
                        }},
                    {type: 'separator'},

                    {name: 'Сохранить', icon: 'file-download', action: function () {
                            pixie.getTool('export').export();
                        }},
                    {name: 'Закрыть', icon: 'close', action: function () {
                            pixie.close();
                        }},
                ],
            },

            compact: false,
            openImageDialog: false,
            mode: 'overlay',
            toolbar: {
                hideOpenButton: true,
                hideCloseButton: true,
            },
            colorPresets: {
                replaceDefault: true,
                items: [
                    '#000',
                    '#fff',
                    '#ff0000',
                    '#336699',
                    '#669933',
                ],
            }
        },

        languages: {
            active: 'ru',
            custom: {
                ru: {
                    save: 'Сохранить',
                    zoom: 'Масштаб',
                    history: 'История',
                    close: 'Назад',
                    cancel: 'Отмена',
                    apply: 'Готово',
                    filter: 'Фильтр',
                    resize: 'Размер',
                    crop: 'Кадр',
                    transform: 'Поворот',
                    draw: 'Кисть',
                    "Brush Color": "Цвет кисти",
                    "Brush Type": "Тип кисти",
                    "Brush Size": "Размер кисти",
                    text: 'Текст',
                    "Align Text": "Выравнивание",
                    "Format Text": "Форматирование",
                    "Color Picker": "Цвет",
                    "Add Text": "Добавить",
                    "Double click here": "Нажмите сюда!",
                    "Font": "Шрифт",
                    search: 'Поиск',
                    'Objects': 'Объекты',
                    'Main image': 'Изображение',
                    'Initial': 'Начало',

                    drawing: "Кисть",
                    shadow: "Тень",
                    blur: "Размытие",
                    'Offset X': "Х",
                    'Offset Y': "Y",
                    color: "Цвет",
                    outline: "Обводка",
                    "Outline Width": "Ширина обводки",
                    "Background Color": "Цвет фона",
                    "Texture": "Текстура",
                    "Upload": "Загрузить",
                    "Gradient": "Градиент",
                    "Opacity": "Прозрачность",
                    "Text Style": "Текст",
                    "Applied": "Применено",


                    background: 'Фон',
                    corners: 'Углы',
                    editor: 'Редактор'
                },
            }
        },
        urls: {
            base: '<?= $this->config->item('base_url');?>/assets/js/pixie2/pixie/', //optional
            assets: '<?= $this->config->item('base_url');?>/assets/js/pixie2/pixie/', //optional
        },
        onLoad: function() {
            console.log('Pixie is ready');
        },
        onSave: function(data, img) {

            var original_name   = $('.js__image_in_editing').attr('data-image-original-name'),
                equipment_id    = $('#eq__id').val();

            $.ajax({
                url:   '/ajax/save_edit_image',
                data: {
                    'image'         : data,
                    'name'          : original_name,
                    'equipment_id'  : equipment_id
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                },
                success: function(result){
                    if (result) {

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Изображение отредактровано')
                            .attr('data-notifyText',  'Миниатюры обновятся при перезагрузке страницы!')
                            .click();

                        var old_img         = $('.js__image_in_editing').closest('li').find('img'),
                            old_edit        = $('.js__image_in_editing').closest('li').find('.edit'),
                            old_src_orig    = old_edit.attr('data-image-original-url'),
                            old_img_name    = old_edit.attr('data-image-original-name'),
                            thumbnail       = $('img[data-thumbnail="'+old_img_name+'"]'),
                            old_src_small   = old_img.attr('src'),
                            new_src_small   = old_src_small + '?v=' + Math.floor(Date.now() / 1000),
                            new_src_orig    = old_src_orig + '?v=' + Math.floor(Date.now() / 1000);
                        // обновляем get у обложки, если есть конечно
                        if( thumbnail.length ) {
                            thumbnail.attr( 'src' , thumbnail.attr('data-thumbnail-url') + '?v=' + Math.floor(Date.now() / 1000) )
                        }

                        old_img.attr('src', new_src_small );
                        old_edit.attr('data-image-original-url', new_src_orig);

                        $('.js__image_in_editing').removeClass('js__image_in_editing');

                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    pixie.resetEditor();
                    pixie.close();
                }
            });

        },
        onClose: function () {
            pixie.resetEditor();
            $('.js__image_in_editing').removeClass('js__image_in_editing');
        },
        tools: {
            text: {
                replaceDefault: false,
            },
            crop: {
                replaceDefault: true,
                hideCustomControls: true,
                items: ['3:2', '5:3', '4:3', '5:4', "6:4", '7:5', '10:8', '16:9']
            },
            draw: {
                replaceDefault: false,
            },
            import: {
                validExtensions: ['png', 'jpg', 'jpeg', 'gif'],
            },
            export: {
                defaultFormat: 'png',
                defaultQuality: 0.8,
                defaultName: 'image',
            }
        }

    });

    $(document).ready( function () {

        $('body').on('click', '.js__image_edit__open_editor', function(e) {
            $(this).addClass('js__image_in_editing');

            pixie.openEditorWithImage(   $(this).attr('data-image-original-url') + '?v=' + Math.floor(Date.now() / 1000)  );

        });

    })
</script>