<?php

    //Modificación de un insumo de inventario//

    //El presente programa ha sido realizado bajo el patrón de diseño estructural para realizar un mantenimiento (inserción, eliminación, comsulta y actualización de datos) a una tabla dentro de una base de datos, en específico a la tabla Categoria en la base de datos "empresa"//

    //Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)//

    //Archivo PHP de la página para la modificación de registros (Versión de archivo 1.0)//


    //Inclusión de la conexión a la base de datos//

    require_once "Database/dbcon.php";

    //Validación de recepción de acciones en el lado del cliente para mostrar las demás partes del contenido en la página para agregar registros//


    if(isset($_REQUEST['save']) == '')
    {

        //Si el usuario genera una acción con valor "OK"//

        if(isset($_REQUEST['acc']) == 'OK')
        {
            //Se generan las siguientes partes de la página//

            //Asignación del valor del contenido de las plantillas//

            $pagina = file_get_contents("Templates/changeres.html");

            //Reemplazando el valor de las páginas por las plantillas (nav.html)//

            $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

            //Reemplazando el valor de las páginas por las plantillas (header.html)//

            $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

            //Reemplazando el valor de las páginas por las plantillas (alert.html)//

            $pagina = preg_replace('/--form--/', GetForm(), $pagina);

            //Reemplazando el valor de las páginas por las plantillas (year)//

            $pagina = preg_replace('/--year--/', GetYear(), $pagina);


            //Mostrando una alerta positiva en caso de que la edición haya sido exitosa//

            $pagina = preg_replace('/--alert--/', '<div class="alert alert-success alert-dismissible fade show" role="alert">
          
            <strong><center>¡La boleta de resultados se ha modificado con éxito!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>
  
            </div>', $pagina);

        
            //Impresión de la página construida a base de las plantillas//

            echo $pagina;

        }

        //Si no hay una acción de valor "OK" entonces//

        else
        {
            //Se generan las siguientes partes de la página//

            //Asignación del valor del contenido de las plantillas//

            $pagina = file_get_contents("Templates/changeres.html");

            //Reemplazando el valor de las páginas por las plantillas (nav.html)//

            $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

            //Reemplazando el valor de las páginas por las plantillas (header.html)//

            $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

            //Reemplazando el valor de las páginas por las plantillas (alert.html)//

            $pagina = preg_replace('/--form--/', GetForm(), $pagina);

            //Reemplazando el valor de las páginas por las plantillas (year)//

            $pagina = preg_replace('/--year--/', GetYear(), $pagina);

            //Mostrando una alerta positiva en caso de que la edición haya sido exitosa//

            $pagina = preg_replace('/--alert--/', '', $pagina);


            echo $pagina;
        }

    }

    else
    {
        //Si hay acción de edición, eliminación o inserción//
        
        $pagina = file_get_contents("Templates/changeres.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--form--/', GetForm(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);
  
        //Mostrando una alerta negativa en caso de que la edición no haya sido exitosa//

        $pagina = preg_replace('/--alert--/', GetAlert(), $pagina);

        
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    //Creación de métodos para generar cada plantilla sobre la marcha y componer la página resultante//

    //Función para llamar a la plantilla de la barra de navegación//

    function GetNav()
    {

        //Variable para mostrar las opciones de la barra de navegación//

        $actions = '<a class="dropdown-item" href="adduser.php" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Ingresa un nuevo registro</strong>

        
        <a class="dropdown-item" href="indexuser.php?filtro=ida" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Consulta las boletas existentes</strong></a>';

        //Inicializando la variable de la barra de navegación//

        $nav = file_get_contents("Templates/navres.html");

        $nav = preg_replace('/--actions--/', $actions, $nav);

        //Retornando la barra de navegación completa//

        return $nav;

    }

    //Función para llamar a la plantilla de la cabecera de la página de inicio//

    function GetHeader()
    {
        //Asignando la variable para mostrar el encabezado de la página (Nombre y pertenencia)//

        $header = file_get_contents("Templates/headerres.html");

        //Retornando el encabezado completo barra de navegación completa//

        return $header;

    }

    //Función para llamar a la plantilla de las alertas//

    function GetAlert()
    {

      global $cnx;

      $nompaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nameres"], ENT_QUOTES)));

      //Obteniendo el ID enviado por la función de selección del paciente//

      if(!empty($_POST['examen']))
      {

          $resultados = $_POST['examen'];

          $res = join(", ", $resultados);

      }

      //Generación automática del ID para la boleta//
      
      $update = mysqli_query($cnx, "UPDATE resultado_examenes SET Resultados_Paciente = '$res' WHERE Nombre_Paciente = '$nompaciente';") or die(mysqli_error($cnx));
          
      if(mysqli_affected_rows($cnx) > 0)
      {

          $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
          
          <strong><center>¡La boleta de resultados se ha modificado con éxito! Ya puedes emitirla asi que regresa para hacerlo.</center></strong>
          
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            
          <span aria-hidden="true">&times;</span>
          
          </button>

          </div>';

      }

      else
      {
          $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          
          <strong><center>¡No se pudo guardar la boleta de resultados!</center></strong>
          
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            
          <span aria-hidden="true">&times;</span>
          
          </button>

          </div>';
          
      }


      //Cerrando Resultset//

      //Devolviendo la alerta según el resultado de las operaciones//

      return $alert;
    }
        

    //Función para llamar a la plantilla del año//

    function GetYear()
    {
        //Asignando variable para el año de muestra//

        $year = date("Y");

        //Retornando el encabezado completo barra de navegación completa//

        return $year;

    }

    function GetForm()
    {

        //Variable global de conexión//

        global $cnx;

        $form = "";

        //Variables de los datos a ingresar limpiando el código de PHP y HTML para ingresar valores limpios a la base de datos//

        $nompaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['nameres'], ENT_QUOTES)));

        //Si la consulta retorna valores//

        $sql = mysqli_query($cnx, "SELECT * FROM resultado_examenes WHERE Nombre_Paciente = '$nompaciente'");
        
        if(mysqli_num_rows($sql) > 0)
        {
            //Asignación de valores de la tabla a las variables locales//

            $row = mysqli_fetch_array($sql);

            $resultados = $row['Resultados_Paciente'];

            $res = explode(", ", $resultados);

            $sql2 = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE Nombre_Paciente = '$nompaciente'");

            if(mysqli_num_rows($sql2) > 0){

              $row = mysqli_fetch_array($sql2);

              $cod = $row['Cod_Paciente'];


            }
        


            $form = '

            <form class = "form-inline" method = "POST" action = "changeres.php">

            <div class = "form-group">
        
                <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc ;" id = "idinsumoadd">
        
                    <p><strong>ID de boleta</strong></p>
                    
                    <!-- Entrada de un cajón numérico para el ID del insumo -->
        
                    <center><div>

                        <input size="10" maxlength="10" type = "number" style = "background-color: #000000d0;" class = "form-control text-light" id = "idres" placeholder = "Ingresa un número">
                      
                    </div></center>
        
                </div>

            </div>

            <div class="col-sm">

                <center>

                <!-- Icono de señalización para las alertas -->

                <svg width="4.0625em" height="4em" viewBox="0 0 17 16" class="bi bi-exclamation-triangle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">  
        
                <path fill-rule="evenodd" d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 5zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
            
                </svg>
            
                </center>

            </div>

      <div class="col-sm-6">

        <div id = "alert" class = "container">

            <div class="container">

                <div class="row">

                  <div class="col-sm">

                    <br>

                    <br>

                    <!-- Espacio para la alerta notificadora de las acciones en la base de datos -->

                    --alert--

                  </div>

              </div>

            <br>

        </div>

      </div>

    </div>

  </div>

</div>

<!-- Distribución de columnas para el ingreso de los insumos -->

<div class = "form-group">

    <div class="row">

      <div class="col-sm">

      </div>

      <div class="col-sm">

      </div>

    </div>

    <div class="row">

      <div class="col-sm">

      <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
              
      <!-- Entrada de un cajón de texto para la descripción del insumo -->

      <div class>

          <p><strong>ID del paciente seleccionado</strong></p>

          <input size="200" maxlength="200" type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "codpaciente" name = "codpaciente" value = ' . $cod . ' readonly>

      </div>

      </div>

      </div>

      <div class="col-sm">

      <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
              
                <!-- Entrada de un cajón de texto para la descripción del insumo -->
    
                <div class>
  
                  <p><strong>Nombre completo del paciente</strong></p>
  
  
                  <input size="200" maxlength="200" type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "nameres" name = "nameres" value = "' . $nompaciente . '" readonly>
                    
  
                </div>
    
            </div>

      </div>

      </div>

    
    </div>

      <center><div>

  <br>

  <br>

  <h1><strong>INGRESO DE RESULTADOS</strong></h1>

  <br>

  <br>'

  . GetExamenes() .
  
  '
  
  <br>

    </div></center>

    </div>

    <!-- Grupo de botones -->

<center><div class = "container text-white" style = "background-color: rgba(255, 255, 255, 0);">
    
  <div class="row">

    <div class="col">
      
      <button type="submit" name = "save" href="changeres.php?nameres=ida" title = "Modifica los resultados de esta boleta." class="btn btn-primary">Modificar el resultado <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          
        <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
        
      </svg>
      
      </button>

    </div>

    <div class="col-md">

      <a class="btn btn-dark" href = "indexres.php?filtro=ida" type = "submit" title = "Vuelve a la lista de boletas existentes.">Regresar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          
          <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
        
      </svg> </a>

    </div>

    <br>

  </div>

  <br>

  <br>

</div></center>

  </div>

  <br>

<br>

<br>

</form>';

         //Cerrando Resultset//

         
        }

        else {


          $form = '<br><div class="alert alert-warning alert-dismissible fade show" role="alert">
          
            <strong><center>¡No existe ninguna boleta asociada a este paciente! Debes ingresar una correctamente desde la página anterior.</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>
  
            </div>
            
            <br>
            
            <center><div class="col-md">

            <a class="btn btn-dark" href = "indexres.php?filtro=ida" type = "submit" title = "Vuelve a la lista de boletas existentes.">Regresar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                
                <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
              
            </svg> </a>
    
          </div></center>';




        }

        mysqli_free_result($sql);

          return $form;
          

    }

    function GetExamenes()
    {

      global $cnx;

        $cajon = '';

        //Obteniendo el ID enviado por la función de selección del paciente//

        $nompaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['nameres'], ENT_QUOTES)));

        if($nompaciente == ""){

            //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos y configurando el valor de incremento en 1 para volver a empezar el conteo//

            $cajon = "Al seleccionar un paciente se mostrarán los examenes adjuntos a él.<br>";
            
        }

        else
        {

            //Retornando los valores de opción de los pacientes existentes en la base de datos//

            //Mostrando los datos de la base, en la tabla de la página principal para la tabla "Categorías"//

            //Variable global de conexión alojada en dbcon.php//

            global $cnx;

            //Variable Data para almacenar los datos//

            $examenes = '';

            $res = '';

            $sql = mysqli_query($cnx, "SELECT Examen_Paciente FROM informacion_pacientes WHERE Nombre_Paciente = '$nompaciente'") or die(mysqli_error($cnx));;

            $row = mysqli_fetch_assoc($sql);

            $examenes = $row['Examen_Paciente'];

            $exam = explode(", ", $examenes);

            $num = 0;

            $i = 0;

            //Obteniendo los valores de los resultados//

            $sql2 = mysqli_query($cnx, "SELECT Resultados_Paciente FROM resultado_examenes WHERE Nombre_Paciente = '$nompaciente'") or die(mysqli_error($cnx));;

            $row = mysqli_fetch_assoc($sql2);

            $res = $row['Resultados_Paciente'];

            $rs = explode(", ", $res);

            foreach($exam as $resultado)
            {

              foreach($rs as $valor){


              }

                $num++;

                $cajon.= '<div class="col">

                <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
                
                    <!-- Entrada de un cajón de selección para el estado -->
        
                    <div class>
        
                    <p><strong>Resultado del examen de ' . $resultado . '</strong></p>
        
                    <input type = "text" class = "form-control text-light" style = "background-color: #000000d0;" placeholder = "Ingresa el resultado" id = "examen' . $num . '" name = "examen[]" value = "' . $valor . '" required>
        
                    </div>
        
                </div>
        
                </div><br>';

            }

        }
        
        return $cajon;     
        

    }

?>