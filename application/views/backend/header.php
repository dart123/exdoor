<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10.05.16
 * Time: 16:23
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">





        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>



        <script src="/assets/js/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/masonry.pkgd.min.js"></script>
        <script src="/assets/js/jquery-ui.min.js"></script>
        <script src="/assets/js/jquery.scrollbar.min.js"></script>
        <script src="/assets/js/roundslider.min.js"></script>
        <script src="/assets/js/jquery.fancybox.pack.js?v=2.1.5"></script>
        <script src="/assets/js/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <script src="/assets/js/jquery.fancybox-media.js?v=1.0.6"></script>
        <script src="/assets/js/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        <script src="/assets/js/html5Forms.js"></script>

        <script src="/assets/js/mustache/mustache.min.js"></script>

        <!--
    <script src="/assets/js/js-webshim/minified/polyfiller.js"></script>
    <script>
        webshim.activeLang('en<?php /*echo $this->router->user_lang; */?>');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>
    -->
        <script src="/assets/js/sly.min.js"></script>
        <script src="/assets/js/horizontal.js"></script>

        <!--
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        -->
        <link rel="stylesheet" href="/assets/js/datetimepicker/css/bootstrap-datetimepicker.min.css">
        <script src="/assets/js/datetimepicker/moment.js"></script>
        <script src="/assets/js/datetimepicker/ru.js"></script>
        <script src="/assets/js/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

        <?php /*
        <script src="/assets/js/ckeditor/ckeditor.js"></script>
        <script src="/assets/js/ckeditor/config.js"></script>
        */;?>


        <script src="/assets/js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector:'.js-tinymce',
                language: 'ru',
                content_css: '/assets/css/custom__tinymce.css',
                height : "480",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                menubar: false,
                force_br_newlines : true,
                force_p_newlines : false,
                image_advtab: true,
                file_browser_callback: RoxyFileBrowser,


            });

            function RoxyFileBrowser(field_name, url, type, win) {
                var roxyFileman = '/assets/js/fileman/index.html';
                if (roxyFileman.indexOf("?") < 0) {
                    roxyFileman += "?type=" + type;
                }
                else {
                    roxyFileman += "&type=" + type;
                }
                roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
                if(tinyMCE.activeEditor.settings.language){
                    roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
                }
                tinyMCE.activeEditor.windowManager.open({
                    file: roxyFileman,
                    title: 'Менеджер файлов',
                    width: 850,
                    height: 650,
                    resizable: "yes",
                    plugins: "media",
                    inline: "yes",
                    close_previous: "no"
                }, {     window: win,     input: field_name    });
                return false;
            }
        </script>


        <style>
            body {
                padding-top: 70px;
                padding-bottom: 100px;
            }
            h1 {
                margin-bottom: 40px;
            }
        </style>
        <style>
            #tinymce img {
                margin: 10px;
            }
        </style>

    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Навигация</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                        <img style="width: 70px" src="/assets/img/header__company--logo_backend.png" alt="Перейти на сайт" title="Перейти на сайт">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="/backend/page/">Страницы</a></li>
                        <li><a href="/backend/users/">Пользователи</a></li>
                        <li><a href="/backend/news/">Новости</a></li>
                        <li><a href="/backend/offers/">Объявления</a></li>
                        <li><a href="/backend/companies/">Компании</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Настройки <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/backend/lists/">Справочники</a></li>
                                <li><a href="/backend/home_page/">Главная страница</a></li>
                                <li><a href="/backend/system_settings">Системные настройки</a></li>
                            </ul>
                        </li>
                    </ul>


                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/backend/logout/"><span class="glyphicon glyphicon-log-out"></span> Выход</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">