<?php

    //Control de insumos para la clínica de laboratorios//

    //El presente programa ha sido realizado bajo el patrón de diseño estructural para realizar un mantenimiento (inserción, eliminación, comsulta y actualización de datos) a una tabla dentro de una base de datos, en específico a los pacientes de la clínica//

    //Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)//

    //Archivo PHP de acceso principal para el usuario/Archivo de recepción de peticiones (Versión de archivo 1.0)//


    //Inclusión de la conexión a la base de datos//

    require_once "Database/dbcon.php";

    //Validación de recepción de acciones en el lado del cliente para mostrar las demás partes del contenido//


    if(isset($_REQUEST['acc']) == '')
    {

        //Asignación del valor del contenido de las plantillas//

        $pagina = file_get_contents("Templates/indexpat.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--alert--/', '', $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (data)//

        $pagina = preg_replace('/--data--/', GetData(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (actions)//

        $pagina = preg_replace('/--options--/', GetOptions(), $pagina);

        
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    else
    {
        //Si hay acción de edición, eliminación o inserción//
        
        $pagina = file_get_contents("Templates/indexpat.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--alert--/', GetAlert(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (data)//

        $pagina = preg_replace('/--data--/', GetData(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (actions)//

        $pagina = preg_replace('/--options--/', GetOptions(), $pagina);

        
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    //Creación de métodos para generar cada plantilla sobre la marcha y componer la página resultante//

    //Función para llamar a la plantilla de la barra de navegación//

    function GetNav()
    {

        //Variable para mostrar las opciones de la barra de navegación//

        $actions = '<a class="dropdown-item" id = "actions" href="addpat.php" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Ingresa un nuevo paciente</strong></a>';

        //Inicializando la variable de la barra de navegación//

        $nav = file_get_contents("Templates/navpat.html");

        $nav = preg_replace('/--actions--/', $actions, $nav);

        //Retornando la barra de navegación completa//

        return $nav;

    }

    //Función para llamar a la plantilla de la cabecera de la página de inicio//

    function GetHeader()
    {
        //Asignando la variable para mostrar el encabezado de la página (Nombre y pertenencia)//

        $header = file_get_contents("Templates/headerpat.html");

        //Retornando el encabezado completo barra de navegación completa//

        return $header;

    }

    //Función para llamar a la plantilla de las alertas//

    function GetAlert()
    {

        //Variable global de conexión//

        global $cnx;

        $alert = "";

        //Validación de las posibles acciones del usuario//

        $idpat = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["idpat"], ENT_QUOTES)));

        //Cuando un usuario elimina un registro//

        $delete = mysqli_query($cnx, "DELETE FROM informacion_pacientes WHERE ID_Paciente = $idpat");

        //Validando la eliminación del registro//

        if($delete)
        {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            
            <strong><center>¡Eliminación realizada exitosamente!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

          </div>';
        }
        
        else
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡No se pudo eliminar este insumo!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

            </div>';

        }

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

    //Función para llamar a la plantilla de los datos de a mostrar en la tabla correspondientes a la tabla "Categorías" de la base de datos//

    function GetData()
    {
        //Mostrando los datos de la base, en la tabla de la página principal para la tabla "Categorías"//

        //Variable global de conexión alojada en dbcon.php//

        global $cnx;

        //Variable Data para almacenar los datos//

        $data = "";

        //Obteniendo la busqueda del cuadro//

        $busqueda = (isset($_REQUEST['busqueda'])) ? strtolower($_REQUEST['busqueda']) : NULL;

        if($busqueda == "")
        {
            $filtro = (isset($_REQUEST['filtro'])) ? strtolower($_REQUEST['filtro']) : NULL;

            if($filtro == "")
            {
                //Si el filtro está vacío//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Cod_Paciente ASC");
            }
        
            else if($filtro == "na")
            {
                //Si el filtro selecciona por nombre ascendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Nombre_Paciente ASC");
            }

            else if($filtro == "nd")
            {
                //Si el filtro selecciona por nombre descendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Cod_Paciente DESC");
            }

            else if($filtro == "na")
            {
                //Si el filtro selecciona por nombre ascendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Cod_Paciente ASC");
            }

            else if($filtro == "ida")
            {
                //Si el filtro selecciona por ID ascendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Cod_Paciente ASC");
            
            }

            else if($filtro == "idd")
            {
                //Si el filtro selecciona por ID descendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Cod_Paciente DESC");
            }

            if(mysqli_num_rows($sql) == 0)
            {
                //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos y configurando el valor de incremento en 1 para volver a empezar el conteo//

                $sql = mysqli_query($cnx, "ALTER TABLE informacion_pacientes AUTO_INCREMENT = 1");

                $data.= '<tr><td colspan = "13"><center>Lo sentimos... Pero no hay ningún dato que podamos mostrarte. ¡Prueba ingresando alguno!</center></td></tr>';
            
            }

            else
            {
                //Mostrar los datos por cada registro en la tabla y asignarles una posición en la muestra de la tabla principal//

                while($row = mysqli_fetch_assoc($sql))
                {
                    $filtro = "";

                    //Concatenando filas y columnas para cada valor//

                    //Columna ID_Categoria y Categoria//

                    $data.= '
                
                    <tr>
                
                    <td><center>' . $row['Cod_Paciente'] . '</center></td>

                    <td><center>' . $row['Nombre_Paciente'] . '</center></td>

                    <td><center>' . $row['Direccion_Residencia'] . '</center></td>

                    <td><center>' . $row['Telefono_Paciente'] . '</center></td>

                    <td>' . $row['Correo_Paciente'] . '</td>

                    <td><center>' . $row['DUI_Paciente'] . '</center></td>

                    <td><center>' . $row['Examen_Paciente'] . '</center></td>

                    <td><center>' . $row['Fecha_Examenes'] . '</center></td>

                    <td><center>' . $row['Med_Examen'] . '</center></td>';

                    //Columna Acciones (Botón para Editar y Eliminar)//

                    $data.= '</td>
                
                    <td>

                    <div class = "btn-group">

                    <a class="btn btn-primary btn-sm" onclick="return confirm(\'Estás por editar la información de este paciente. ¿Deseas continuar?\')" href="changepat.php?idpat=' . $row['ID_Paciente'] . '" title = "Puedes modificar este registro."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      
                    </svg></a>   

                    
                    <a class="btn btn-dark btn-sm" onclick="return confirm(\'Estás a punto de eliminar la información de este paciente. ¿Deseas eliminar el paciente cuyo ID es '. $row['Cod_Paciente'] . '?\')" href="indexpat.php?acc=delete&idpat=' . $row['ID_Paciente'] . '" title = "Puedes eliminar este registro."><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                   
                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                 
                    </svg> </a>

                    <div>
                
                    </td>

                    </tr>';
                }

            }

        }

        if($busqueda != "")
        {

            //Si el valor de búsqueda es correspondiente a una fecha//

            $date = "-";

            $fecha = strpos($busqueda, $date);

            //Validando la existencia del caracter "-"//

            if ($fecha === false) 
            {

                $busc = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE Nombre_Paciente = '$busqueda'");

                if(mysqli_num_rows($busc) == 0)
                {
                    //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos y configurando el valor de incremento en 1 para volver a empezar el conteo//
    
                    $data.= '<tr><td colspan = "13"><center>Lo sentimos... Pero no hay ningún dato que coincida con lo que buscas.</center></td></tr>';

                }

                else 
                {

                    $filtro = "";

                    while($row = mysqli_fetch_assoc($busc))
                    {

                        //Concatenando filas y columnas para cada valor//

                        //Columna ID_Categoria y Categoria//

                        $data.= '
                
                        <tr>
                
                        <td><center>' . $row['Cod_Paciente'] . '</center></td>

                        <td><center>' . $row['Nombre_Paciente'] . '</center></td>

                        <td><center>' . $row['Direccion_Residencia'] . '</center></td>

                        <td><center>' . $row['Telefono_Paciente'] . '</center></td>

                        <td>' . $row['Correo_Paciente'] . '</td>

                        <td><center>' . $row['DUI_Paciente'] . '</center></td>

                        <td><center>' . $row['Examen_Paciente'] . '</center></td>

                        <td><center>' . $row['Fecha_Examenes'] . '</center></td>

                        <td><center>' . $row['Med_Examen'] . '</center></td>';

                        //Columna Acciones (Botón para Editar y Eliminar)//

                        $data.= '</td>
                
                        <td>

                        <div class = "btn-group">

                        <a class="btn btn-primary btn-sm" onclick="return confirm(\'Estás por editar la información de este paciente. ¿Deseas continuar?\')" href="changepat.php?idpat=' . $row['ID_Paciente'] . '" title = "Puedes modificar este registro."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      
                        </svg></a>   

                    
                        <a class="btn btn-dark btn-sm" onclick="return confirm(\'Estás a punto de eliminar la información de este paciente. ¿Deseas eliminar el paciente cuyo ID es '. $row['Cod_Paciente'] . '?\')" href="indexpat.php?acc=delete&idpat=' . $row['ID_Paciente'] . '" title = "Puedes eliminar este registro."><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                   
                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                 
                        </svg> </a>

                        <div>
                
                        </td>

                        </tr>';

                    }      

                }
     
            } 

            else 
            {
               
                $busc = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE Fecha_Examenes = '$busqueda'");

                if(mysqli_num_rows($busc) == 0)
                {
                    //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos y configurando el valor de incremento en 1 para volver a empezar el conteo//
    
                    $data.= '<tr><td colspan = "13"><center>Lo sentimos... Pero no hay ningún dato que coincida con lo que buscas.</center></td></tr>';

                }

                else 
                {

                    $filtro = "";

                    while($row = mysqli_fetch_assoc($busc))
                    {

                        //Concatenando filas y columnas para cada valor//

                        //Columna ID_Categoria y Categoria//

                        $data.= '
                
                        <tr>
                
                        <td><center>' . $row['Cod_Paciente'] . '</center></td>

                        <td><center>' . $row['Nombre_Paciente'] . '</center></td>

                        <td><center>' . $row['Direccion_Residencia'] . '</center></td>

                        <td><center>' . $row['Telefono_Paciente'] . '</center></td>

                        <td>' . $row['Correo_Paciente'] . '</td>

                        <td><center>' . $row['DUI_Paciente'] . '</center></td>

                        <td><center>' . $row['Examen_Paciente'] . '</center></td>

                        <td><center>' . $row['Fecha_Examenes'] . '</center></td>

                        <td><center>' . $row['Med_Examen'] . '</center></td>';

                        //Columna Acciones (Botón para Editar y Eliminar)//

                        $data.= '</td>
                
                        <td>

                        <div class = "btn-group">

                        <a class="btn btn-primary btn-sm" onclick="return confirm(\'Estás por editar la información de este paciente. ¿Deseas continuar?\')" href="changepat.php?idpat=' . $row['ID_Paciente'] . '" title = "Puedes modificar este registro."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      
                        </svg></a>   

                    
                        <a class="btn btn-dark btn-sm" onclick="return confirm(\'Estás a punto de eliminar la información de este paciente. ¿Deseas eliminar el paciente cuyo ID es '. $row['Cod_Paciente'] . '?\')" href="indexpat.php?acc=delete&idpat=' . $row['ID_Paciente'] . '" title = "Puedes eliminar este registro."><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                   
                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                 
                        </svg> </a>

                        <div>
                
                        </td>

                        </tr>';

                    }      

                }

            }

            
        }

        return $data;
        
    }

    //Función para llamar a la plantilla de las opciones con los datos de la tabla//

    function GetOptions()
    {

        $options = "";

        //Utiizando operador ternario para mostrar las opciones del cajón de filtro//

        $filtro = (isset($_REQUEST['filtro'])) ? strtolower($_REQUEST['filtro']) : NULL;

        //Creando validación para mostrar las opciones//

        //Si se escoge el estado disponible//

        //Si se escoge nombre ascendente//

        if($filtro == "na")
        {
            $options = 

            //Opciones a mostrar//

            '<option value = "" class = "bg-dark">Selecciona...</option>
            
            <option value = "ida" class = "bg-dark">ID ascendente</option>
            
            <option value = "idd" class = "bg-dark">ID descendente</option>

            <option value = "na" class = "bg-dark" selected>Nombre ascendente</option>

            <option value = "nd" class = "bg-dark">Nombre descendente</option>';

        }

        //Si se escoge nombre descendente//

        else if($filtro == "nd")
        {
            $options = 

            //Opciones a mostrar//

            '
            <option value = "" class = "bg-dark">Selecciona...</option>
            
            <option value = "ida" class = "bg-dark">ID ascendente</option>
            
            <option value = "idd" class = "bg-dark">ID descendente</option>

            <option value = "na" class = "bg-dark">Nombre ascendente</option>

            <option value = "nd" class = "bg-dark" selected>Nombre descendente</option>';

        }

        //Si se escoge ID descendente//

        else if($filtro == "idd")
        {
            $options = 

            //Opciones a mostrar//

            '<option value = "" class = "bg-dark">Selecciona...</option>
            
            <option value = "ida" class = "bg-dark">ID ascendente</option>
            
            <option value = "idd" class = "bg-dark" selected>ID descendente</option>

            <option value = "na" class = "bg-dark">Nombre ascendente</option>

            <option value = "nd" class = "bg-dark">Nombre descendente</option>';

        }

        //Si se escoge ID ascendente//

        else if($filtro == "ida")
        {
            $options = 

            //Opciones a mostrar//

            '<option value = "" class = "bg-dark">Selecciona...</option>

            <option value = "ida" class = "bg-dark" selected>ID ascendente</option>
            
            <option value = "idd" class = "bg-dark">ID descendente</option>

            <option value = "na" class = "bg-dark">Nombre ascendente</option>

            <option value = "nd" class = "bg-dark">Nombre descendente</option>';

        }

        //Si no se escoge ninguna//

        else
        {
            $options = 

            '<option value = "" class = "bg-dark" selected>Selecciona...</option>

            <option value = "ida" class = "bg-dark">ID ascendente</option>
            
            <option value = "idd" class = "bg-dark">ID descendente</option>

            <option value = "na" class = "bg-dark">Nombre ascendente</option>

            <option value = "nd" class = "bg-dark">Nombre descendente</option>';

        }
        
        //Retornando las opciones//

        return $options;

    }

?>