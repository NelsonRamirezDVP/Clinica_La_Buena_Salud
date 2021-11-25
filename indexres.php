<?php

    //Control de insumos para la clínica de laboratorios//

    //El presente programa ha sido realizado bajo el patrón de diseño estructural para realizar un mantenimiento (inserción, eliminación, comsulta y actualización de datos) a una tabla dentro de una base de datos, en específico a la tabla Categoria en la base de datos "empresa"//

    //Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)//

    //Archivo PHP de acceso principal para el usuario/Archivo de recepción de peticiones (Versión de archivo 1.0)//


    //Inclusión de la conexión a la base de datos//

    require_once "Database/dbcon.php";

    //Validación de recepción de acciones en el lado del cliente para mostrar las demás partes del contenido//


    if(isset($_REQUEST['acc']) == '')
    {

        //Asignación del valor del contenido de las plantillas//

        $pagina = file_get_contents("Templates/indexres.html");

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
        
        $pagina = file_get_contents("Templates/indexres.html");

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

        $actions = '';

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

        //Variable global de conexión//

        global $cnx;

        $alert = "";

        //Validación de las posibles acciones del usuario//

        $nompaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nameres"], ENT_QUOTES)));

        //Cuando un usuario elimina un registro//

        $delete = mysqli_query($cnx, "DELETE FROM resultado_examenes WHERE Nombre_Paciente = '$nompaciente'");

        //Validando la eliminación del registro//

        if($delete)
        {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            
            <strong><center>¡Se han eliminado todas las boletas relacionadas a este paciente! Debes crear una nueva.</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

          </div>';
        }
        
        else
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡No se pudieron eliminar las boletas! Deberías intentar nuevamente.</center></strong>
            
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

        $data = "";

        //Variable Data para almacenar los datos//

        $busqueda = (isset($_REQUEST['busqueda'])) ? strtolower($_REQUEST['busqueda']) : NULL;

        if($busqueda == "")
        {

            $filtro = (isset($_REQUEST['filtro'])) ? strtolower($_REQUEST['filtro']) : NULL;

            if($filtro == "")
            {
                //Si el filtro selecciona por estado disponible//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY ID_Paciente ASC");
            }
        
            else if($filtro == "na")
            {
                //Si el filtro selecciona por nombre ascendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Nombre_Paciente ASC");
            }

            else if($filtro == "nd")
            {
                //Si el filtro selecciona por nombre descendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY Nombre_Paciente DESC");
            }

            else if($filtro == "ida")
            {
                //Si el filtro selecciona por ID descendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY ID_Paciente ASC");
            }

            else if($filtro == "idd")
            {
                //Si el filtro selecciona por ID descendente//

                $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes ORDER BY ID_Paciente DESC");
            }

            if(mysqli_num_rows($sql) == 0)
            {
                //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos//

                $sql = mysqli_query($cnx, "ALTER TABLE informacion_pacientes AUTO_INCREMENT = 1");

                $data.= '<tr><td colspan = "13"><center>Lo sentimos... Pero no hay ningún dato que podamos mostrarte. ¡Prueba ingresando alguno!</center></td></tr>';
            }

            else
            {
                //Mostrar los datos por cada registro en la tabla y asignarles una posición en la muestra de la tabla principal//

                while($row = mysqli_fetch_assoc($sql))
                {

                    //Concatenando filas y columnas para cada valor//

                    //Columna ID_Categoria y Categoria//

                    $data.= '
                
                    <tr>
                
                    <td><center>' . $row['Cod_Paciente'] . '</center></td>

                    <td><center>' . $row['Nombre_Paciente'] . '</center></td>

                    <td><center>' . $row['Correo_Paciente'] . '</center></td>

                    <td><center>' . $row['Telefono_Paciente'] . '</center></td>

                    <td><center>' . $row['Fecha_Examenes'] . '</center></td>';

                    $data.= '
                
                    <td><center>

                    <div class = "btn-group bg">

                    <label>

                    <a class="btn btn-warning btn-sm" onclick="return confirm(\'Estás a punto de agregar una boleta de resultados para este paciente. ¿Deseas crear un registro de boleta del paciente '. $row['Nombre_Paciente'] . '?\')" href="addres.php?&idpaciente=' . $row['ID_Paciente'] . '" title = "Puedes agregar un resultado."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                    
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
                  
                    </svg></a>  
                    
                    </label> 


                    <label>

                    <a class="btn btn-primary btn-sm" onclick="return confirm(\'Estás por editar a este registro de resultados. ¿Deseas continuar?\')" href="changeres.php?nameres=' . $row['Nombre_Paciente'] . '" title = "Puedes modificar este registro de resultados."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      
                    </svg></a>   

                    </label>

                    <label>

                    <a class="btn btn-dark btn-sm" onclick="return confirm(\'Estás a punto de eliminar las boletas adjuntas a este paciente. ¿Deseas eliminar el resultado del paciente '. $row['Nombre_Paciente'] . '?\')" href="indexres.php?acc=delete&nameres=' . $row['Nombre_Paciente'] . '" title = "Puedes eliminar las boletas de resultados adjuntas a este paciente, sin eliminarlo."><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                   
                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                 
                    </svg> </a>  
                    
                    </label> 


                    <label>

                    <a class="btn btn-info btn-sm" role="button" title = "Descarga los resultados." href="../Assets/PDF/Resultados_CLBS.php?nameres=' . $row['Nombre_Paciente'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                    
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z"/>
                  
                    </svg></a>

                    </label>


                    <div>
                
                    </center></td>

                    </tr>';

                }
            }   

        }

        if($busqueda != "")
        {
            //Si el filtro está vacío//

            $busc = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE Nombre_Paciente = '$busqueda'");

            if(mysqli_num_rows($busc) == 0)
            {
                //Mostrando un mensaje en caso de no haber valores en la tabla dentro de la base de datos y configurando el valor de incremento en 1 para volver a empezar el conteo//
    
                $data.= '<tr><td colspan = "13"><center>Lo sentimos... Pero no hay ningún dato que coincida con lo que buscas.</center></td></tr>';

            }

            else
            {
                //Mostrar los datos por cada registro en la tabla y asignarles una posición en la muestra de la tabla principal//

                while($row = mysqli_fetch_assoc($busc))
                {

                    //Concatenando filas y columnas para cada valor//

                    //Columna ID_Categoria y Categoria//

                    $data.= '
                
                    <tr>
                
                    <td><center>' . $row['Cod_Paciente'] . '</center></td>

                    <td><center>' . $row['Nombre_Paciente'] . '</center></td>

                    <td><center>' . $row['Correo_Paciente'] . '</center></td>

                    <td><center>' . $row['Telefono_Paciente'] . '</center></td>

                    <td><center>' . $row['Fecha_Examenes'] . '</center></td>';

                    $data.= '
                
                    <td><center>

                    <div class = "btn-group bg">

                    <label>

                    <a class="btn btn-warning btn-sm" onclick="return confirm(\'Estás a punto de agregar una boleta de resultados para este paciente. ¿Deseas crear un registro de boleta del paciente '. $row['Nombre_Paciente'] . '?\')" href="addres.php?acc=add&idpaciente=' . $row['ID_Paciente'] . '" title = "Puedes agregar un resultado."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                    
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
                  
                    </svg></a>  
                    
                    </label> 

                    <label>

                    <a class="btn btn-primary btn-sm" onclick="return confirm(\'Estás por editar a este registro de resultados. ¿Deseas continuar?\')" href="changeres.php?nameres=' . $row['Nombre_Paciente'] . '" title = "Puedes modificar este registro de resultados."><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      
                    </svg></a>   

                    </label>

                    <label>

                    <a class="btn btn-dark btn-sm" onclick="return confirm(\'Estás a punto de eliminar este registro de resultados. ¿Deseas eliminar el resultado del paciente '. $row['Nombre_Paciente'] . '?\')" href="indexres.php?acc=delete&nameres=' . $row['Nombre_Paciente'] . '" title = "Puedes eliminar este registro."><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                   
                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                 
                    </svg> </a>  
                    
                    </label> 


                    <label>

                    <a class="btn btn-info btn-sm" role="button" title = "Descarga los resultados." href="../Assets/PDF/Resultados_CLBS.php?nameres=' . $row['Nombre_Paciente'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                    
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z"/>
                  
                    </svg></a>

                    </label>


                    <div>
                
                    </center></td>

                    </tr>';

                }
            } 
              
        }        

        //Imprimiendo todos lo datos recolectados para mostrarlos en la tabla principal//

        return $data;
    }
    


    //Función para llamar a la plantilla de las opciones con los datos de la tabla//

    function GetOptions()
    {

        $options = "";

        //Utiizando operador ternario para mostrar las opciones del cajón de filtro//

        $filtro = (isset($_REQUEST['filtro'])) ? strtolower($_REQUEST['filtro']) : NULL;

        //Creando validación para mostrar las opciones//

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

            '<option value = "" class = "bg-dark">Selecciona...</option>
            
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