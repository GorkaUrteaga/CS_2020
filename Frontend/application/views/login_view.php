<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/comun.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/login-registro.css'); ?>">
    <script type="text/javascript" src="<?= base_url('js/login.js'); ?>"></script>

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

            <p class="error">
                <?php if (isset($error)) : ?>
                    <?= $error ?>
                <?php endif; ?>
            </p>
            
            <div class="d-flex flex-column justify-content-between h-100">
                <!-- Login Form -->
                <form method="post" action="<?= site_url('Login/logear'); ?>">
                    <input type="text" id="email" class="fadeIn second" name="email" placeholder="Correo" required>
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Contraseña" required>
                    <!--<label for="show_pass">Mostrar Contraseña</label><input type="checkbox" id="show_pass">-->
                    <p id="warning">CUIDADO! Estas escribiendo en mayusculas.</p>
                    <div class="custom-control custom-checkbox d-flex justify-content-center w-50 text-center my-1">
                        <input type="checkbox" class="custom-control-input" id="showPass">
                        <label class="custom-control-label" for="showPass">Mostrar Contraseña</label>
                    </div>
                    <input type="submit" class="fadeIn fourth" value="Log In">
                </form>

                <!-- Registrate -->
                <div id="formFooter">
                    <!-- Contraseña olvidada -->
                    <a class="underlineHover" href="<?= site_url('Login/recuperarContrasena'); ?>">¿Has olvidado la contraseña?</a>
                    <hr>
                    <p>¿No tienes una cuenta? <a class="underlineHover" href="<?= site_url('Registro') ?>">Regístrate</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>