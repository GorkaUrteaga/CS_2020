<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/login-registro.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/comun.css'); ?>">
</head>

<body>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="<?= base_url('imgs/health_icon.png') ?>" id="icon" alt="COVID-19" />
            </div>
            <h4 class="tittle">Login</h4>

            <?php if (isset($error)) : ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            
            <div class="d-flex flex-column justify-content-between h-100">
                <!-- Login Form -->
                <form method="post" action="<?= site_url('Login/logear'); ?>">
                    <input type="text" id="email" class="fadeIn second" name="email" placeholder="Correo">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Contraseña">
                    <input type="submit" class="fadeIn fourth" value="Log In">
                </form>

                <!-- Registrate -->
                <div id="formFooter">
                    <!-- Contraseña olvidada -->
                    <a class="underlineHover" href="#">¿Has olvidado la contraseña?</a>
                    <hr>
                    <p>¿No tienes una cuenta? <a class="underlineHover" href="<?= site_url('Registro') ?>">Regístrate</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>