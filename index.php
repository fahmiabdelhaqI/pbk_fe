<?php
    session_start();
?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login</title>

        <link rel="stylesheet" href="assets/css/custom-login.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="assets/vendor/vuejs/vue.min.js"></script>
    </head>

    <body>
        <div class="login-page">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 offset-lg-3">
                    <div class="form">
                        <img src="assets/img/pefindo.png" class="logo">
                        <div id="component_title">
                            <titleapp></titleapp>
                        </div>
                        <hr class="line">
                        <form action="action/login.php" method="post" class="login-form" enctype="multipart/form-data">
                            <?php
                                if (isset($_SESSION['error_message']))
                                {
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php
                                                echo $_SESSION['error_message'];
                                                unset($_SESSION['error_message']);
                                            ?>
                                        </div>
                                    <?php
                                }
                            ?>
                            <input type="text" id="username" name="username" placeholder="Username" />
                            <input type="password" id="password" name="password" placeholder="password" />
                            <input type="submit" id="btn_login" value="Login" class="button">

                            <p class="message">Not registered? <a href="lupaPassword.php">Lupa Password?</a></p>

                        </form>
                        <div class="power-page">
                            <img src="assets/img/brand/power-by.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            Vue.component('titleapp', {
                template: '<p class="text1">Scoring Engine Application</p>'
            });
            var vm = new Vue({
                el: '#component_title'
            });
        </script>
    </body>
</html>