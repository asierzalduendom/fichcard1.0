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

</table>
   </form>
    <div class="php">
         <table><tr>
                    <th id="cabeceras-tabla">Correo</th>
                    <th id="cabeceras-tabla">Grupo</th>
                    <th id="cabeceras-tabla">Departamento</th>
                    <th id="cabeceras-tabla">Acciones</th>
              </tr>
    <?php
    include('session.php');
    $consulta="SELECT id_usuario,correo, grupos.nombre,departamentos.nombre FROM `usuarios` JOIN grupos on usuarios.grupo = grupos.id_grupo join departamentos on departamentos.id_departamento = usuarios.dep order by id_usuario";
    $resultados=mysqli_query($conexioa, $consulta);
    while ($fila = $resultados->fetch_row()) {
?>
      <tr>
        <form method="post" action="">
      <input type="text" name="idusuario" value="<?php echo $fila[0]; ?>" hidden>
      <td><input type="text" name="correo" value="<?php echo $fila[1]; ?>" ></td>
      <td><input type="text"name="grupo" value="<?php echo $fila[2]; ?>"></td>
      <td><input type="text"name="dep" value="<?php echo $fila[3]; ?>"></td>
      <td class="botonmaspeque">
    <input name="Guardar" class="boton_editar" type="submit" value="Guardar"> <input name="Eliminar" class="boton_borrar" type="submit" value="Eliminar">
        </td>
      </form>
    </tr>
<?php
          }
        ?>
</div>
    </div>
        </table>

        <button class="restablecer_fuera" onclick="document.getElementById('id01').style.display='block'">Restablecer una contraseña</button>

<div id="id01" class="modals">
  
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
    <select name="usuariocambiar" class="combousuario">
     <?php
 $consulta="SELECT id_usuario,correo FROM usuarios";
 $resultados=mysqli_query($conexioa, $consulta);
 while ($fila = $resultados->fetch_row()) {
     ?>
         <option value="<?php echo $fila[0];?>"><?php echo $fila[1];}?></option>
     </select>
     
    </div>

    <div class="contenedor">
      
      <input type="password" placeholder="Nueva contraseña" name="passwd" required class="inputcambiarcontra">
      <br>
      <br>
      <input type="password" placeholder="Confirmar contraseña" name="passwdconf" required class="inputcambiarcontra"><br><br>
      <input type="submit" class="boton_modificar_3" name="restablecer" value="Restablecer contraseña">
      
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

$usuario=$_POST['correo'];
$grupo=$_POST['grupo'];
$id=$_POST['idusuario']; 
$dep=$_POST['dep'];

# Guardar registros editados
if (isset($_POST ["Guardar"])) {
  $consultagrupo="SELECT id_grupo FROM grupos WHERE nombre ='$grupo'";
  $resultadosguardar=mysqli_query($conexioa, $consultagrupo);
  $gruposql=mysqli_fetch_array($resultadosguardar);

  $consultadep="SELECT id_departamento FROM departamentos WHERE nombre ='$dep'";
  $resultadosdep=mysqli_query($conexioa, $consultadep);
  $depsql=mysqli_fetch_array($resultadosdep);

  $sqlguardar = "UPDATE usuarios set correo='$usuario', grupo='$gruposql[0]',dep='$depsql[0]' WHERE id_usuario=$id";
  mysqli_query($conexioa, $sqlguardar);


 ?>
<script>window.location.href = window.location.href</script> 
 <?php
}
 

# ELIMINAR REGISTROS
if(isset($_POST['Eliminar'])){
  $sqleliminar="DELETE FROM usuarios WHERE id_usuario=$id";
  mysqli_query($conexioa,$sqleliminar);
  ?>
  <script>window.location.href = window.location.href</script> 
  <?php
}


# Cambiar contraseña
  if ($_POST["restablecer"]){
    $usuario=$_POST["nombreusuario"];
    
      if ($_POST['passwd'] == $_POST['passwdconf']){
        $password=$_POST['passwd'];
        $crypton = hash('sha256', $password);
        $acentos = $conexioa ->query("SET NAMES 'UTF8'");
        $sqlactualizarcontra = "UPDATE  usuarios SET contrasena='$crypton' WHERE id_usuario = '$_POST[usuariocambiar]'";
        $consulta1 = mysqli_query($conexioa, $sqlactualizarcontra);
        mysqli_close($conexioa);
        ?>

    <?php
      } else {
        ?>
    <script>alert ("Las contraseñas no coinciden, intentalo de nuevo.")</script> 
    <?php

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