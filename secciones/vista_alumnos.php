<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/alumnos.php'); ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

<br>
<div class="row">
    <div class="col-md-5">
        <form action="" method="post">
            <div class="card">
                <div class="card-header">
                    <b><center>Alumnos</center></b>
                </div>

                <div class="card-body">
                    <div class="mb-3 d-none">
                        <label for="id" class="form-label">ID</label>
                        <input type="text"
                        class="form-control" value="<?php echo $id; ?>" name="id" id="id" aria-describedby="helpId" placeholder="ID">
                    </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Nombre</label>
                          <input type="text"
                            class="form-control" pattern="[a-z, A-Z]*" required value="<?php echo $nombre; ?>" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Escribe el Nombre">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Apellidos</label>
                          <input type="text"
                            class="form-control" pattern="[a-z, A-Z]*" required value="<?php echo $apellidos; ?>" name="apellidos" id="apellidos" aria-describedby="helpId" placeholder="Escribe los Apellidos">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Cursos del alumno</label>

                          <select multiple class="form-control" name="cursos[]" id="listaCursos">
                            
                            <?php foreach($cursos as $curso){?> 
                                <option 
                                <?php
                                    if(!empty($arregloCursos)):
                                        if(in_array($curso['id'], $arregloCursos)):
                                            echo 'selected';
                                        endif;
                                    endif;
                                ?>
                                value="<?php echo $curso['id']; ?>">  <?php echo $curso['id']; ?> - <?php echo $curso['nombre_curso']; ?> </option>
                            <?php } ?>

                          </select>

                        </div>
                        <center><div class="d-grid gap-3 d-md-block" role="group" aria-label="">
                            <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
                            <button type="submit" name="accion" value="editar" class="btn btn-warning">Editar</button>
                            <button type="submit" name="accion" value="borrar" class="btn btn-danger">Borrar</button>
                        </div></center>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <table class="table table-bordered border-dark">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>
                            <center> Acciones </center>
                        </th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach($alumnos as $alumno): ?>
                    <tr>
                        <td>  
                            <?php echo $alumno['id']; ?>  
                        </td>

                        <td>  

                            <?php echo $alumno['nombre']; ?> <?php echo $alumno['apellidos']; ?>  
                            <br/> 
                            <?php foreach($alumno["cursos"] as $curso){ ?>

                                - <a href="certificado.php?idcurso=<?php echo $curso['id']; ?>&idalumno=<?php echo $alumno['id']; ?>"> <i class="bi bi-file-earmark-pdf text-danger"></i> <?php echo $curso['nombre_curso'];?> </a> <br/>

                            <?php } ?>
                            
                        </td>

                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $alumno['id'];?>">
                                <center><input type="submit" value="Seleccionar" name="accion" class="btn btn-primary"></center>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/js/tom-select.complete.min.js"></script>

    <script>
        new TomSelect('#listaCursos');
    </script>


<?php include('../templates/pie.php'); ?>