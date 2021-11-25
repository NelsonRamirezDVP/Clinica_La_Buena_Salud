<?php

    //Adición de insumos dentro del control de la clinica de laboratorios//

    //El presente programa ha sido realizado bajo el patrón de diseño estructural para realizar un mantenimiento (inserción, eliminación, comsulta y actualización de datos) a una tabla dentro de una base de datos, en específico a la tabla Categoria en la base de datos "empresa"//

    //Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)//

    //Archivo PHP de la página para agregar nuevos registros (Versión de archivo 1.0)//


    //Inclusión de la conexión a la base de datos//

    require_once "Database/dbcon.php";

    //Validación de recepción de acciones en el lado del cliente para mostrar las demás partes del contenido en la página para agregar registros//
    
    if(isset($_REQUEST['add']) == '')
    {

        //Asignación del valor del contenido de las plantillas//

        $pagina = file_get_contents("Templates/addpat.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--alert--/', '', $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);

        
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    else
    {
        //Si hay acción de edición, eliminación o inserción//
        
        $pagina = file_get_contents("Templates/addpat.html");

        //Reemplazando el valor de las páginas por las plantillas (nav.html)//

        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (header.html)//

        $pagina = preg_replace('/--header--/', GetHeader(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (alert.html)//

        $pagina = preg_replace('/--alert--/', GetAlert(), $pagina);

        //Reemplazando el valor de las páginas por las plantillas (year)//

        $pagina = preg_replace('/--year--/', GetYear(), $pagina);
  
        //Impresión de la página construida a base de las plantillas//

        echo $pagina;

    }

    //Creación de métodos para generar cada plantilla sobre la marcha y componer la página resultante//

    //Función para llamar a la plantilla de la barra de navegación//

    function GetNav()
    {

        //Variable para mostrar las opciones de la barra de navegación//

        $actions = '<a class="dropdown-item" href="addpat.php" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Ingresa un nuevo registro</strong>

        
        <a class="dropdown-item" href="indexpat.php?filtro=ida" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Consulta los pacientes existentes</strong></a>';

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
        global $cnx;

        //Generación automática del ID//

        $nombrepaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nombrepaciente"], ENT_QUOTES)));

        $sql = mysqli_query($cnx, "SELECT ID_Paciente FROM informacion_pacientes ORDER BY ID_Paciente DESC LIMIT 1");
        
        if(mysqli_num_rows($sql) > 0)
        {
            $row = mysqli_fetch_array($sql);

            $nombre = substr($nombrepaciente, 0, 3);

            $nombre = strtoupper($nombre);

            $num = $row['ID_Paciente'];

            if($num < 10)
            {

                $ID = "00" . $num . $nombre;

            }

            else if($num >= 10)
            {

                $ID = "0" . $num . $nombre;
    
            }

            else if($num >= 100)
            {

                $ID = $num . $nombre;
    
            }

        }

        else
        {

            $nombre = substr($nombrepaciente, 0, 3);

            $nombre = strtoupper($nombre);

            $ID = "000" . $nombre; 

        }

        //Imprimiendo el ID (Código de insumo obtenido) esto para prueba//

        //printf($ID);


        //Variable global de conexión//

        global $cnx;

        $alert = "";

        //Variables de los datos a ingresar limpiando el código de PHP y HTML para ingresar valores limpios a la base de datos//

        $nombrepaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nombrepaciente"], ENT_QUOTES)));

        $dirresidencia = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["dirresidencia"], ENT_QUOTES)));

        $telefono = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['telefono'], ENT_QUOTES)));

        $correopaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['correopaciente'], ENT_QUOTES)));

        $fechaex = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['fechaex'], ENT_QUOTES)));

        $duipaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["duipaciente"], ENT_QUOTES)));

        $medpaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["medpaciente"], ENT_QUOTES)));

        //Creando un arreglo para los examenes a solicitar de parte del usuario//

        $examenes = array();

        //Validando que existe y se ha creado una variable//

        //La variable de examenes recupera el valor obtenido por el método POST//

        if(!empty($_POST['TipoExamen']))
        {

            $examenes = $_POST['TipoExamen'];

            $selected = join(", ", $examenes);

            //echo $selected;

        }
        
        else
        {

            //Si no, la variable de examen se debe encontrar vacía//

            $examenes = [];

            //Si el usuario no ha seleccionado níngún examen//

            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡Debes seleccionar al menos un examen!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

            </div>';

            return $alert;

    
        }

        $insert = mysqli_query($cnx, "INSERT INTO informacion_pacientes (Cod_Paciente, Nombre_Paciente, Direccion_Residencia, Telefono_Paciente, Correo_Paciente, DUI_Paciente, Examen_Paciente, Fecha_Examenes, Med_Examen) VALUES ('$ID', '$nombrepaciente', '$dirresidencia', '$telefono', '$correopaciente', '$duipaciente', '$selected', '$fechaex', '$medpaciente')") or die(mysqli_error($cnx));
            
        if(mysqli_affected_rows($cnx) > 0)
        {

            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            
            <strong><center>¡El nuevo paciente se agregó exitosamente!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

            </div>';

        }

        else
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡El paciente no pudo guardarse!</center></strong>
            
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

?>