<?php 
// Se incluye la clase FPDF para generar el PDF
require('../lib/fpdf.php');

// Se incluye el archivo de configuración de la base de datos
include_once '../configuraciones/bd.php';

// Se crea una instancia de la conexión a la base de datos
$conexionBD=BD::crearInstancia();

/**
 * Función para agregar texto al PDF.
 *
 * @param object $pdf El objeto FPDF.
 * @param string $texto El texto a agregar.
 * @param int $x La coordenada X de la posición del texto.
 * @param int $y La coordenada Y de la posición del texto.
 * @param string $align La alineación del texto ('L' = Izquierda, 'C' = Centro, 'R' = Derecha).
 * @param string $fuente La fuente del texto.
 * @param int $size El tamaño de la fuente.
 * @param int $r El componente rojo del color del texto (0-255).
 * @param int $g El componente verde del color del texto (0-255).
 * @param int $b El componente azul del color del texto (0-255).
 */

function agregarTexto($pdf,$texto,$x,$y,$align='L',$fuente,$size=10,$r=0,$g=0,$b=0){
    $pdf->SetFont($fuente,"",$size);
    $pdf->SetXY($x,$y);
    $pdf->SetTextColor($r,$g,$b);
    $pdf->Cell(0,10,$texto,0,0,$align);
}

/**
 * Función para agregar una imagen al PDF.
 *
 * @param object $pdf El objeto FPDF.
 * @param string $imagen La ruta de la imagen a agregar.
 * @param int $x La coordenada X de la posición de la imagen.
 * @param int $y La coordenada Y de la posición de la imagen.
 */

function agregarImagen($pdf,$imagen,$x,$y){
    $pdf->Image($imagen,$x,$y,0);
}

// Se obtienen los parámetros de la URL o se asignan valores predeterminados
$idcurso=isset($_GET['idcurso'])?$_GET['idcurso']:'';
$idalumno=isset($_GET['idalumno'])?$_GET['idalumno']:'';

// Se selecciona el nombre del alumno y el nombre del curso de la base de datos
$sql="SELECT alumnos.nombre, alumnos.apellidos, cursos.nombre_curso FROM alumnos, cursos WHERE alumnos.id=:idalumno AND cursos.id=:idcurso";
$consulta=$conexionBD->prepare($sql);
$consulta->bindParam(':idalumno',$idalumno);
$consulta->bindParam(':idcurso',$idcurso);
$consulta->execute();
$alumno=$consulta->fetch(PDO::FETCH_ASSOC);
print_r($alumno);

// Se crea una nueva instancia de FPDF con orientación paisaje y tamaño personalizado
$pdf = new FPDF("L", "mm", array(254,194));
$pdf->AddPage();

// Se establece la fuente y se agrega la imagen del certificado al PDF
$pdf->setFont("Arial","B",16);
agregarImagen($pdf, "../src/certificado.jpg",0,0);

// Se agrega el nombre completo del alumno y el nombre del curso al PDF
agregarTexto($pdf,ucwords(utf8_decode($alumno['nombre']." ".$alumno['apellidos'])),60,70,'L',"Helvetica",30,0,84,115);

// Se agrega la fecha actual al PDF
agregarTexto($pdf,$alumno['nombre_curso'],-250,110,'C',"Helvetica",20,0,84,115);
agregarTexto($pdf,date("d/m/Y"),-350,155,'C',"Helvetica",11,0,84,115);

// Se genera el PDF y se envía al navegador
$pdf->Output();

?>