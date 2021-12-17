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
<h3>Filtros de busqueda</h3>
<form method="post" action="">
    <legend>Desde</legend>
    <input type="date" name="fechaini" value="%" required>
    <legend>Hasta</legend>
    <input type="date" name="fechafin" value="%" required>
    <legend>Empleado</legend>
    <select name="empleado">
        <option value="<?php echo "%";?>" default>Cualquier empleado</option>
     <?php
 $sqlusuarios="select id_usuario,concat(empleados.nombre, ' ' ,empleados.apellido) from usuarios join empleados on empleados.usuario = usuarios.id_usuario ";
 $resultados=mysqli_query($conexioa, $sqlusuarios);
 while ($usuarios = $resultados->fetch_row()) {
     ?>
         <option value="<?php echo $usuarios[0];?>"><?php echo $usuarios[1];}?></option>
     </select>

     <legend>Proyecto</legend>
    <select name="proyecto">
        <option value="%" default>Cualquier proyecto</option>
     <?php
 $sqlproyectos="select id_proyecto,nombre from proyectos ";
 $resultadosproyectos=mysqli_query($conexioa, $sqlproyectos);
 while ($proyecto = $resultadosproyectos->fetch_row()) {
     ?>
         <option value="<?php echo $proyecto[0];?>"><?php echo $proyecto[1];}?></option>
     </select>
     <legend>Departamento</legend>
    <select name="dep">
        <option value="%" default>Cualquier departamento</option>
     <?php
 $sqldepartamentos="select id_departamento,nombre from departamentos";
 $resultadosdepartamentos=mysqli_query($conexioa, $sqldepartamentos);
 while ($departamento = $resultadosdepartamentos->fetch_row()) {
     ?>
         <option value="<?php echo $departamento[0];?>"><?php echo $departamento[1];}?></option>
     </select>
<br>
<legend>Importe total minmo</legend>
<input type="number" name="min" required>
<br>
<legend>Importe total maximo</legend>
<input type="number" name="max" required>
<br>
<input type="submit" name="filtrar" value="Filtrar gastos">
</form>
<br>

</table>
   </form>
    <div class="php">
         <table><tr>
                    <th id="cabeceras-tabla">Fecha</th>
                    <th id="cabeceras-tabla">KM(€)</th>
                    <th id="cabeceras-tabla">Comida(€)</th>
                    <th id="cabeceras-tabla">Alojamiento(€)</th>
                    <th id="cabeceras-tabla">Peaje(€)</th>
                    <th id="cabeceras-tabla">Parking(€)</th>
                    <th id="cabeceras-tabla">Deparamento</th>
                    <th id="cabeceras-tabla">Viaje</th>
                    <th id="cabeceras-tabla">Acciones</th>
              </tr>
              
<?php
//if($POST_['filtrar']){
    if(!$_POST['proyecto'] == null){
    $_SESSION['proyecto']=$_POST['proyecto'];
    $_SESSION['empleado']=$_POST['empleado'];
    $_SESSION['dep']=$_POST['dep'];
    $idusuario=$_SESSION['empleado'];
    $proyecto=$_SESSION['proyecto'];
    $dep=$_SESSION['dep'];
   
    
}
$fechaini=$_POST['fechaini'];
    if($fechaini == null){
    $fechaini="%";
    }else{

    }
    $fechafin=$_POST['fechafin'];
    if($fechafin == null){
        $fechafin="%";
        }else{
    
        }
$min=$_POST['min'];
$max=$_POST['max'];
$consultabuscar="SELECT id_gasto,fecha,km,comida,alojamiento,peaje,parking,departamentos.nombre,viajes.destino, round(sum(km+comida+alojamiento+peaje+parking),2) as 'Total'  FROM `gastos` join proyectos on proyectos.id_proyecto = gastos.id_prop join trabajos on trabajos.id_proyecto = proyectos.id_proyecto JOIN empleados on empleados.dni = trabajos.id_empleado join usuarios on empleados.usuario = usuarios.id_usuario join departamentos on departamentos.id_departamento = gastos.id_dep join viajes on viajes.id_viaje = gastos.id_via WHERE id_usuario like '$idusuario' and fecha between '$fechaini' and '$fechafin' and proyectos.id_proyecto like '$proyecto'  and id_departamento like '$dep' group by id_gasto HAVING total between $min and $max";
$query=mysqli_query($conexioa,$consultabuscar);
?>
    <?php
    while ($gastos = $query->fetch_row()) {
?>
      <tr>
        <form method="post" action="">
      <input type="text" name="idgasto" value="<?php echo $gastos[0]; ?>" hidden>
      <td><input class="inputcondatos" type="date" name="fechaeditar" value="<?php echo $gastos[1]; ?>" ></td>
      <td><input class="inputcondatos" type="numeric"name="kmeditar" value="<?php echo $gastos[2]; ?>"></td>
      <td><input class="inputcondatos" type="numeric"name="comidaeditar" value="<?php echo $gastos[3]; ?>"></td>
      <td><input class="inputcondatos" type="numeric"name="alojamientoeditar" value="<?php echo $gastos[4]; ?>"></td>
      <td><input class="inputcondatos" type="numeric"name="peajeeditar" value="<?php echo $gastos[5]; ?>"></td>
      <td><input class="inputcondatos" type="numeric"name="parkingeditar" value="<?php echo $gastos[6]; ?>"></td>
      <td><input class="inputcondatos" type="text"name="depeditar" value="<?php echo $gastos[7]; ?>"></td>
      <td><input class="inputcondatos" type="text"name="viajeeditar" value="<?php echo $gastos[8]; ?>"></td>
      
      
      <td class="botonmaspeque">
    <input class="botones_gastos_guardar" name="Guardar" type="submit" value="Guardar"><br><br> <input name="Eliminar"class="botones_gastos_eliminar"  type="submit" value="Eliminar">
        </td>
      </form>
    </tr>
<?php
          }
        ?>


   
</div>
    </div>
        </table>
<?php
    // }
    

  
    # EDITAR REGISTRO
    $idgasto=$_POST['idgasto'];
    $fechaeditar=$_POST['fechaeditar'];
    $kmeditar=$_POST['kmeditar'];
    $comidaeditar=$_POST['comidaeditar'];
    $alojamientoeditar=$_POST['alojamientoeditar'];
    $peajeeditar=$_POST['peajeeditar'];
    $parkingeditar=$_POST['parkingeditar'];
    $depeditar=$_POST['depeditar'];
    $viajeeditar=$_POST['viajeeditar'];
    if (isset($_POST['Guardar'])){

        $consultadep="SELECT id_departamento FROM departamentos WHERE departamentos.nombre='$depeditar'";
        $resultadodepartamento=mysqli_query($conexioa,$consultadep);
        $dep=mysqli_fetch_array($resultadodepartamento);

        $consultaviaje="SELECT id_viaje FROM viajes WHERE viajes.destino='$viajeeditar'";
        $resultadoviaje=mysqli_query($conexioa,$consultaviaje);
        $via=mysqli_fetch_array($resultadoviaje);

        $sqlmodificargasto="UPDATE gastos SET fecha='$fechaeditar',  km='$kmeditar',  comida='$comidaeditar',  alojamiento='$alojamientoeditar',  peaje='$peajeeditar',  parking='$parkingeditar',  id_dep='$dep[0]', id_via='$via[0]'  WHERE id_gasto = $idgasto;";
        mysqli_query($conexioa,$sqlmodificargasto);
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
