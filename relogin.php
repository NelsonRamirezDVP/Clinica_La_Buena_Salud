<?php

//Función para la creación y validación de una contraseña temporal//

//Recibiendo el valor del usuario a través de un operador ternario desde su cajón de texto en login.html/

//Alerta de creación de contraseña temporal//

$cont = "Tu contraseña temporal...";

$usuario = (isset($_POST["txtusuario2"]) ? $_POST["txtusuario2"] : '');



//Recibiendo el valor de la clave o contraseña a través de un operador ternario desde su cajón de texto en login.html//

//Inclusión de la conexión a la base de datos//

require_once "Database/dbcon.php";


//Métodos y funciones para iniciar sesión//

//Recuperando información asociada al nombre de usuario ingresado//

    $sql = mysqli_query($cnx, "SELECT * FROM usuarios_clinica WHERE Usuario = '$usuario'");

    //Si la inserción de datos fue exitosa y si un número mayor de cero filas fueron afectadas dentro de la tabla Categoria//

    if(mysqli_num_rows($sql)){

        //Generando una contraseña temporal de forma alfanumérica//

        $chars = "1234567890abcdefghijklmnopqrstuvwxyz";

        $cont = substr(str_shuffle($chars), 0, 8);

        $sql2 = mysqli_query($cnx, "UPDATE usuarios_clinica SET Clave = '$cont' WHERE Usuario = '$usuario'");
        
    }
    
    else{

        $usuario = "Ingresa tu usuario aquí...";

    }

echo '
    
<!-- Estructura HTML para el inicio de sesión del sistema de control de una clínica de laboratorios -->

<!-- Versión 1.0 (Prototipo) -->

<!-- Desarrollado Tech Solutions(R) 2021(C) (Proyecto dirigido por Nelson Alexander Brizuela Ramírez) -->


<!-- Archivo de plantilla de la página de inicio de sesión (Versión de archivo 1.0) -->

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

  <!-- Integración de icono (Favicon) -->

  <link rel = "shortcut icon" href = "Assets/Icons/icon.png">

  <!-- Integración de hoja de estilos personalizada (CSS III) -->
    
  <link rel = "stylesheet" href = "Assets/CSS/fsjstyle.css">
    
  <title>Obten acceso temporal</title>
	
</head>

<!-- Cuerpo de la página web -->

<body>


<!-- Inicio de la barra de navegación simple para la página de inicio de sesión -->

<nav id = "nav" class = "navbar sticky-top navbar-expand-lg navbar-light "  style = "background-color: rgb(255, 255, 255)">
  
  <a class = "navbar-brand" href = "login.html">

    <img src = "Assets/Images/cross.png" width = "60" height = "60">

  </a>

  <h1 id = "logo">Clínica La Buena Salud</h1>
 
  <div class = "collapse navbar-collapse" id = "navbarText">

    <ul class = "navbar-nav mr-auto">

        <li class = "nav-item active">

          <a class = "nav-link" href="#"></a>

        </li>

        <li class = "nav-item">

          <a class = "nav-link" href = "#"></a>

        </li>

        <li class = "nav-item">

          <a class = "nav-link" href ="#"></a>

        </li>

    </ul>

    <span class = "navbar-text">

    <h4 id = "nombre"><strong>Tu salud es primero.</strong></h4>

    </span>

  </div>

</nav>

<!-- Encabezado de la página web -->

<br>

<br>

<br>

<header><center>

  <div id = "header" class = "container" style = "background-color: rgba(255, 255, 255, 0.801);">

    <br>

    <div id = "middle" class = "container">

      <br>

      <h1><strong>¿Has perdido tu contraseña?</strong></h1>

      <br>

      <h5>Si estás registrado, puedes obtener una clave temporal pero si no y crees que se trata de un error comunicate con la regencia.</h5>

      <br>

      <h5><strong>7756-5656 (Regencia)</strong></h5>

      <br>

    </div>

    <br>

