<?php

    //Adición de insumos dentro del control de la clinica de laboratorios//

    //El presente programa ha sido realizado bajo el patrón de diseño estructural para realizar un mantenimiento (inserción, eliminación, comsulta y actualización de datos) a una tabla dentro de una base de datos, en específico a la tabla Categoria en la base de datos "empresa"//

    //Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)//

    //Archivo PHP de la página para agregar nuevos registros (Versión de archivo 1.0)//


    //Inclusión de la conexión a la base de datos//

    require_once "Database/dbcon.php";

    //Validación de recepción de acciones en el lado del cliente para mostrar las demás partes del contenido en la página para agregar registros//
    
    if(isset($_POST['add']) == '')
    {

        //Asignación del valor del contenido de las plantillas//

        $pagina = file_get_contents("Templates/addres.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--alert--/', "", $pagina);

        //Información del paciente al que se le ingresaran los resultados//

        $pagina = preg_replace('/--dui--/', GetDUI(), $pagina);

        $pagina = preg_replace('/--id--/', GetID(), $pagina);

        $pagina = preg_replace('/--examenes--/', GetExamenes(), $pagina);

        $pagina = preg_replace('/--titulo--/', "<h1><strong>INGRESO DE RESULTADOS</strong></h1>", $pagina);

        $pagina = preg_replace('/--botones--/', '<!-- Grupo de botones -->

        <center><div class = "container text-white" style = "background-color: rgba(255, 255, 255, 0);">
            
          <div class="row">
      
            <div class="col">
              
              <button type="submit" name = "add" title = "Ingresa los datos requeridos y añade un nuevo registro de resultados." class="btn btn-primary">Agregar nuevo resultado <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  
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
      
      </div></center>', $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);

        
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    else
    {
        //Si hay acción de edición, eliminación o inserción//
        
        $pagina = file_get_contents("Templates/addres.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--alert--/', GetAlert(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);

        //Dando la información del paciente seleccionado//

        $pagina = preg_replace('/--dui--/', "", $pagina);

        $pagina = preg_replace('/--id--/', "", $pagina);

        $pagina = preg_replace('/--examenes--/', "", $pagina);

        $pagina = preg_replace('/--titulo--/', "", $pagina);

        $pagina = preg_replace('/--botones--/', '<center><div class="col-md">

        <a class="btn btn-dark" href = "indexres.php?filtro=ida" type = "submit" title = "Vuelve a la lista de boletas existentes.">Regresar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            
            <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
          
        </svg> </a>

      </div></center><br>', $pagina);
  
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    //Creación de métodos para generar cada plantilla sobre la marcha y componer la página resultante//

    //Función para llamar a la plantilla de la barra de navegación//

    function GetNav()
    {

        //Variable para mostrar las opciones de la barra de navegación//

        $actions = '<a class="dropdown-item" href="indexres.php?filtro=ida" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Consulta las boletas de resultados existentes.</strong></a>';

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

        //Obteniendo el ID enviado por la función de selección del paciente//

        $codpaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["codpaciente"], ENT_QUOTES)));

        $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE Cod_Paciente = '$codpaciente'") or die(mysqli_error($cnx));;

        //Recuperando el valor de los resultados en forma de arreglo para cada tipo de examen//

        $row = mysqli_fetch_assoc($sql);

        $nombrepaciente = $row['Nombre_Paciente'];

        $duipaciente = $row['DUI_Paciente'];



        if(!empty($_POST['examen']))
        {

            $resultados = $_POST['examen'];

            $res = join(", ", $resultados);

        }

        //Generación automática del ID para la boleta//
        
        $insert = mysqli_query($cnx, "INSERT INTO resultado_examenes (Nombre_Paciente, DUI_Paciente, Resultados_Paciente) VALUES ('$nombrepaciente', '$duipaciente', '$res')") or die(mysqli_error($cnx));
            
        if(mysqli_affected_rows($cnx) > 0)
        {

            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            
            <strong><center>¡La boleta de resultados se ha agregado con éxito!</center></strong>
            
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


    function GetID()
    {

        //Obteniendo el ID enviado por la función de selección del paciente//

        $idpaciente = $_REQUEST['idpaciente'];
        
        //Retornando los valores de opción de los pacientes existentes en la base de datos//

        //Mostrando los datos de la base, en la tabla de la página principal para la tabla "Categorías"//

        //Variable global de conexión alojada en dbcon.php//

        global $cnx;

        //Variable Data para almacenar los datos//

        $cod = "";

        $sql = mysqli_query($cnx, "SELECT Cod_Paciente FROM informacion_pacientes WHERE ID_Paciente = '$idpaciente'") or die(mysqli_error($cnx));;

        if(mysqli_num_rows($sql) == 0)
        {
            //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos//

            $cod.= '<input size="200" maxlength="200" type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "codpaciente" name = "codpaciente" value = "Aquí se mostrará su código." readonly>';
        }

        else 
        {

            //Creando opciones por cada registro encontrado//

            while($row = mysqli_fetch_assoc($sql))
            {

                $cod.= '
              
                <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
              
                <!-- Entrada de un cajón de texto para la descripción del insumo -->
    
                <div class>
  
                    <p><strong>ID del paciente seleccionado</strong></p>
  
                    <input size="200" maxlength="200" type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "codpaciente" name = "codpaciente" value = ' . $row['Cod_Paciente'] . ' readonly>
  
                </div>
    
                </div>';

            }

        }

        //Obteniendo el ID del paciente seleccionado por el cajón de combo//

        return $cod;

    }

    function GetDUI()
    {

        //Obteniendo el ID enviado por la función de selección del paciente//

        $idpaciente = $_REQUEST['idpaciente'];
        
        //Retornando los valores de opción de los pacientes existentes en la base de datos//

        //Mostrando los datos de la base, en la tabla de la página principal para la tabla "Categorías"//

        //Variable global de conexión alojada en dbcon.php//

        global $cnx;

        //Variable Data para almacenar los datos//

        $dui = '';

        $sql = mysqli_query($cnx, "SELECT DUI_Paciente, Nombre_Paciente FROM informacion_pacientes WHERE ID_Paciente = '$idpaciente'") or die(mysqli_error($cnx));;

        if(mysqli_num_rows($sql) == 0)
        {
            //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos//

            $dui.= '<input size="200" maxlength="200" type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "duipaciente" name = "duipaciente" value = "Aquí se mostrará su nombre y DUI sin guión." readonly>';
        }

        else 
        {

            //Creando opciones por cada registro encontrado//

            while($row = mysqli_fetch_assoc($sql))
            {

                $dui.= '<div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
              
                <!-- Entrada de un cajón de texto para la descripción del insumo -->
    
                <div class>
  
                  <p><strong>Nombre completo del paciente</strong></p>
  
  
                  <input size="200" maxlength="200" type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "duipaciente" name = "duipaciente" value = "' . $row['Nombre_Paciente'] . '" readonly>
                    
  
                </div>
    
            </div>';

            }

        }

        //Obteniendo el ID del paciente seleccionado por el cajón de combo//

        return $dui;

    }

    function GetExamenes()
    {

        $cajon = '';

        //Obteniendo el ID enviado por la función de selección del paciente//

        $idpaciente = (isset($_REQUEST['idpaciente'])) ? strtolower($_REQUEST['idpaciente']) : NULL;

        if($idpaciente == ""){

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

            $resultados = array();

            $sql = mysqli_query($cnx, "SELECT Examen_Paciente FROM informacion_pacientes WHERE ID_Paciente = '$idpaciente'") or die(mysqli_error($cnx));;

            $row = mysqli_fetch_assoc($sql);

            $examenes = $row['Examen_Paciente'];

            $exam = explode(", ", $examenes);

            $num = 0;

            foreach($exam as $resultado)
            {

                $num++;

                $cajon.= '<div class="col">

                <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
                
                    <!-- Entrada de un cajón de selección para el estado -->
        
                    <div class>
        
                    <p><strong>Resultado del examen de ' . $resultado . '</strong></p>
        
                    <input type = "text" class = "form-control text-light" style = "background-color: #000000d0;" placeholder = "Ingresa el resultado" id = "examen' . $num . '" name = "examen[]" required>
        
                    </div>
        
                </div>
        
                </div><br>';

            }

        }
        
        return $cajon;     
        

    }

?>