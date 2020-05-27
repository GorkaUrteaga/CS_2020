<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/login-registro.css');?>">
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
            <img src="<?=base_url('imgs/health_icon.png')?>" id="icon" alt="COVID-19"/>
            </div>

            <!-- Login Form -->
            <form method="post" action="<?= site_url('Registro/registro');?>">
                <input type="text" id="email" class="fadeIn second" name="email" placeholder="correo">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="contraseña">
                <input type="password" id="confirmacion_password" class="fadeIn third" name="confirmacion_password" placeholder="confirmación contraseña">
                <input type="submit" class="fadeIn fourth" value="Registrate">
            </form>

            <!-- Logeate -->
            <div id="formFooter">
                <p>¿Tienes una cuenta? <a class="underlineHover" href="<?= site_url('Login') ?>">Inicia sesión</a></p>
            </div>

        </div>
    </div>

</body>

</html>