<?php

    //Sistema de Log-In con implementaciones de seguridad, manejo de variables de sesión, AJAX y demás tecnologías desarrollado en PHP y MySQL//

    //Base de datos utilizada: control_clinica//

    //Desarrollado por Nelson Alexander Brizuela Ramírez (BR100718)//

    //Archivo de configuración de conexión para MySQL Server 5.5 (Versión de archivo 1.0)//


    //Cadena para posibilitar la conexión a la base de datos solicitando las constantes de conexión//

    //Llamado de las variables de conexión del archivo "config.php"//

    require_once "config.php";

    //Definición de la variable de conexión (cnx) para MySQL Server 5.5 que contiene la ruta y las constantes//

    $cnx = mysqli_connect(host, user, password, database, port);


    //Evaluación del resultado de la conexión a la base de datos//

    //Si la conexión retorna un error//

    if($cnx -> connect_errno)
    {
        //Proceso dado de baja y retorno de un mensaje de error//

        die("Ha habido un error al intentar conectar a la base de datos. No se ha podido establecer una conexión con MySQL/MariaDB debido al error " . mysqli_error($cnx));

    }

    else
    {   
        //Si se realiza exitosamente la conexión, se procede a seleccionar la base de datos a trabajar a traves de una variable y el metodo Select Database que almacena la ruta (cnx) y la constante del nombre de la base (database)//

        $db = mysqli_select_db($cnx, database);

        //Evaluando el resultado de la selección de la base de datos en el servidor//

        
        if($db == 0)
        {
            //Si la selección de la base de datos retorna el valor 0, es decir que ha habido un error y se debe dar de baja el proceso y mostrar un mensaje de error//
       
            die("No se ha podido seleccionar la base de datos: " . database);
        }

        //Si el resultado de la operación es 1, se ha conectado exitosamente a la base de datos//

    }

?>