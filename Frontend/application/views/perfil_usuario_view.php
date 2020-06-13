<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/usuario.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/comun.css'); ?>">
    
</head>

<body>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="container-fluid container-perfil">

        <?php if (isset($this->session->error)) : ?>
            <p class="error"><?= $this->session->error ?></p>
        <?php endif; ?>
        
        <?php if ($riesgo > 70 ) : ?>
            <p class="text-center" style="color: tomato;">Riesgo: <?=$riesgo?> %</p>
        <?php elseif ($riesgo > 50 ) : ?>
            <p class="text-center" style="color: #FFCC00;">Riesgo: <?=$riesgo?> %</p>
        <?php else : ?>
            <p class="text-center" style="color: rgb(18, 133, 18);">Riesgo: <?=$riesgo?> %</p>
        <?php endif; ?>

        <p>Responde los siguientes habitos:</p>
        <form method="post" action="<?= site_url('Usuario/guardarPerfil'); ?>">
            <?php if (isset($habitos)) : ?>
                <?php foreach ($habitos as $h) : ?>
                    <p><?= $h->nombre ?></p>
                    <input type="hidden" name="habitos[]" value="<?= $h->id ?>">
                    <div class="d-flex justify-content-around">
                        <?php foreach ($h->respuestas as $r) : ?>
                            <div>
                                <label for="<?= $r->id ?>"><?= $r->respuesta ?></label>
                                <input name="<?= $h->id . '[]' ?>" type="radio" id="<?= $r->id ?>" value="<?= $r->id ?>" <?= $r->chequeada ? 'checked' : '' ?>>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            <br>
        </form>
    </div>


</body>

</html>