<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/admin.css'); ?>">
    <script src="https://kit.fontawesome.com/c2dea4f87e.js" crossorigin="anonymous"></script>
</head>

<body>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <div class="container-fluid">
        <h5>HABITOS</h5>
        <hr>
        <form method="post" class="w-100" action="<?= site_url('Admin/add_habito'); ?>">

            <div class="d-flex justify-content-around align-center">
                <?php if (isset($this->session->editar)) : ?>
                    <a id="button" class="btn btn-primary" href="<?= site_url('Admin/cancelarEdicion'); ?>">Cancelar</a>
                    <button type="button" class="btn btn-primary">Guardar</button>
                <?php elseif (isset($items)) : ?>
                    <a href="<?= site_url('Admin/editarItems'); ?>"><i class="edit fas fa-edit"></i></a>
                <?php endif ?>
            </div>

            <table id="table_items" class="w-75 table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sintoma</th>
                        <th scope="col">Porcentaje</th>
                        <?php if (isset($this->session->editar)) : ?>
                            <th scope="col">Nuevo porcentaje</th>
                            <th scope="col">Eliminar</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($items)) : ?>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?= $item->id ?></td>
                                <td><?= $item->nombre ?></td>
                                <td><?= $item->porcentaje ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>

    </div>

</body>

</html>