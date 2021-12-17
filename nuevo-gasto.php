<?php
   include('session.php');
   $correo=$_SESSION['login_user'];
   $selectusuarios="SELECT id_usuario FROM usuarios WHERE correo='$correo'";
   $iduser=mysqli_fetch_array(mysqli_query($conexioa,$selectusuarios));
   
$sqlpermisos="SELECT permisos.activo FROM usuarios join grupos on usuarios.grupo = grupos.id_grupo join permisos on grupos.id_grupo = permisos.grupo where accion ='$_SERVER[REQUEST_URI]' and correo ='$correo'";
$resultados_permisos=mysqli_query($conexioa,$sqlpermisos);
$arrayDatos = mysqli_fetch_array($resultados_permisos);

  if ($arrayDatos[0] == "on"){
?>
<head>
<link type="text/css" href="/css/estilos.css" rel="stylesheet"/>
</head>

<form method="post" action="" enctype="multiprat/form-data">
<legend>Fecha</legend>
<input type="date" name="date">
<legend>Km</legend>
<input type="number" name="km">
<legend>Dieta (€)</legend>
<input type="number" name="dieta">
<legend>Alojamiento (€)</legend>
<input type="number" name="alojamiento">

<legend>Departemanto</legend>
<select name="dep" required>
     <?php
    
 $consultadep="SELECT id_departamento,nombre FROM departamentos";
 $resultados=mysqli_query($conexioa, $consultadep);
 while ($dep = $resultados->fetch_row()) {
     ?>
         <option value="<?php echo $dep[0];?>"><?php echo $dep[1];}?></option>
     </select>
<legend>Proyecto</legend>
<select name="pro" requiered>
     <?php
    
     $consultaempleado="SELECT dni from empleados join usuarios on usuarios.id_usuario = empleados.usuario where correo='$correo'";
    $resultadoempleado=mysqli_query($conexioa,$consultaempleado);
     $empleado=mysqli_fetch_array($resultadoempleado);
$idempleado=$empleado[0];
 $consultapro="SELECT proyectos.id_proyecto,nombre FROM proyectos join trabajos on proyectos.id_proyecto = trabajos.id_proyecto where id_empleado='$idempleado'";
 $resultadospro=mysqli_query($conexioa, $consultapro);
 
 while ($pro = $resultadospro->fetch_row()) {
     ?>
         <option value="<?php echo $pro[0];?>"><?php echo $pro[1];}?></option>
     </select>
<legend>Viaje</legend>
<select name="viaje" requiered>
     <?php
 $consultavia="SELECT id_viaje,destino FROM viajes WHERE activo='on'";
 $resultadosvia=mysqli_query($conexioa, $consultavia);
 while ($via = $resultadosvia->fetch_row()) {
     ?>
         <option value="<?php echo $via[0];?>"><?php echo $via[1];}?></option>
     </select><legend>Parking (€)</legend>
<input type="number" name="parking">
<legend>Vehiculo</legend>
<select name="vehiculo">
    <option value="Vehiculo propio" default>Vehiculo propio</option>
    <option value="Coche">Coche</option>
    <option value="Moto">Moto</option>
    <option value="Avion">Avión</option>
    <option value="Autobus">Autobus</option>
    <option value="Tren">Tren</option>
    <option value="Taxi">Taxi</option>

</select>
<legend>Peaje (€)</legend>
<input type="number" name="peaje">
<legend>Justificante</legend>   
<input type="text" name="uploadfile">
<br>
<br>
<input type="submit" name="nuevo_gasto" value="Registrar gasto">
</form>


<button class="restablecer_fuera" onclick="document.getElementById('id01').style.display='block'">Solicitar dieta</button></div>

<div id="id01" class="modals">
  
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
     
    </div>

    <div class="contenedor">
        <legend>Fecha inicio</legend>
      <input type="date" placeholder="Contraseña actual" name="fecha_inicio" required class="inputcambiarcontra">
      <br>
      <br>
      <legend>Fecha fin</legend>
      <input type="date" placeholder="Nueva contraseña" name="fecha_fin" required class="inputcambiarcontra">
      <br>
      <br>
      <legend>Tipo de dieta</legend>
      <select name="pais">
<option value="EUROPEO">Dieta Europea (60€)</option>
<option value="INTERNACIONAL">Dieta extranjera (100€)</option>
</select>
     <br><br>
      <input type="submit" class="boton_modificar_3" name="sol_dieta" value="Solicitar dieta">
      
    </div>
  </form>
</div>

<script>
// Hacer aparecer el popup
var modal = document.getElementById('id01');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<?php
$fecha=$_POST['date'];
$km=$_POST['km'];
$dieta=$_POST['dieta'];
$alojamiento=$_POST['alojamiento'];
$justificante=$_POST['uploadfile'];
$departamento=$_POST['dep'];
$proyecto=$_POST['pro'];
$viaje=$_POST['viaje'];
$parking=$_POST['parking'];
$vehiculo=$_POST['vehiculo'];
$peaje=$_POST['peaje'];
# Insertar nuevo regisistro de gastos

if (isset($_POST['nuevo_gasto'])){
    if($justificante == null){
        $justificante="No aplica";
    }

    if((is_numeric($km) || is_null($km)) && is_numeric($dieta) && is_numeric($alojamiento) && is_numeric($departamento) && is_numeric($proyecto) && is_numeric($peaje) && is_numeric($parking) && is_numeric($viaje)){
        $sqliduser="SELECT id_usuario FROM usuarios WHERE correo ='$correo'";
        $resuladosusuario=mysqli_fetch_array(mysqli_query($conexioa,$sqliduser));
        $validieta="SELECT count(id_dieta) from dietas where usuario = '$resuladosusuario[0]'  and '$fecha' BETWEEN fecha_inicio AND fecha_fin";
        $resultdieta=mysqli_fetch_array(mysqli_query($conexioa,$validieta));
        if($resultdieta[0] == 0){
        $insertgastos="INSERT INTO gastos (fecha,km,comida,alojamiento,justificante,vehiculo,peaje,parking,id_dep,id_prop,id_via) VALUES ('$fecha',$km,$dieta,$alojamiento,'$justificante','$vehiculo',$peaje,$parking,$departamento,$proyecto,$viaje)";
        mysqli_query($conexioa,$insertgastos);
  
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];    
        $folder = "upload/".$filename;
       
        if (move_uploaded_file($justificante, $folder))  {
            $msg = "Imagen subida correctamente";
            echo $msg;
        }else{
            $msg = "Fallo al subir la imagen";
           // echo $msg;
      }
    }else{
        ?>
        <script>alert("No puedes registrar una gasto mientras tienes una dieta activa")</script>
        <?php
    }
    }else{
        ?>
        <script>alert("Alguno de los campos introducidos no cumple con los requisitos.")</script>
        <?php
    
    }
   
}


