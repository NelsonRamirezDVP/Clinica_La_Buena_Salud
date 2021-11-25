<?php

    /* Resolución de Parcial #2: Sistema de Log-In con implementaciones de seguridad, manejo de variables de sesión, AJAX y demás tecnologías desarrollado en PHP y MySQL -->

    Base de datos utilizada: empresa

    Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)

    Archivo PHP para la página de inicio de sesión (Versión de archivo 1.0) */


    //Validación de recepción de acciones en el lado del cliente para mostrar las demás partes del contenido del Log In//

    //Recepción de datos desde el formulario ubicado en login.html//

    //Recibiendo el valor del usuario a través de un operador ternario desde su cajón de texto en login.html//

    $usuario = (isset($_REQUEST["txtusuario"]) ? $_REQUEST["txtusuario"] : '');

    //Recibiendo el valor de la clave o contraseña a través de un operador ternario desde su cajón de texto en login.html//

    $clave = (isset($_REQUEST["txtclave"]) ? $_REQUEST["txtclave"] : '');

    //Inclusión de la conexión a la base de datos//

    require_once "Database/dbcon.php";


    //Métodos y funciones para iniciar sesión//

    //Método para iniciar sesión//

    function GetAcceso()
    {

        //Conexión y validación a la base de datos "empresa" en MySQL//

        //Variable de conexión global//

        global $cnx;

        //Variable de la alerta//


        //Obteniendo el usuario desde el formulario//

        $usuario = mysqli_real_escape_string($cnx,(strip_tags($_REQUEST["txtusuario"],ENT_QUOTES)));

        //Obteniendo el usuario desde el formulario//

        $clave = mysqli_real_escape_string($cnx,(strip_tags($_REQUEST["txtclave"],ENT_QUOTES)));

        //Instrucción SQL utilizada para comprobar si hay datos existentes de usuario y contraseña en la base de datos//

        $query = mysqli_query($cnx, "SELECT * FROM usuarios_clinica WHERE Usuario = '$usuario' AND Clave = '$clave';");

        //Cuando no se encuentra ningún registro coincidente//

        if(mysqli_num_rows($query) == 0)
        {   
            //Envio de respuesta en caso de no haber encontrado coincidencias a AJAX//

            //El estado de la sesión se vuelve vacío//

            $_SESSION['sesion'] = "";

            echo "fracaso";
        }

        //Cuando se encuentra un registro coincidente//

        else
        {   
            //Inicializando las variables de sesión//

            session_start();

            //Obteniendo el tipo de usuario que ha accedido a la aplicación//

            $query = mysqli_query($cnx, "SELECT * FROM usuarios_clinica WHERE Usuario = '$usuario' AND Clave = '$clave';");

            //Asociando el campo Tipo_Usuario para obtener el tipo y mostrarlo en la aplicación//

            $row = mysqli_fetch_assoc($query);

            if($row['Tipo_Usuario'] == "R")
            {
                //Si el tipo de usuario es un regente//

                //La variable de sesión del usuario será del departamento de gerencia//

                $_SESSION['tusuario'] = "Departamento de Regencia";

                $_SESSION['opcion1'] = '<a class="dropdown-item text-dark" href="indexinsumos.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar el inventario de insumos</strong></a>';

                $_SESSION['opcion2'] = '<a class="dropdown-item text-dark" href="indexexam.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar la información de los examenes disponibles</strong></a>';

                $_SESSION['opcion3'] = '<a class="dropdown-item text-dark" href="indexpat.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar la información de los pacientes</strong></a>';

                $_SESSION['opcion4'] = '<a class="dropdown-item text-dark" href="indexres.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar los resultados de los examenes</strong></a>';

                $_SESSION['opcion5'] = '<a class="dropdown-item text-dark" href="indexuser.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar los usuarios del sistema</strong></a>';

                $_SESSION['cargo'] = 'regente';

            }

            if($row['Tipo_Usuario'] == "S")
            {
                //Si el tipo de usuario es una secretaria//

                //La variable de sesión del usuario será de la secretaría de la clínica//

                $_SESSION['tusuario'] = "Secretaría de la Clínica";

                $_SESSION['opcion1'] = '<a class="text-dark dropdown-item" title = "No tienes permitido hacer esto." href="notauthorized.html" _msthash="956839" _msttexthash="180622" _mstvisible="4">Administrar el inventario de insumos</a>';

                $_SESSION['opcion2'] = '<a class="dropdown-item text-dark" title = "No tienes permitido hacer esto." href="notauthorized.html" _msthash="956839" _msttexthash="180622" _mstvisible="4">Administrar la información de los examenes disponibles</a>';

                $_SESSION['opcion3'] = '<a class="dropdown-item text-dark" href="indexpat.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar la información de los pacientes</strong></a>';

                $_SESSION['opcion4'] = '<a class="dropdown-item text-dark" title = "No tienes permitido hacer esto." href="notauthorized.html" _msthash="956839" _msttexthash="180622" _mstvisible="4">Administrar los resultados de los examenes</strong>';

                $_SESSION['opcion5'] = '<a class="dropdown-item text-dark" title = "No tienes permitido hacer esto." href="notauthorized.html" _msthash="956839" _msttexthash="180622" _mstvisible="4">Administrar los usuarios del sistema</a>';
                
                $_SESSION['cargo'] = 'secretario/a';
            }

            if($row['Tipo_Usuario'] == "L")
            {
                //Si el tipo de usuario es un empleado del área de laboratorios//

                //La variable de sesión del usuario será del área de laboratorios//

                $_SESSION['tusuario'] = "Área de Laboratorios";

                $_SESSION['opcion1'] = '<a class="text-dark dropdown-item" href="indexinsumos.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar el inventario de insumos</strong></a>';

                $_SESSION['opcion2'] = '<a class="text-dark dropdown-item" href="indexexam.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar la información de los examenes disponibles</strong></a>';
                
                $_SESSION['opcion3'] = '<a class="dropdown-item text-dark" title = "No tienes permitido hacer esto." href="notauthorized.html" _msthash="956839" _msttexthash="180622" _mstvisible="4">Administrar la información de los pacientes</a>';

                $_SESSION['opcion4'] = '<a class="dropdown-item text-dark" href="indexresult.php?filtro=ida" _msthash="956839" _msttexthash="180622" _mstvisible="4"><strong>Administrar los resultados de los examenes</strong></a>';

                $_SESSION['opcion5'] = '<a class="dropdown-item text-dark" title = "No tienes permitido hacer esto." href="notauthorized.html" _msthash="956839" _msttexthash="180622" _mstvisible="4">Administrar los usuarios del sistema</a>';

                $_SESSION['cargo'] = 'laboratorista';
            }


            //Variable de sesión de estado Activo/Inactivo//

            if($row['Estado'] == "A")
            {
                //Si el usuario tiene su estado como activo//

                $_SESSION['estado'] = "Activo";

            }

            else
            {

                //Si el usuario tiene su estado como activo//

                $_SESSION['estado'] = "Inactivo";

            }


            //Cargamos las variables de sesion con los datos obtenidos de la tabla de usuarios//

            //Variable de sesión del usuario y del nombre y el estado de la sesión//

            $_SESSION['usuario'] = $row['Usuario'];

            $_SESSION['nombre'] = $row['Nombre'];
            
            $_SESSION['sesion'] = 1;


            //Envío de respuesta en caso de haber encontrado coincidencias a AJAX//

            echo "exito";
            
        }

        //Cerrando Resultset//

        mysqli_free_result($query);

        //Devolviendo la alerta según el resultado de las operaciones

    }

    //Ejecución de la función de validación//

    GetAcceso();

?>