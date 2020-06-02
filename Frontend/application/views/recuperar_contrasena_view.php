<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
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
            <h4 class="tittle">Recuperar Contraseña</h4>

            <?php if (isset($error)) : ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>


            <div class="d-flex flex-column justify-content-between h-100">
                <form method="post" action="<?= site_url('Login/recuperarContrasena'); ?>">
                    <?php if (!isset($this->session->recuperar)) : ?>
                        <input type="text" id="email" class="fadeIn second" name="email" placeholder="Correo" required>
                    <?php elseif ($this->session->recuperar == 1) : ?>
                        <p>Introduce el código que te hemos enviado al correo.</p>
                        <input type="text" id="codigo" class="fadeIn second" name="codigo" placeholder="Código" required>
                    <?php elseif ($this->session->recuperar == 2) : ?>
                        <p>Introduce la nueva contraseña.</p>
                        <input type="password" id="password" class="fadeIn second" name="password" placeholder="Contrasseña" required>
                        <input type="password" id="confirmar_password" class="fadeIn second" name="confirmar_password" placeholder="Confirmar contrasseña" required>
                    <?php endif; ?>
                    <input type="submit" class="fadeIn fourth" value="Recuperar">
                </form>

                <div id="formFooter">
                    <p>¿Ya tienes cuenta?<a class="underlineHover" href="<?= site_url('Login') ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>