if(isset($_POST['sol_dieta'])){
    $fechainicio=$_POST['fecha_inicio'];
    $fechafin=$_POST['fecha_fin'];
    $pais=$_POST['pais'];
$fecha1 = new DateTime($_POST['fecha_inicio']);
$fecha2 = new DateTime($_POST['fecha_fin']);
$diferencia = $fecha1->diff($fecha2);
$dif=$diferencia->format('%a');


if($pais =="EUROPEO"){
    $importe=60;
}elseif($pais=="INTERNACIONAL"){
    $importe=100;
}else{
    echo "Error de validación";
}


    if($dif < 5){
        ?>
        <script>alert("Como minimo debes viajar durante 4 dias para poder solicitar una dieta.")</script>
        <?php 
    }else{
        
        $sqlusuario="SELECT id_usuario from usuarios WHERE correo='$correo'";
        $id_usuario=mysqli_fetch_array(mysqli_query($conexioa,$sqlusuario));
      
        $idusurio=$id_usuario[0];
        $insertdieta="INSERT INTO dietas (fecha_inicio,fecha_fin,pais,imp_dia,usuario) VALUES ('$fechainicio','$fechafin','$pais','$importe','$id_usuario[0]')";
        mysqli_query($conexioa,$insertdieta);

    }
}
}else{
    ?>
    <script>
      alert("Acceso denegado consulte su administrador");
      window.location.href = "https://10.122.27.105/?page_id=421"
    </script> 
      <?php
      
  }
      ?>
