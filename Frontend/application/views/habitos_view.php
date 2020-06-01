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
        <form method="post" class="w-100" action="<?= site_url('Admin/guardarHabito'); ?>">

            <div class="d-flex justify-content-around align-center">
                <?php if (isset($this->session->editar)) : ?>
                    <a id="button" class="btn btn-primary" href="<?= site_url('Admin/cancelarEdicion'); ?>">Cancelar</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#habitoModal">
                        Añadir Habito
                    </button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                <?php else : ?>
                    <a href="<?= site_url('Admin/editarItems'); ?>"><i class="edit fas fa-edit"></i></a>
                <?php endif ?>
            </div>

            <?php if (isset($this->session->editar)) : ?>
                <p id="js_porcentaje"></p>
            <?php endif ?>
            <?php if (isset($errores)) : ?>
                <ul>
                    <?php foreach ($errores as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif ?>
            <br>

            <table id="table_items" class="w-75 table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Habito</th>
                        <th scope="col">Si</th>
                        <th scope="col">No</th>
                        <th scope="col">A veces</th>
                        <?php if (isset($this->session->editar)) : ?>
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
                                <?php if (isset($this->session->editar)) : ?>
                                    <td><input type="text" id="porcentajes_si" class="fadeIn second" name="porcentajes_si[]" value="<?= $item->si ?>" placeholder="<?= $item->si ?>"></td>
                                    <td><input type="text" id="porcentajes_no" class="fadeIn second" name="porcentajes_no[]" value="<?= $item->no ?>" placeholder="<?= $item->no ?>"></td>
                                    <td><input type="text" id="porcentajes_a_veces" class="fadeIn second" name="porcentajes_a_veces[]" value="<?= $item->a_veces ?>" placeholder="<?= $item->a_veces ?>"></td>
                                    <td><a href="<?= site_url('Admin/eliminarItem/' . $item->id); ?>"><i class="far fa-trash-alt"></i></a></td>
                                <?php else : ?>
                                    <td><?= $item->si ?></td>
                                    <td><?= $item->no ?></td>
                                    <td><?= $item->a_veces ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>

        <!-- Modal -->
        <form method="post" action="<?= site_url('Admin/addItem'); ?>">
            <div class="modal fade" id="habitoModal" tabindex="-1" role="dialog" aria-labelledby="habitoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="habitoModalLabel">Añadir un habito</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="habito">Habito: </label>
                            <input type="text" id="habito" class="form-control" name="nombre" placeholder="Habito" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</body>

</html>