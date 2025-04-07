<!DOCTYPE html>
<html lang="es">
<?php
$title = 'Alumnos';
include_once 'partials/head.php'
?>

<body>
    <?php include_once 'partials/menu.php' ?>

    <div class="datos-container">
        <div class="new-container d-flex justify-content-between">
            <form action="" class="d-flex gap-3">
                <input type="text" class="form-control" name="busqueda" id="busqueda" placeholder="Palabra clave">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal">+ Añadir alumno</button>
        </div>
        
        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-striped table-responsive" id="tabla">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Email</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) { ?>
                        <tr>
                            <th scope="row" id="table-nombre"><?= $student['nombre'] ?></th>
                            <td id="table-apellidos"><?= $student['apellidos'] ?></td>
                            <td id="table-email"><?= $student['email'] ?></td>
                            <td id="table-dni"><?= $student['dni'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal" data-editar="<?= $student['id'] ?>" onclick="verAlumno(this)">Editar</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal"data-eliminarid="<?= $student['id'] ?>" data-eliminarnombre="<?= $student['nombre'] ?>" onclick="eliminarModal(this)">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="paginacion">
            
        </div>
    </div>

    <!-- MODALES -->
    <!-- Modal nuevo alumno -->
    <div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Añadir alumno</h5>
                    <button type="button" class="close btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="alumnonuevo-form">
                    <div class="modal-body">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control w-100" id="nuevo-nombre" name="nombre">
                        <div class="invalid-feedback-nombre new-invalid text-danger mb-2"></div>

                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control w-100" id="nuevo-apellidos" name="apellidos">
                        <div class="invalid-feedback-apellidos new-invalid text-danger mb-2"></div>

                        <label for="email">Email</label>
                        <input type="email" class="form-control w-100" id="nuevo-email" name="email">
                        <div class="invalid-feedback-email new-invalid text-danger mb-2"></div>

                        <label for="dni">DNI</label>
                        <input type="text" class="form-control w-100" id="nuevo-dni" name="dni">
                        <div class="invalid-feedback-dni new-invalid text-danger mb-2"></div>
                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="crearAlumno()">Crear alumno</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar alumno -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar alumno</h5>
                    <button type="button" class="close btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="editar-form">
                    <div class="modal-body">
                        <input type="hidden" class="form-control w-100 mb-4" id="editar-id" name="id">

                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control w-100 mb-4" id="editar-nombre" name="nombre">

                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control w-100 mb-4" id="editar-apellidos" name="apellidos">

                        <label for="email">Email</label>
                        <input type="email" class="form-control w-100 mb-4" id="editar-email" name="email">

                        <label for="dni">DNI</label>
                        <input type="text" class="form-control w-100 mb-4" id="editar-dni" name="dni">
                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="editarModal()">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal eliminar alumno -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar alumno</h5>
                    <button type="button" class="close btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST" id="eliminar-form">
                    <div class="modal-content px-4 py-4">
                        <span>¿Estás seguro de que quieres eliminar el alumno <a id="nombrealumno"></a>?</span>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">Cerrar</button>
                        <button type="button" id="confirmarEliminar" class="btn btn-danger">Eliminar alumno</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'partials/scripts.php' ?>
    <script src="/gestor_academia_mvc/public/js/alumnos_script.js"></script>
</body>
</html>