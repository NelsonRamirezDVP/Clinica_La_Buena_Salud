<?php

  /* Archivo PHP para la página de inicio posterior al ingreso (Versión de archivo 1.0) */


  //Recibiendo los datos del usuario y contraseña enviados por el formulario//

  //Recibiendo el usuario del cajón de texto//

  $usuario = (isset($_REQUEST['txtusuario']) ? $_REQUEST['txtusuario'] : '');

  //Recibiendo el usuario del cajón de texto//

  $clave = (isset($_REQUEST['txtclave']) ? $_REQUEST['txtclave'] : '');

  //Iniciando la sesión//

  session_start();


  //Inclusión de la conexión a la base de datos//

  require_once "Database/dbcon.php";


  //Si se presiona el botón para cerrar sesión//

    if(isset($_REQUEST['acc']) == 'salir')
    {   

        //Se reinician por completo las variables de sesión//

        session_start();

        session_unset();

        session_destroy();

        session_write_close();

        setcookie(session_name(),'',0,'/');

        session_regenerate_id(true);

        //Se redirige al inicio de sesión//

        header("Location: login.html");

    } 

    
    //Evaluando si el usuario ha realizado exitosamente la validación a través del formulario de inicio de sesión//

    //Si la variable de inicio de sesión de estado está vacía se dirigirá a la página de no autorización y este podrá regresar al formulario//

    if(empty($_SESSION['sesion']))
    {   
        //Impresión de la página de acceso no autorizado//

        echo '<!-- Estructura HTML para el inicio de sesión del sistema de control de inventarios y de nómina de empleados de la Farmacia Saint John S.A. de C.V. -->

        <!-- Versión 1.0 (Prototipo) -->
        
        <!-- Desarrollado Tech Solutions(R) 2021(C) (Proyecto dirigido por Nelson Alexander Brizuela Ramírez) -->
        
        
        <!--Página de acceso no autorizado (Versión de archivo 1.0) -->
        
        
        <!DOCTYPE html>
        
        <html lang = "es">
        
        <!-- Inicio de la estructura web -->
        
        <head>
        
          <meta charset = "UTF-8">
        
          <meta name = "description" content = "Inicio de sesión para el control de inventarios y de nómina de empleados de la Farmacia Saint John S.A. de C.V."/>

          <meta name ="Farmacia Saint John (Versión 1)" content = "Plantilla de inicio de sesión">

          <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">
        
            
          <!-- Integración de Bootstrap (Framework Front End) -->
        
          <link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        
          <!-- Integración de hoja de estilos personalizada (CSS III) -->
            
          <link rel = "stylesheet" href = "Assets/CSS/fsjstyle.css">

          <link rel = "shortcut icon" href = "Assets/Icons/icon.png">
            
          <title>¡Acceso no autorizado!</title>
            
          </head>
        
          <!-- Cuerpo de la página web -->
        
          <body>
    
            <header><center>

            <br>
        
            <br>

            <br>
        
            <div id = "header" class = "container" style = "background-color: rgba(255, 255, 255, 0.801);">
        
            <br>
        
            <div id = "middle" class = "container">
        
              <br>
        
              <h1><strong>¡Usted no está autorizado para revisar esta parte del sitio!</strong></h1>
        
              <br>
        
              <h5><strong>ERROR 403</strong></h5>

              <br>

              <a class = "navbar-brand" href = "login.html">

                <img src = "Assets/Images/cross.png" width = "60" height = "60">

              </a>

              <h1 id = "logo2">Clínica La Buena Salud</h1>
        
              <br>
        
              <h5>Versión 2.3</h5>
        
              <br>

              <h6><strong>DERECHOS RESERVADOS</h6>

              <h6>NELTECH ©2021</strong></h6>

                <br>
        
                </div>
        
                <br>
        
                <div class = "container">
        
                <div class = "row text-light">
        
              <div class = "col-sm">
              
              </div>
        
              <div class = "col-sm">

              <br>
        
                <a class = "btn btn-lg btn-primary btn-block" href = "login.html" _msthash = "469664" _msttexthash = "234910">Iniciar sesión adecuadamente</a>
        
              <br>
                
              </div>

              <div class = "col-sm">

              </div>

              </div>
        
            </div>
        
            <br>
            
          </div>
        
        </header></center>
    
        <br>
        
        <br>
        
        <br>
        
        </body>
        
        <!-- Final del cuerpo de la página -->
        
        
        <!-- Integración de librerías de JavaScript (JQuery y JPopper, JSSHA512 para encriptación y JValidation para validación de campos) -->
        
        <script src = "https://code.jquery.com/jquery-3.5.1.js"></script>
        
        <script src = "https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.js"></script>
        
        <script src = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>
            
        </html>
        
        <!-- Final de la estructura de la página de acceso no autorizado -->';

        
    } 

    //Si se realizó previamente el inicio de sesión exitosamennte, se dirigirá al a la página de inicio con las variables de sesión cargadas//
        
    else 
    {  
        //Tomando la plantilla de la página de inicio//

        $pagina = file_get_contents("templates/index.html");

        //Tomando el valor de las variables de sesión inicializadas y ubicandolas en las viñetas de sustitución//

        //Retornando el valor del año actual//

        $pagina = preg_replace('/--year--/', 'NELTECH ©' . date("Y") , $pagina);

        //Retornando el valor de la autoría del sitio//
        
        $pagina = preg_replace('/--name--/', GetName(), $pagina);

        //Retornando el valor de la variable de sesión del nombre del usuario//

        $pagina = preg_replace('/--nombreusuario--/', $_SESSION["nombre"], $pagina);

        //Retornando el valor de la variable de sesión del tipo de usuario//

        $pagina = preg_replace('/--tipousuario--/', $_SESSION["tusuario"], $pagina);

        //Retornando el valor de la variable de sesión del estado del usuario//

        $pagina = preg_replace('/--estado--/', $_SESSION["estado"], $pagina);

        //Retornando el valor de la variable de sesión del estado del usuario//

        $pagina = preg_replace('/--usuario--/', $_SESSION["usuario"], $pagina);

        //Retornando acciones disponibles según el tipo de usuario//

        $pagina = preg_replace('/--opcion1--/', $_SESSION['opcion1'], $pagina);

        $pagina = preg_replace('/--opcion2--/', $_SESSION['opcion2'], $pagina);

        $pagina = preg_replace('/--opcion3--/', $_SESSION['opcion3'], $pagina);

        $pagina = preg_replace('/--opcion4--/', $_SESSION['opcion4'], $pagina);

        $pagina = preg_replace('/--opcion5--/', $_SESSION['opcion5'], $pagina);

        //Mensajes de la pantalla de inicio tras haber ingresado//

        $pagina = preg_replace('/--cargo--/', $_SESSION['cargo'], $pagina);
 
        echo $pagina;

    }

    //Creación de métodos para generar cada plantilla sobre la marcha y componer la página de inicio de sesión//

    //Función para llamar a la plantilla de la barra de navegación//


    //Función para retornar el estado de la versión del servicio//

    function GetName()
    {
        //Asignando variable para el año de muestra//

        $name = "Versión 2.3";

        //Retornando el encabezado completo barra de navegación completa//

        return $name;

    }

?>