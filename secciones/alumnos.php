<?php
// Se incluye el archivo de configuración de la base de datos
include_once '../configuraciones/bd.php';
// Se crea una instancia de la conexión a la base de datos
$conexionBD=BD::crearInstancia();

// Se obtienen los datos del formulario o se asignan valores predeterminados
$id=isset($_POST['id'])?$_POST['id']:'';
$nombre=isset($_POST['nombre'])?$_POST['nombre']:'';
$apellidos=isset($_POST['apellidos'])?$_POST['apellidos']:'';

$cursos=isset($_POST['cursos'])?$_POST['cursos']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

// Si se ha enviado un formulario, se ejecuta la acción correspondiente
if($accion!=''){
    switch($accion){
        case 'agregar':
            // Se inserta un nuevo alumno en la base de datos
            $sql="INSERT INTO alumnos (id, nombre, apellidos) VALUES (NULL, :nombre, :apellidos)";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->execute();
        
            // Se obtiene el ID del nuevo alumno insertado
            $idAlumno=$conexionBD->lastInsertId();

            // Se insertan los cursos asociados al alumno en la tabla de relación alumnos_cursos
            foreach($cursos as $curso){
                $sql="INSERT INTO alumnos_cursos (id, idalumno, idcurso) VALUES (NULL, :idalumno, :idcurso)";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':idalumno',$idAlumno);
                $consulta->bindParam(':idcurso',$curso);
                $consulta->execute();
            }

        break;

        case 'Seleccionar':
            // Selecciona un alumno específico y sus cursos asociados para su edición
            $sql="SELECT * FROM alumnos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
            $alumno=$consulta->fetch(PDO::FETCH_ASSOC);

            $nombre=$alumno['nombre'];
            $apellidos=$alumno['apellidos'];
            
            $sql="SELECT cursos.id FROM alumnos_cursos INNER JOIN cursos ON cursos.id=alumnos_cursos.idcurso WHERE alumnos_cursos.idalumno=:idalumno";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':idalumno',$id);
            $consulta->execute();
            $cursosAlumno=$consulta->fetch(PDO::FETCH_ASSOC);
            
            foreach($cursosAlumno as $curso){
                $arregloCursos[]=$curso['id'];
            }
        break;

        case 'borrar':
            $sql="DELETE FROM alumnos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
        break;
        
        case 'editar':
            $sql="UPDATE alumnos SET nombre=:nombre, apellidos=:apellidos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->execute();

            if(isset($cursos)){
                $sql="DELETE FROM alumnos_cursos WHERE idalumno=:idalumno";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':idalumno',$id);
                $consulta->execute();

                foreach($cursos as $curso){
                    $sql="INSERT INTO alumnos_cursos (id, idalumno, idcurso) VALUES (NULL, :idalumno, :idcurso)";
                    $consulta=$conexionBD->prepare($sql);
                    $consulta->bindParam(':idalumno',$idAlumno);
                    $consulta->bindParam(':idcurso',$curso);
                    $consulta->execute();
                }
                $arregloCursos=$cursos;
            }
        break;
    }
}


$sql="SELECT * FROM alumnos";
$listaAlumnos=$conexionBD->query($sql);
$alumnos=$listaAlumnos->fetchAll();

foreach($alumnos as $clave => $alumno){

    $sql="SELECT * FROM cursos WHERE id IN (SELECT idcurso FROM alumnos_cursos WHERE idalumno=:idalumno)";
    $consulta=$conexionBD->prepare($sql);
    $consulta->bindParam(':idalumno',$alumno['id']);
    $consulta->execute();
    $cursosAlumno=$consulta->fetchAll();
    $alumnos[$clave]['cursos']=$cursosAlumno;
}

$sql="SELECT * FROM cursos";
$listaCursos=$conexionBD->query($sql);
$cursos=$listaCursos->fetchAll();



?>
