<?php
// Se incluye el archivo de configuración de la base de datos
include_once '../configuraciones/bd.php';

// Se crea una instancia de la conexión a la base de datos
$conexionBD=BD::crearInstancia();

// Se obtienen los datos del formulario o se asignan valores predeterminados
$id=isset($_POST['id'])?$_POST['id']:'';
$nombre_curso=isset($_POST['nombre_curso'])?$_POST['nombre_curso']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

// Si se ha enviado un formulario, se ejecuta la acción correspondiente
if($accion!=''){
    switch($accion){
        case 'agregar':
            // Se inserta un nuevo curso en la base de datos
            $sql="INSERT INTO cursos (id, nombre_curso) VALUES (NULL, :nombre_curso)";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':nombre_curso',$nombre_curso);
            $consulta->execute();
        break;

        case 'editar':
            // Se actualiza la información de un curso existente en la base de datos
            $sql="UPDATE cursos SET nombre_curso=:nombre_curso WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->bindParam(':nombre_curso',$nombre_curso);
            $consulta->execute();
        break;

        case 'borrar':
            // Se elimina un curso de la base de datos
            $sql="DELETE FROM cursos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
        break;

        case 'Seleccionar':
            // Selecciona un curso específico de la base de datos para su edición
            $sql="SELECT * FROM cursos WHERE id=:id";
            $consulta=$conexionBD->prepare($sql);
            $consulta->bindParam(':id',$id);
            $consulta->execute();
            $curso=$consulta->fetch(PDO::FETCH_ASSOC);
            $nombre_curso=$curso['nombre_curso'];
            
    }
}

// Selecciona todos los cursos de la base de datos
$consulta=$conexionBD->prepare("SELECT * FROM cursos");
$consulta->execute();
$listaCursos=$consulta->fetchAll();

?>