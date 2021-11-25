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

        $pagina = file_get_contents("Templates/changepat.html");

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

        $pagina = file_get_contents("Templates/changepat.html");

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
    
    $pagina = file_get_contents("Templates/changepat.html");

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

    //Variable global de conexión//

    global $cnx;

    $alert = "";

    //Variables de los datos a ingresar limpiando el código de PHP y HTML para ingresar valores limpios a la base de datos//

    $idpat = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['idpat'], ENT_QUOTES)));

    $nombrepaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["nombrepaciente"], ENT_QUOTES)));

    $dirresidencia = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["dirresidencia"], ENT_QUOTES)));

    $telefono = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['telefono'], ENT_QUOTES)));

    $correopaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['correopaciente'], ENT_QUOTES)));

    $duipaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["duipaciente"], ENT_QUOTES)));

    $medpaciente = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["medpaciente"], ENT_QUOTES)));

    $fechaex = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST["fechaex"], ENT_QUOTES)));

    //Haciendo una consulta para saber que examenes están guardados en la base de datos//

    if(!empty($_REQUEST['TipoExamen']))
    {

        $examenes = $_REQUEST['TipoExamen'];
        
        echo $examenes;

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

    //Actualización de un registro//

    $update = mysqli_query($cnx, "UPDATE informacion_pacientes SET ID_Paciente = $idpat, Nombre_Paciente = '$nombrepaciente', Direccion_Residencia = '$dirresidencia', Telefono_Paciente = '$telefono', Correo_Paciente = '$correopaciente', DUI_Paciente = '$duipaciente', Examen_Paciente = '$selected', Fecha_Examenes = '$fechaex', Med_Examen = '$medpaciente' WHERE ID_Paciente = $idpat;") or die(mysqli_error($cnx));

    //Si la actualización de datos fue exitosa y si un número mayor de cero filas fueron afectadas dentro de la tabla Categoria//
        
    if($update)
    {
        //Se envía la alerta específicada en la cabecera//

        header("Location: changepat.php?idpat=".$idpat."&acc=OK");

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

    $idpat = mysqli_real_escape_string($cnx, (strip_tags($_REQUEST['idpat'], ENT_QUOTES)));

    //Si la consulta retorna valores//

    $sql = mysqli_query($cnx, "SELECT * FROM informacion_pacientes WHERE ID_Paciente = $idpat");
    
    if(mysqli_num_rows($sql) > 0)
    {
        //Asignación de valores de la tabla a las variables locales//

        $row = mysqli_fetch_array($sql);

        $nombrepaciente = $row['Nombre_Paciente'];

        $dirresidencia = $row['Direccion_Residencia'];

        $telefono = $row['Telefono_Paciente'];

        $correopaciente = $row['Correo_Paciente'];

        $duipaciente = $row['DUI_Paciente'];

        $fechaex = $row['Fecha_Examenes'];



        //Obteniendo los valores de los examenes que inicialmente estaban en cadena para hacerlos un arreglo//

        $examenpaciente = $row['Examen_Paciente'];

        $selected = explode(", ", $examenpaciente);

        //Variables que almacenan el código HTML del estado de los checkbox//

        $check1 = '';
        $check2 = '';
        $check3 = '';
        $check4 = '';
        $check5 = '';
        $check6 = '';
        $check7 = '';
        $check8 = '';
        $check9 = '';
        $check10 = '';
        $check11 = '';
        $check12 = '';
        $check13 = '';
        $check14 = '';
        $check15 = '';
        $check16= '';
        $check17 = '';
        $check18 = '';
        $check19 = '';
        $check20 = '';
        $check21 = '';
        $check22 = '';
        $check23 = '';
        $check24 = '';
        $check25 = '';
        $check26 = '';
        $check27 = '';
        $check28 = '';
        $check29 = '';
        $check30 = '';
        $check31 = '';
        $check32 = '';
        $check33 = '';
        $check34 = '';
        $check35 = '';
        $check36 = '';
        $check37 = '';
        $check38 = '';
        $check39 = '';
        $check40 = '';
        $check41 = '';
        $check42 = '';
        $check43 = '';


        //Recuperación de checkbox para la primera categoria de examenes QC I//

        if(in_array('Glucosa', $selected)){

            $check1 = 'checked = "checked"';

        }

        if(in_array('Perfil de Lípidos', $selected)){

            $check2 = 'checked = "checked"';

        }

        if(in_array('Lisoproteínas (HDL/LDL)', $selected)){

            $check3 = 'checked = "checked"';

        }

        if(in_array('E.S.', $selected)){

            $check4 = 'checked = "checked"';

        }

        if(in_array('E.S. II', $selected)){

            $check5 = 'checked = "checked"';

        }

        if(in_array('Proteínas totales', $selected)){

            $check6 = 'checked = "checked"';

        }

        if(in_array('Perfil pancreático', $selected)){

            $check7 = 'checked = "checked"';

        }

        if(in_array('Perfil cardíaco', $selected)){

            $check8 = 'checked = "checked"';

        }

        if(in_array('Albumina', $selected)){

            $check9 = 'checked = "checked"';

        }

        //Recuperación de checkbox para la segunda categoria de examenes QC II//

        if(in_array('Fosfatasa ácida', $selected)){

            $check10 = 'checked = "checked"';

        }

        if(in_array('Gasometría arterial', $selected)){

            $check11 = 'checked = "checked"';

        }

        if(in_array('Gasometría venenosa', $selected)){

            $check12 = 'checked = "checked"';

        }

        if(in_array('Tolerancia a Glucosa', $selected)){

            $check13 = 'checked = "checked"';

        }

        if(in_array('Hemoglobina Glucosilada', $selected)){

            $check14 = 'checked = "checked"';

        }

        if(in_array('Electrolitos urinarios', $selected)){

            $check15 = 'checked = "checked"';

        }

        if(in_array('Calcio en orina (24 horas)', $selected)){

            $check16 = 'checked = "checked"';

        }

        if(in_array('Amilasa en orina', $selected)){

            $check17 = 'checked = "checked"';

        }

        if(in_array('Depuración de Creatinina (24 horas)', $selected)){

            $check18 = 'checked = "checked"';

        }

        //Recuperación de checkbox para la tercera categoria de examenes Serología//


        if(in_array('VDLR', $selected)){

            $check19 = 'checked = "checked"';

        }

        if(in_array('VIH', $selected)){

            $check20 = 'checked = "checked"';

        }

        if(in_array('AG Prostático (PSA)', $selected)){

            $check21 = 'checked = "checked"';

        }

        if(in_array('Antiestreptolisinas', $selected)){

            $check22 = 'checked = "checked"';

        }

        if(in_array('Factor reumatoide', $selected)){

            $check23 = 'checked = "checked"';

        }

        if(in_array('Proteína C Reactiva', $selected)){

            $check24 = 'checked = "checked"';

        }

        if(in_array('Reacciones febriles', $selected)){

            $check25 = 'checked = "checked"';

        }

        if(in_array('Prueba de embarazo (En sangre)', $selected)){

            $check26 = 'checked = "checked"';

        }

        //Recuperación de checkbox para la cuarta categoría de examenes Microbiología//


        if(in_array('Coprocultivo/Antibiograma', $selected)){

            $check27 = 'checked = "checked"';

        }

        if(in_array('Cultivo de expectoración', $selected)){

            $check28 = 'checked = "checked"';

        }

        if(in_array('Exudado faringeo', $selected)){

            $check29 = 'checked = "checked"';

        }

        if(in_array('Exudado nasal', $selected)){

            $check30 = 'checked = "checked"';

        }

        if(in_array('Exudado uretal', $selected)){

            $check31 = 'checked = "checked"';

        }

        if(in_array('Hemocultivo', $selected)){

            $check32 = 'checked = "checked"';

        }

        if(in_array('Cultivo de LCR', $selected)){

            $check33 = 'checked = "checked"';

        }

        if(in_array('Cultivo de líquido Pleural', $selected)){

            $check34 = 'checked = "checked"';

        }

        if(in_array('Cultivo de líquido de Dialisis', $selected)){

            $check35 = 'checked = "checked"';

        }

        if(in_array('Urocultivo', $selected)){

            $check36 = 'checked = "checked"';

        }


        //Recuperación de checkbox para la quinta categoría de examenes Urología/Parasitología//


        if(in_array('General de orina', $selected)){

            $check37 = 'checked = "checked"';

        }

        if(in_array('Proteína de Bence Jones', $selected)){

            $check38 = 'checked = "checked"';

        }

        if(in_array('Citología fecal', $selected)){

            $check39 = 'checked = "checked"';

        }

        if(in_array('Azucares reductores', $selected)){

            $check40 = 'checked = "checked"';

        }

        if(in_array('Coproparasitoscópico (3 muestras)', $selected)){

            $check41 = 'checked = "checked"';

        }

        if(in_array('Sangre en heces', $selected)){

            $check42 = 'checked = "checked"';

        }

        if(in_array('Coprológico', $selected)){

            $check43 = 'checked = "checked"';

        }

        $medpaciente = $row['Med_Examen'];

        //Formulario a mostrar para la modificación de registros//

        $form = '<form class = "form-inline" method = "POST" action = "changepat.php">

        <div class="container">

        <div class="row">

             <div id = "idinsumo" class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
    
             <p><strong>ID del insumo</strong></p>

             <!-- Entrada de un cajón numérico para el ID del paciente -->

             <center><div>

             <input type = "number" style = "background-color: #000000d0;" class = "form-control text-light" name = "idpat" value = ' . $idpat . ' readonly>

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

                    <p><strong>Nombre completo del paciente</strong></p>

                    <input type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "nombrepaciente" name = "nombrepaciente" value = "' . $nombrepaciente . '" required>

                </div>
    
            </div>

          </div>

          <div class="col-sm">

            <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
                
                <!-- Entrada de un cajón de texto para el apellido del paciente -->

                <div class>

                    <p><strong>Dirección de residencia</strong></p>

                    <input type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "dirresidencia" name = "dirresidencia" value = "' . $dirresidencia . '" required>

                </div>

            </div>

          </div>

        </div>

        <div class="row">

          <div class="col-sm">

            <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
                
            <!-- Entrada de un cajón de selección el número de teléfono del paciente -->
    
            <div>
                
                <p><strong>Número de teléfono</strong></p>

                <input type = "number" class = "form-control text-light" style = "background-color: #000000d0;" id = "telefono" name = "telefono" value = "' . $telefono . '" required>
              
            </div>

            </div>

          </div>

          <div class="col-sm">

            <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">

            <!-- Entrada de un cajón de texto para el correo electrónico del paciente -->
    
                <div class>

                    <p><strong>Correo eletrónico</strong></p>

                    <input type = "email" class = "form-control text-light" style = "background-color: #000000d0;" id = "correopaciente" name = "correopaciente" value = "' . $correopaciente . '" required>

                </div>
            
            </div>

          </div>

        </div>

        <div class="row">

          <div class="col-sm">

            <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">

            <div>
                    
                    <p><strong>DUI del paciente</strong></p>

                    <input type = "number" class = "form-control text-light" style = "background-color: #000000d0;" id = "duipaciente" name = "duipaciente" value = "' . $duipaciente . '" required>
                  
                </div>
    
            </div>

          </div>

          <div class="col-sm">

            <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
                
                <!-- Entrada de un cajón para el DUI del paciente -->

                <div>
                    
                    <p><strong>Médico que solicitó el examen</strong></p>

                    <input type = "text" class = "form-control text-light" style = "background-color: #000000d0;" id = "medpaciente" name = "medpaciente" value = "' . $medpaciente . '">
                  
                </div>
    
            </div>

          </div>

        </div>

        <div class="row">

          <div class="col-sm">

          <div class = "container p-3 my-3 text-dark" style = "background-color: #ffffffdc;">
                    
                  <!-- Entrada de un seleccionador de fecha para la realización de examenes -->

                  <div>
                    
                    <p><strong>Fecha de realización de los examenes</p></strong>

                    <input type = "date" class = "form-control text-light" style = "background-color: #000000d0;" id = "fechaex" name = "fechaex" value = "' . $fechaex . '" required>
                  
                </div>

              </div>

          </div>

          <div class="col-sm">

            <div class = "container p-3 my-3 text-dark">
                
                <!-- Entrada de un cajón de selección para el médico que solicitó el examen -->
    
            </div>

          </div>

        </div>

        <br>

        <br>

        <br>
        
        <!-- Tarjetas para cada examen a adjuintar para el paciente divididos por categorías (Checkbox) -->

        <center><div class="container p-3 my-3 text-dark" style = "background-color:rgba(255, 255, 255, 0.801);">

          <h2>EXAMENES A REALIZAR</h2>
          
          <p id = "sub">Marca o desmarca las casillas de los examenes que el paciente va a realizarce. Procede a modificar al terminar.</p>
          
          </div></center>

        <br>

      <div class = "container-fluid p-3 my-3">

      <center><div class = "container-fluid p-3 my-3">

        <div class="container">

          <div class="row">

            <div class="col"><div class="card" style="width: 18rem;">

              <div class="card-header bg-dark text-light">

                <center><h5>Química clínica</h5></center>

              </div>

              <ul class="list-group list-group-flush text-left">

                <br>

                <div class="container-fluid">

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Glucosa" id="flexCheckDefault"' . $check1 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Glucosa

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Perfil de Lípidos" id="flexCheckDefault"' . $check2 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Perfil de lípidos (Col/Trig)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Lisoproteínas (HDL/LDL)" id="flexCheckDefault" ' . $check3 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Lisoproteínas (HDL/LDL/)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="E.S." id="flexCheckDefault"' . $check4 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    E.S. (Sodio/Potasio/Cloro)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="E.S. II" id="flexCheckDefault"' . $check5 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    E.S. II (Cal/Fós/Mag)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Proteínas totales" id="flexCheckDefault" ' . $check6 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Proteínas totales (A/G)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Perfil pancreático" id="flexCheckDefault" ' . $check7 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Perfil pancreático

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Perfil cardíaco" id="flexCheckDefault" ' . $check8 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Perfil cardíaco

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" value="Albumina" name = "TipoExamen[]" id="flexCheckDefault" ' . $check9 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Albumina

                  </label>

                </div>

              <br>

              </ul>

            </div></div>

            <div class="col"><div class="card" style="width: 18rem;">

              <div class="card-header bg-dark text-light">

              <center><h5>Química Clínica (II)</h5></center>

              </div>

            <div>

              <ul class="list-group list-group-flush text-left">

                <br>

                <div class="container-fluid">

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Fosfatasa ácida" id="flexCheckDefault" ' . $check10 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Fosfatasa ácida

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Gasometría arterial" id="flexCheckDefault" ' . $check11 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Gasometría arterial

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Gasometría venenosa" id="flexCheckDefault" ' . $check12 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Gasometría venenosa

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Tolerancia a Glucosa" id="flexCheckDefault" ' . $check13 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Tolerancia a Glucosa

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Hemoglobina Glucosilada" id="flexCheckDefault" ' . $check14 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Hemoglobina Glucosilada

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Electrolitos urinarios" id="flexCheckDefault" ' . $check15 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Electrolitos urinarios

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Calcio en orina (24 horas)" id="flexCheckDefault" ' . $check16 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Calcio en orina (24 horas)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Amilasa en orina" id="flexCheckDefault" ' . $check17 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Amilasa en orina

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Depuración de Creatinina (24 horas)" id="flexCheckDefault" ' . $check18 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Creatinina (24 horas)

                  </label>

                </div>

              <br>

              </ul>

            </div>

            </div></div>

            <div class="col"><div class="card" style="width: 18rem;">

              <div class="card-header bg-dark text-light">

              <center><h5>Serología</h5></center>

              </div>

              <ul class="list-group list-group-flush text-left">

                <br>

                <div class="container-fluid">

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="VDLR" id="flexCheckDefault"  ' . $check19 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    VDLR

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="VIH" id="flexCheckDefault" ' . $check20 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    VIH

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="AG Prostático (PSA)" id="flexCheckDefault" ' . $check21 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    AG Prostático (PSA)

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Antiestreptolisinas" id="flexCheckDefault" ' . $check22 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Antiesteptrolisinas

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Factor reumatoide" id="flexCheckDefault" ' . $check23 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Factor reumatoide

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" name = "TipoExamen[]" type="checkbox" value="Proteína C Reactiva" id="flexCheckDefault" ' . $check24 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Proteína C reactiva

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Reacciones febriles" id="flexCheckDefault"  ' . $check25 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                    Reacciones febriles

                  </label>

                </div>

                <div class="form-check">

                  <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Prueba de embarazo (En sangre)" id="flexCheckDefault" ' . $check26 .'>

                  <label class="form-check-label" for="flexCheckDefault">

                   Prueba de embarazo (En sangre)

                  </label>

                </div>

              <br>

              </ul>

            </div>

            <br>

          <br>

          </div>

              <div class="col-sm-6"><div class="card" style="width: 18rem;">

                <div class="card-header bg-dark text-light">

                <center><h5>Microbiología</h5></center>

                </div>

                <ul class="list-group list-group-flush text-left">

                  <br>

                  <div class="container-fluid">

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Coprocultivo/Antibiograma" id="flexCheckDefault" ' . $check27 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Coprocultivo/Antibiograma

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Cultivo de expectoración" id="flexCheckDefault" ' . $check28 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Cultivo de expectoración

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Exudado faringeo" id="flexCheckDefault" ' . $check29 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Exudado faringeo

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Exudado nasal" id="flexCheckDefault" ' . $check30 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Exudado nasal

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Exudado uretal" id="flexCheckDefault" ' . $check31 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Exudado uretal

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Hemocultivo" id="flexCheckDefault" ' . $check32 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Hemocultivo

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Cultivo de LCR" id="flexCheckDefault" ' . $check33 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Cultivo de LCR

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Cultivo de líquido Pleural" id="flexCheckDefault" ' . $check34 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Cultivo de líquido Pleural

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" name = "TipoExamen[]" type="checkbox" value="Cultivo de líquido de Dialisis" id="flexCheckDefault" ' . $check35 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Cultivo de líquido de Diálisis

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" name = "TipoExamen[]" type="checkbox" value="Urocultivo" id="flexCheckDefault" ' . $check36 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Urocultivo

                    </label>

                  </div>

                <br>

                </ul>

              </div></div>

              <div class="col-sm-6"><div class="card" style="width: 18rem;">

                <div class="card-header bg-dark text-light">

                <center><h5>Urología/Parasitología</h5></center>

                </div>

                <left><ul class="list-group list-group-flush text-left">

                  <br>

                  <div class="container-fluid">

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="General de orina" id="flexCheckDefault" ' . $check37 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      General de orina

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Proteína de Bence Jones" id="flexCheckDefault" ' . $check38 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Proteína de Bence Jones

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Citología fecal" id="flexCheckDefault" ' . $check39 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Citología fecal

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Azucares reductores" id="flexCheckDefault" ' . $check40 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Azucares reductores

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Coproparasitoscópico (3 muestras)" id="flexCheckDefault" ' . $check41 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Coproparasitoscópico (3 muestras)

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Sangre en heces" id="flexCheckDefault" ' . $check42 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Sangre en heces

                    </label>

                  </div>

                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name = "TipoExamen[]" value="Coprológico" id="flexCheckDefault" ' . $check43 .'>

                    <label class="form-check-label" for="flexCheckDefault">

                      Coprológico

                    </label>

                  </div>

                <br>

                </ul>

              </div>

              </div>

              </div>

              <br> 

              <br> 

    <!-- Grupo de botones -->

    <center><div class = "container text-white" style = "background-color: rgba(255, 255, 255, 0);">
        
        <div class="row">

          <div class="col">
            
          <button type="submit" name = "save" id = "save" title = "Modifica los datos requeridos del paciente." class="btn btn-primary">Modificar el registro <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              
            <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>

          </div>

          <div class="col-md">

            <a class="btn btn-light" type = "back" href="indexpat.php?filtro=ida" title = "Regresa a la página anterior.">Regresar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
           
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
          
            </svg> </a>


        </div></center>

     </form>';

     //Cerrando Resultset//

     mysqli_free_result($sql);

     addslashes($form);

      return $form;
      
    }

}

?>

