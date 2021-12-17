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
<h3>Registrar entrada</h3>
<form method="post" action="">
    <legend>Fecha entrada</legend>
<input name="fecha_entrada" type="date">
<legend>Hora entrada</legend>
<input name="hora_entrada" type="time">
<br>
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
     <br>
<input type="submit" name="entrada" value="Empezar jornada">
</form>



<?php

//if(isset($_POST('entrada')){
$fechaentrada=$_POST['fecha_entrada'];
$horaentrada=$_POST['hora_entrada'];
$usuario = $_SESSION['login_user'];
$proyecto=$_POST['pro'];

$consulta="SELECT id_usuario FROM usuarios WHERE correo='$usuario'";
//$consulta="INSERT INTO grupos (id_grupo) values (2)";
$resultados=mysqli_query($conexioa, $consulta);
$datos=mysqli_fetch_array($resultados);
//$resultados=true;

if ($_POST['entrada']) {
    $consultasql="SELECT id_usuario FROM usuarios WHERE correo='$usuario'";
//$consulta="INSERT INTO grupos (id_grupo) values (2)";
$resultadossql=mysqli_query($conexioa, $consultasql);
$datoss=mysqli_fetch_array($resultadossql);
    $consultafichado="SELECT id_fichaje from fichajes where usuario = $datoss[0] and fech_salida is null order by fech_entrada desc limit 1;";
    $resultadofichado=mysqli_num_rows(mysqli_query($conexioa,$consultafichado));
if($resultadofichado == 0){
    $sqlentrada="INSERT INTO fichajes (fech_entrada,hora_entrada,usuario,proyecto) VALUES ('$fechaentrada','$horaentrada',$datoss[0],$proyecto)";
    mysqli_query($conexioa,$sqlentrada);
}else{
    ?>
    <script>alert("Primero debes terminar completar el fichaje de este proyecto")</script>
    <?php 
}

}

//}
?>
<br>
<h3>Registrar salida</h3>
<form method="post" action="">
    <legend>Fecha salida</legend>
<input name="fecha_salida" type="date">
<legend>Hora salida</legend>
<input name="hora_salida" type="time">
<br>
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
     <br>
<input type="submit" name="salida" value="Terminar jornada">
</form>


<?php
//if(isset($_POST('entrada')){
$fechasalida=$_POST['fecha_salida'];
$horasalida=$_POST['hora_salida'];
$usuario = $_SESSION['login_user'];

$consulta="SELECT id_usuario FROM usuarios WHERE correo='$usuario'";
//$consulta="INSERT INTO grupos (id_grupo) values (2)";
$resultados=mysqli_query($conexioa, $consulta);
$datos=mysqli_fetch_array($resultados);

$consultafecha="SELECT id_fichaje from fichajes where usuario = $datos[0] and fech_salida is null order by fech_entrada desc limit 1;";
$resultadofecha=mysqli_query($conexioa,$consultafecha);
$fechadeentrada=mysqli_fetch_array($resultadofecha);


if ($_POST['salida']) {
   $sqlsalida="UPDATE fichajes SET fech_salida ='$fechasalida', hora_salida='$horasalida' where id_fichaje = $fechadeentrada[0]";
   mysqli_query($conexioa,$sqlsalida);
}

//}
}else{
    ?>
    <script>
      alert("Acceso denegado consulte su administrador");
      window.location.href = "https://10.122.27.105/?page_id=421"
    </script> 
      <?php
      
  }
      ?>

