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

            $pagina = file_get_contents("Templates/changeuser.html");

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
            
            <strong><center>¡El registro se modificó exitosamente!</center></strong>
        
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

            $pagina = file_get_contents("Templates/changeuser.html");

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
        
        $pagina = file_get_contents("Templates/changeuser.html");

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

        
        <a class="dropdown-item" href="indexuser.php?filtro=ida" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Consulta los usuarios existentes</strong></a>';

        //Inicializando la variable de la barra de navegación//

        $nav = file_get_contents("Templates/navuser.html");

        $nav = preg_replace('/--actions--/', $actions, $nav);

        //Retornando la barra de navegación completa//

        return $nav;

    }

    //Función para llamar a la plantilla de la cabecera de la página de inicio//

    function GetHeader()
    {
        //Asignando la variable para mostrar el encabezado de la página (Nombre y pertenencia)//

        $header = file_get_contents("Templates/headeruser.html");

        //Retornando el encabezado completo barra de navegación completa//

        return $header;

    }

    //Función para llamar a la plantilla de las alertas//

    function GetAlert()
    {

        //Variable global de conexión//

        global $cnx;

        $alert = "";

        //Variables de los datos a ingresar limpiando el código de PHP y HTML para ingresar valores limpios a la base de datos//

        $idusuario = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['iduser'], ENT_QUOTES)));
        
        $nombreusuario = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nombreusuario"], ENT_QUOTES)));

        $tipousuario = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["tipousuario"], ENT_QUOTES)));

        $clave = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["contrausuario"], ENT_QUOTES)));

        $clave2 = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["contrausuario2"], ENT_QUOTES)));

        $usuario = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['usuariotxt'], ENT_QUOTES)));

        $estado = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['estadousuario'], ENT_QUOTES)));

        if($clave == $clave2)
        {

            //Actualización de un registro//

        $update = mysqli_query($cnx, "UPDATE usuarios_clinica SET Nombre = '$nombreusuario', Tipo_Usuario = '$tipousuario', Clave = '$clave', Estado = '$estado', Usuario = '$usuario' WHERE ID_Usuario = $idusuario;") or die(mysqli_error($cnx));

        //Si la actualización de datos fue exitosa y si un número mayor de cero filas fueron afectadas dentro de la tabla Categoria//
            
        if($update)
        {
            //Se envía la alerta específicada en la cabecera//

            header("Location: changeuser.php?iduser=".$idusuario."&acc=OK");

        }

        else
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡El nuevo registro no pudo guardarse!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

            </div>';
        }

        //Cerrando Resultset//

        mysqli_free_result($update);

        }

        
        else
        {

            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡Las contraseñas no coinciden! Debes reintentar.</center></strong>
        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          
            <span aria-hidden="true">&times;</span>
        
            </button>

            </div>'; 

        }

        //Devolviendo la alerta según el resultado de las operaciones

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

        $idusuario = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['iduser'], ENT_QUOTES)));

        //Si la consulta retorna valores//

        $sql = mysqli_query($cnx, "SELECT * FROM usuarios_clinica WHERE ID_Usuario = $idusuario");
        
        if(mysqli_num_rows($sql) > 0)
        {
            //Asignación de valores de la tabla a las variables locales//

            $row = mysqli_fetch_array($sql);

            $nombreusuario = $row['Nombre'];

            $clave = $row['Clave'];

            $usuario = $row['Usuario'];

            //Validación para posibles estados//

            //Estado Activo//

            if($estado = $row['Estado'] == "A")
            {
                $estado = '<option value = "">Elige un estado</option>

                <option value = "A" class = "bg-dark" selected>Activo</option>

                <option value = "I" class = "bg-dark">Inactivo</option>';
            }

            //Estado inactivo//

            else if($estado = $row['Estado'] == "I")
            {
                $estado = '<option value = "">Elige un estado</option>

                <option value = "A" class = "bg-dark">Activo</option>

                <option value = "I" class = "bg-dark" selected>Inactivo</option>';
            }

            //Cargo del registro a editar//

            //Si es regente//

            if($tipousuario = $row['Tipo_Usuario'] == "R")
            {
                $tipousuario = '

                <option value = "R" class = "bg-dark" selected>Regente</option>

                <option value = "L" class = "bg-dark">Laboratorista</option>

                <option value = "S" class = "bg-dark">Secretario/a</option>';
            }

            //Si es laboratorista//

            else if($tipousuario = $row['Tipo_Usuario'] == "L")
            {
                $tipousuario = '

                <option value = "R" class = "bg-dark">Regente</option>

                <option value = "L" class = "bg-dark" selected>Laboratorista</option>

                <option value = "S" class = "bg-dark">Secretario/a</option>';
            }

            //Si es secretario//

            else
            {

                $tipousuario = '

                <option value = "R" class = "bg-dark">Regente</option>

                <option value = "L" class = "bg-dark">Laboratorista</option>

                <option value = "S" class = "bg-dark" selected>Secretario/a</option>';

            }

            //Formulario a mostrar para la modificación de registros//

            $form = '

<div class = "form-group">

<div class="container">

        <div class="row">

             <div id = "idinsumo" class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
    
             <p><strong>ID del usuario</strong></p>

             <!-- Entrada de un cajón numérico para el ID del paciente -->

             <center><div>

             <input type = "number" style = "background-color: #000000d0;" class = "form-control text-light" name = "iduser" value = ' . $idusuario . ' readonly>

         </div></center>

                         </div>

                <div class="col">

                

                </div>

            <div class="col"> 

            </div>

            </div>

                </div>

    <div class="row">

      <div class="col-sm">

        <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
            
            <!-- Entrada de un cajón de texto para el nombre del insumo -->

            <div class>

                <p><strong>Nombre del usuario</strong></p>

                <input type = "text" size="200" maxlength="200" class = "form-control text-light" style = "background-color: #000000d0;" id = "nombreusuario" name = "nombreusuario" value = "'. $nombreusuario .'" required>

            </div>

        </div>

      </div>

      <div class="col-sm">

        <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
            
            <!-- Entrada de un cajón de selección para el estado -->

            <div>
                
                <p><strong>Selecciona el estado del usuario</strong></p>

                <select class="form-control text-light" style = "background-color: #000000d0;" id = "estadousuario" name = "estadousuario" required placeholder = "Elige un estado">'

                . $estado . '

                </select>
              
            </div>

        </div>

      </div>

    </div>

    <div class="row">

      <div class="col-sm">

        <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">

            <div class>

                <div>
                
                    <p><strong>Selecciona su cargo</strong></p>

                    <select class="form-control text-light" style = "background-color: #000000d0;" id = "tipousuario" name = "tipousuario" required placeholder = "Elige un estado">

                    '

                    . $tipousuario . '

                    </select>
                  
                </div>

            </div>

        </div>

      </div>

      <div class="col-sm">

        <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
            
            <div>
                
                <p><strong>Ingresa el nombre de usuario</strong></p>

                <input type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "usuariotxt" name = "usuariotxt" value = "'

                . $usuario . '" required>
              
            </div>

        </div>

      </div>

    </div>

    <div class="row">

      <div class="col-sm">

        <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
            
            <!-- Entrada de un cajón de texto para el nombre del producto -->

            <div class>

                <p><strong>Ingresa una contraseña</strong></p>

                <input size="20" maxlength="20" type = "password" class = "form-control text-light" style = "background-color: #000000d0;" id = "contrausuario" name = "contrausuario" value = "' . $clave . '">

            </div>

        </div>

      </div>

      <div class="col-sm">

        <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
            
            <!-- Entrada de un cajón de selección para el estado -->

            <div class>

                <p><strong>Repite la contraseña</strong></p>

                <input size="20" maxlength="20" type = "password" class = "form-control text-light" style = "background-color: #000000d0;" id = "contrausuario2" name = "contrausuario2" value = "' . $clave . '">

            </div>

        </div>

      </div>

    </div>

      </div>

    </div>
  
<!-- Grupo de botones -->

<center><div class = "container text-white" style = "background-color: rgba(255, 255, 255, 0);">
    
    <div class="row">

      <div class="col">
        
      <button type="submit" name = "save" id = "save" title = "Modifica los datos requeridos del usuario." class="btn btn-primary">Modificar el registro <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              
        <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>

      </div>

      <div class="col-md">

      <a class="btn btn-light" type = "back" href="indexuser.php?filtro=ida" title = "Regresa a la página anterior.">Regresar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
           
      <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
    
      </svg> </a>

      </div>

    </div>

</div></center>

<br>

</form>';

         //Cerrando Resultset//

         mysqli_free_result($sql);

          return $form;
          
        }

    }


?>