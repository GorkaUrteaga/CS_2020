<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/admin.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c2dea4f87e.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?= base_url('js/sintomas.js'); ?>"></script>
</head>

<body>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <div class="container-fluid">
        <h5>SINTOMAS</h5>

        <form method="post" class="w-100" action="<?= site_url('Admin/guardarSintomas'); ?>">

            <div class="d-flex justify-content-around align-center">
                <?php if (isset($this->session->editar)) : ?>
                    <a id="button" class="btn btn-primary" href="<?= site_url('Admin/cancelarEdicion'); ?>">Cancelar</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sintomaModal">
                        Añadir Sintoma
                    </button>
                    <button type="submit" id="guardarButton" class="btn btn-primary">Guardar</button>
                <?php else : ?>
                    <a href="<?= site_url('Admin/editarItems'); ?>"><i class="edit fas fa-edit"></i></a>
                <?php endif ?>
            </div>

            
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
                        <th scope="col">Sintoma</th>
                        <th scope="col">Porcentaje</th>
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
                                    <?php if($item->porcentaje==0) : ?>
                                        <td><input type="number" id="porcentajes" class="fadeIn second perc errorInput" name="porcentajes[]" value="<?= $item->porcentaje ?>" placeholder="<?= $item->porcentaje ?>"></td>
                                    <?php else : ?>
                                        <td><input type="number" id="porcentajes" class="fadeIn second perc" name="porcentajes[]" value="<?= $item->porcentaje ?>" placeholder="<?= $item->porcentaje ?>"></td>
                                    <?php endif; ?>

                                    <td><a href="<?= site_url('Admin/eliminarItem/' . $item->id); ?>"><i class="far fa-trash-alt"></i></a></td>
                                <?php else : ?>
                                    <td><?= $item->porcentaje ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if (isset($this->session->editar)) : ?>
                <p id="js_porcentaje"></p>
            <?php endif ?>        
        </form>

        <!-- Modal -->
        <form method="post" action="<?= site_url('Admin/addItem'); ?>">
            <div class="modal fade" id="sintomaModal" tabindex="-1" role="dialog" aria-labelledby="sintomaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sintomaModalLabel">Añadir un sintoma</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="sintoma">Sintoma: </label>
                            <input type="text" id="sintoma" class="form-control" name="nombre" placeholder="Sintoma" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" id="anadirModal" class="btn btn-primary">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</body>

</html>