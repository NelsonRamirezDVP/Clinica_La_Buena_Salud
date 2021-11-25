<?php

 //Inclusión de la conexión a la base de datos y la recuperación de datos//

 require_once "../../Database/dbcon.php";

  $nompaciente = $_REQUEST["nameres"];

  $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE Nombre_Paciente = '$nompaciente'");

  $sql2 = mysqli_query($cnx, "SELECT * FROM resultado_examenes WHERE Nombre_Paciente = '$nompaciente'");

  //Reporte de datos almacenados en la base de datos, tabla de insumos ordenados alfabeticamente por nombre de forma ascendente//

  //Impresión de archivo PDF a través de FPDF//

  //Solicitando librería FPDF para la impresión//

  require('fpdf.php');

  //Contenido del PDF//

  class PDF extends FPDF
  {
    //Cabecera del archivo PDF//

    function Header()
    {
      //Logotipo de la clínica//

      $this->Image('../Images/cross.jpg',10,8,33);

      // Arial bold 15

      $this->SetFont('Arial','B',20);

      // Movernos a la derecha

      $this->Cell(100);

      // Título

      $this->Cell(80,20,utf8_decode('Clínica La Buena Salud'),0,0,'C');

      // Salto de línea

      $this->Ln(10);

      $this->SetFont('Arial','B',12);

      $this->Cell(100);

      $this->Cell(80,20,utf8_decode('¡Cuidando la salud de la población salvadoreña!'),0,0,'C');

      $this->Ln(10);

      $this->SetFont('Arial','I',12);

      $this->Ln(10);

      $this->Cell(280,20,utf8_decode('RESULTADOS DE EXAMENES REALIZADOS'),0,0,'C');

      $this->Ln(30);

      $this->Cell(40,10, utf8_decode('Código de boleta'), 1, 0, 'C', 0);
              
      $this->Cell(120,10, utf8_decode('Nombre del paciente'), 1, 0, 'C', 0);

      $this->Cell(60,10, utf8_decode('Fecha de realización'), 1, 0, 'C', 0);

      $this->Cell(60,10, utf8_decode('Médico que lo remite'), 1, 1, 'C', 0);

    }

    // Pie de página
    function Footer()
    {

      // Posición: a 1,5 cm del final

      $this->SetFont('Arial','I',8);

      $this->Ln(10);

      $this->Cell(70,20,utf8_decode('Encuentranos en Calle Juan José Cañas entre Calle #85 y #83 de la Av. Sur #421 o puedes contactarnos a través de nuestro teléfono (Regencia) 7756-5656'));

      // Posición: a 1,5 cm del final

      $this->SetY(-15);

      // Arial italic 8

      $this->SetFont('Arial','I',8);

      //Fecha de emisión del reporte//

      //Configuración de la fecha local del servidor//

      date_default_timezone_set('UTC');

      //imprimiendo la fecha local del servidor o de emisión del reporte.//

      $Object = new DateTime(); 

      $DateAndTime = $Object->format("d-m-Y h:i:s a");  

      $this->Cell(80,20,utf8_decode('Esta boleta de resultados ha sido emitida el ' . $DateAndTime),0,0,'C');

    }

  }

  //Retornando datos//

  //Imprimiendo todos lo datos recolectados para mostrarlos en la tabla principal//

  //Instanciando y creando un nuevo objeto para FPDF//

  $pdf = new PDF();

  //Crando la hoja//

  $pdf->AddPage('L');

  //Configuración de fuentes a utilizar//

  $pdf->SetFont('Arial');

  //Exportando y creando el archivo//

  if(mysqli_num_rows($sql) == 0)
  {

    $pdf->Cell(80,20,utf8_decode('No existe ningún dato para mostrar.'));

    $pdf->Ln(10);
    
  }

  else
  {
    //Mostrar los datos por cada registro en la tabla y asignarles una posición en la muestra de la tabla principal//

    while($row = mysqli_fetch_assoc($sql))
    {



      $pdf->Cell(40,10, utf8_decode($row['Cod_Paciente']), 1, 0, 'C', 0);
              
      $pdf->Cell(120,10, utf8_decode($row['Nombre_Paciente']), 1, 0, 'C', 0);

      $pdf->Cell(60,10, utf8_decode($row['Fecha_Examenes']), 1, 0, 'C', 0);

      $pdf->Cell(60,10, utf8_decode($row['Med_Examen']), 1, 1, 'C', 0);

      $pdf->Ln(15);

      $pdf->Cell(20,10, "", 0, 0, 'C', 0);

      $pdf->Cell(120,10, utf8_decode('Examenes'), 1, 0, 'C', 0);
              
      $pdf->Cell(120,10, utf8_decode('Resultados'), 1, 1, 'C', 0);

      $pdf->Cell(20,10, "", 0, 0, 'I', 0);

      $pdf->SetFont('Arial','I',8);

      $pdf->Cell(120,10, utf8_decode($row['Examen_Paciente']), 1, 0, 'I', 0);

      

    }

    while($row = mysqli_fetch_assoc($sql2))
    { 
              
      $pdf->Cell(120,10, utf8_decode($row['Resultados_Paciente']), 1, 0, 'I', 0);

    }

  }

  $pdf->Output();

?>
