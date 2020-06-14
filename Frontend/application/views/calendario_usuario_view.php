<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/usuario.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c2dea4f87e.js" crossorigin="anonymous"></script>
</head>

<body>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <div class="container-calendario">
        <form method="post" class="w-100" action="<?= site_url('Usuario/guardarCalendario'); ?>">
            <table id="table_calendario" class="table table-hover">
                <thead class="header-fixed">
                    <tr>
                        <th scope="col">Fecha</th>
                        <?php foreach ($sintomas as $sintoma) : ?>
                            <th scope="col"><span><?= $sintoma->nombre ?></span></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($fechas); $i++) : ?>
                        <tr>
                            <td><?= $fechas[$i] ?></td>
                            <?php foreach ($sintomas as $sintoma) : ?>
                                <td><input class="checkbox-calendario" name="intervalo_sintomas[]" type="checkbox" value="<?= $sintoma->id . '$' . $fechas[$i] ?>" <?php if(isset($sintomasMarcados[$i][$sintoma->id]) && $sintomasMarcados[$i][$sintoma->id]) echo "checked"; ?>></td>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                </tbody>
            </table>

            <button type="submit" name="guardarCalendario" class="saveCalendario"><i class="fas fa-save"></i></button>
        </form>
    </div>

    <footer class="footer-usuario">
        <p>Aplicación creada con fines educativos. Por Marc y Gorka.</p>
    </footer>

</body>

</html>