</header></center>

  <br>

  <br>

</div>

<br>

<br>

<!-- Contenedor para el formulario de ingreso -->

<form method = "POST" action = "relogin.php">
  
  <center><div class = "container col-4 text-dark" style = "background-color: rgba(255, 255, 255, 0.801);">

    <div class="col">

      <br>

      <h1><strong>Acceso temporal</strong></h1>

    </div>

    <br>

    <!-- Formulario de ingreso para el nombre de usuario -->

    <div class = "col-8">

      <input type = "text" id = "txtusuario2" name = "txtusuario2" class = "form-control" style = "background-color: rgba(255, 255, 255, 0.288);" placeholder = "' . $usuario . '" _mstplaceholder = "868153">

    </div>

    <br>

    <!-- Formulario de ingreso para la clave de acceso -->

    <div class = "col-8">

      <input type = "text" class = "form-control" style = "background-color: rgba(255, 255, 255, 0.288);" value="' . $cont . '" _mstplaceholder = "182013">

    </div>

    <br>


    <!-- Botón de inicio de sesión -->

    <div class = "col-6">

      <br>

      <button class = "btn btn-lg btn-primary" onclick="return confirm(\'Se va a generar una credencial de acceso temporal para este usuario. ¿Deseas continuar?\')" type = "submit" _msthash = "469664" _msttexthash = "234910"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
        
        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
      
      </svg>
            
      </button>

      <br>

      <br>

    </div>
        
  <!-- Final del formulario de inicio de sesión -->

</form>

<br>

</div></center>

<br>

<br>

<!-- Alerta para los inicios de sesión o problemas relacionados a la petición de AJAX-->

<center><div id = "resultado" class = "col-6 alert alert-dismissible fade show" role = "alert">

</div></center>

<br>

</body>

<!-- Final del cuerpo de la página -->

<!-- Contenedor de pié para el servicio web (Footer informativo y de enlaces) -->

  <footer class="site-footer">

    <div class="container">

      <div class="row">

        <div class="col-sm-12 col-md-6">

          <h6><strong>ACERCA DE...</strong></h6>

          <p class="text-justify">Sistema designado al mantenimiento y control de una clínica especializada en la realización de laboratorios.</p>
        
          <p class="text-justify">El presente sistema se encuentra en una fase actual de prototipo (Versión 1.0) que se encuentra actualmente en desarrollo. No todas las funciones pueden encontrarse disponibles por el momento.</p>
        
        </div>

        <div class="col-xs-6 col-md-3">

        </div>

        <div class="col-xs-6 col-md-3">

          <h6><strong>¿NECESITAS AYUDA?</strong></h6>

          <ul class="footer-links">

            <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
              
              <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
            
            </svg> 7756-5656 (Regencia)</a></li>

           <br>

            <li><a href="condiciones.html">  Condiciones de uso        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book-fill" viewBox="0 0 16 16">
              
              <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
            
            </svg></a></li>

            <br>

            <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
              
              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>

            </svg>  Calle Juan José Cañas entre Calle #85 y #83 de la Av. Sur #421</a></li>

          </ul>

        </div>

      </div>

      <hr>

    </div>

    <div class="container">

      <div class="row">

        <div class="col-md-8 col-sm-6 col-xs-12">

          <p class="copyright-text"><h6><strong>DERECHOS RESERVADOS</strong></h6>

            <h6><strong>©2021</strong></h6>

          </p>

        </div>

        </div>

      </div>

    </div>

</footer>

</div>


<!-- Integración de librerías de JavaScript (JQuery y JPopper) -->

<script src = "https://code.jquery.com/jquery-3.5.1.js"></script>

<script src = "https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.js"></script>

<script src = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>

<script src = https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js></script>

<script src = https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js></script>
 
<script src = "Assets/JS/sha512.js" type = "text/javascript"></script>


<!-- Script de validación a través de JQuery Validation -->
    
</html>

<!-- Final de la estructura de la página web de proceso de datos -->';