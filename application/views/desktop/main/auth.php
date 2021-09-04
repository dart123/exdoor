<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.06.16
 * Time: 14:52
 */
?>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>


        <style>
            body {
                padding-top: 70px;
                padding-bottom: 100px;
            }
            h1 {
                margin-bottom: 40px;
            }
        </style>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-sm-offset-4 well text-center">
                    <?php if ($error):?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error;?>
                        </div>
                    <?php endif;?>
                    <h4>Для авторизации введите пароль</h4>
                    <form action="/auth" method="POST">
                        <input type="hidden" name="action" value="auth-reg">
                        <input type="hidden" name="phone" value="<?php echo $phone;?>">
                        <input class="form-control" name="password" type="password">
                        <br>
                        <button type="submit" class="btn btn-block btn-success">Авторизация</button>
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>