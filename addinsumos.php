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

        $pagina = file_get_contents("Templates/addinsumos.html");

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
        
        $pagina = file_get_contents("Templates/addinsumos.html");

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

        $actions = '<a class="dropdown-item" href="addinsumos.php" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Ingresa un nuevo registro</strong>

        
        <a class="dropdown-item" href="indexinsumos.php?filtro=ida" _msthash="1257802" _msttexthash="93353" _mstvisible="1"><strong>Consulta los insumos existentes</strong></a>';

        //Inicializando la variable de la barra de navegación//

        $nav = file_get_contents("Templates/navinsumos.html");

        $nav = preg_replace('/--actions--/', $actions, $nav);

        //Retornando la barra de navegación completa//

        return $nav;

    }

    //Función para llamar a la plantilla de la cabecera de la página de inicio//

    function GetHeader()
    {
        //Asignando la variable para mostrar el encabezado de la página (Nombre y pertenencia)//

        $header = file_get_contents("Templates/headerinsumos.html");

        //Retornando el encabezado completo barra de navegación completa//

        return $header;

    }

    //Función para llamar a la plantilla de las alertas//

    function GetAlert()
    {
        global $cnx;

        //Generación automática del ID//

        $nombreinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nombreinsumo"], ENT_QUOTES)));

        $sql = mysqli_query($cnx, "SELECT ID_Insumo FROM inventario_insumos ORDER BY ID_Insumo DESC LIMIT 1");
        
        if(mysqli_num_rows($sql) > 0)
        {
            $row = mysqli_fetch_array($sql);

            $inicial = substr($nombreinsumo, 0, 2);

            $inicial = strtoupper($inicial);

            $num = $row['ID_Insumo'];

            if($num < 10)
            {

                $ID = "00" . $num . $inicial;

            }

            else if($num >= 10)
            {

                $ID = "0" . $num . $inicial;
    
            }

            else if($num >= 100)
            {

                $ID = $num . $inicial;
    
            }

        }

        else
        {

            $inicial = substr($nombreinsumo, 0, 2);

            $inicial = strtoupper($inicial);

            $ID = "000" . $inicial; 

        }

        //Imprimiendo el ID (Código de insumo obtenido) esto para prueba//

        //printf($ID);


        //Variable global de conexión//

        global $cnx;

        $alert = "";

        //Variables de los datos a ingresar limpiando el código de PHP y HTML para ingresar valores limpios a la base de datos//

        $nombreinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nombreinsumo"], ENT_QUOTES)));

        $estadoinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["estadoinsumo"], ENT_QUOTES)));

        $descinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["descinsumo"], ENT_QUOTES)));

        $cantinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['cantinsumo'], ENT_QUOTES)));

        $costoinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['costoinsumo'], ENT_QUOTES)));

        $comprainsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["comprainsumo"], ENT_QUOTES)));

        $medidainsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["medidainsumo"], ENT_QUOTES)));

        $proveedorinsumo = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["proveedorinsumo"], ENT_QUOTES)));

        //Cuando un usuario agrega un registro//

        $insert = mysqli_query($cnx, "INSERT INTO inventario_insumos (Cod_Insumo, Nombre_Insumo, Descripcion_Insumo, Cantidad_Insumo, Costo_Insumo, Compra_Insumo, Unidad_Medida, Proveedor_Insumo, Estado_Insumo) VALUES ('$ID', '$nombreinsumo', '$descinsumo', '$cantinsumo', '$costoinsumo', '$comprainsumo', '$medidainsumo', '$proveedorinsumo', '$estadoinsumo')") or die(mysqli_error($cnx));

        //Si la inserción de datos fue exitosa y si un número mayor de cero filas fueron afectadas dentro de la tabla Categoria//
            
        if(mysqli_affected_rows($cnx) > 0)
        {

            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            
            <strong><center>¡El nuevo insumo se agregó exitosamente!</center></strong>
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              
            <span aria-hidden="true">&times;</span>
            
            </button>

            </div>';

        }

        else
        {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            
            <strong><center>¡El insumo no pudo guardarse!</center></strong>
            
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