<?php

  //Reporte de datos almacenados en la base de datos, tabla de insumos ordenados alfabeticamente por nombre de forma ascendente//

  //Impresión de archivo PDF a través de FPDF//

  //Solicitando librería FPDF para la impresión//

  require('fpdf.php');

  //Inclusión de la conexión a la base de datos y la recuperación de datos//

  require_once "../../Database/dbcon.php";

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

      $this->SetFont('Arial','I',12);

      $this->Cell(100);

      $this->Cell(80,20,utf8_decode('¡Cuidando la salud de la población salvadoreña!'),0,0,'C');
      
      $this->Ln(20);

      $this->Cell(280,20,utf8_decode('INVENTARIO DE INSUMOS'),0,0,'C');

      $this->Ln(30);

      $this->Cell(25,10, utf8_decode('Código'), 1, 0, 'C', 0);
              
      $this->Cell(35,10, utf8_decode('Nombre'), 1, 0, 'C', 0);

      $this->Cell(45,10, utf8_decode('Descripción'), 1, 0, 'C', 0);

      $this->Cell(25,10, utf8_decode('Cantidad'), 1, 0, 'C', 0);

      $this->Cell(25,10, utf8_decode('Costo'), 1, 0, 'C', 0);

      $this->Cell(40,10, utf8_decode('Fecha de compra'), 1, 0, 'C', 0);

      $this->Cell(25,10, utf8_decode('Medida'), 1, 0, 'C', 0);

      $this->Cell(35,10, utf8_decode('Proveedor'), 1, 0, 'C', 0);

      $this->Cell(20,10, utf8_decode('Estado'), 1, 1, 'C', 0);

    }

    // Pie de página
    function Footer()
    {

      // Posición: a 1,5 cm del final

      $this->SetFont('Arial','I',8);

      $this->Cell(70,20,utf8_decode('Reporte donde se muestra la información de los registros almacenados en la base de datos de los insumos para los laboratorios disponibles ordenados por cantidad de forma ascendente.'));

      $this->Ln(10);

      $this->Cell(70,20,utf8_decode('Estado activo (A) y estado inactivo (I), Teléfono (Regencia) 7756-5656'));

      // Posición: a 1,5 cm del final

      $this->SetY(-15);

      // Arial italic 8

      $this->SetFont('Arial','I',8);

      //Fecha de emisión del reporte//

      //Configuración de la fecha local del servidor//

      date_default_timezone_set('America/El_Salvador');

      //imprimiendo la fecha local del servidor o de emisión del reporte.//

      $Object = new DateTime(); 

      $DateAndTime = $Object->format("d-m-Y h:i:s a");  

      $this->Cell(80,20,utf8_decode('Este reporte ha sido elaborado el ' . $DateAndTime),0,0,'C');

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


  $sql = mysqli_query($cnx, "SELECT * FROM inventario_insumos ORDER BY Cantidad_Insumo ASC");

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

      //Concatenando filas y columnas para cada valor//

      $pdf->Cell(25,10, $row['Cod_Insumo'], 1, 0, 'C', 0);
              
      $pdf->Cell(35,10, utf8_decode($row['Nombre_Insumo']), 1, 0, 'C', 0);

      $pdf->Cell(45,10, utf8_decode($row['Descripcion_Insumo']), 1, 0, 'C', 0);

      $pdf->Cell(25,10, $row['Cantidad_Insumo'], 1, 0, 'C', 0);

      $pdf->Cell(25,10, "$ " . $row['Costo_Insumo'], 1, 0, 'C', 0);

      $pdf->Cell(40,10, utf8_decode($row['Compra_Insumo']), 1, 0, 'C', 0);

      $pdf->Cell(25,10, utf8_decode($row['Unidad_Medida']), 1, 0, 'C', 0);

      $pdf->Cell(35,10, utf8_decode($row['Proveedor_Insumo']), 1, 0, 'C', 0);

      $pdf->Cell(20,10, $row['Estado_Insumo'], 1, 1, 'C', 0);

    }
  }

  $pdf->Output();

?>
