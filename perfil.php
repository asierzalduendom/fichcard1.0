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

<?php
include('session.php');
$correo=$_SESSION['login_user'];
$consultaperfil="SELECT dni,empleados.nombre,apellido,telefono,direccion,correo,grupos.nombre, departamentos.nombre FROM empleados join usuarios on empleados.usuario = usuarios.id_usuario join departamentos on usuarios.dep = departamentos.id_departamento join grupos on grupos.id_grupo = usuarios.grupo where correo ='$correo'";
$resultadoperfil=mysqli_fetch_array(mysqli_query($conexioa,$consultaperfil));
?>
<div class="datoperfil"><h3>DNI</h3>
<h6><?php echo $resultadoperfil[0];?></h6></div>

<div class="datoperfil"><h3>Nombre</h3>
<h6><?php echo $resultadoperfil[1];?></h6></div>
<div class="datoperfil"><h3>Apellido </h3>
<h6><?php echo $resultadoperfil[2];?></h6></div>
<div class="datoperfil"><h3>Telefono </h3>
<h6><?php echo $resultadoperfil[3];?></h6></div>

<div class="datoperfil"><h3>Direccion</h3>
<h6><?php echo $resultadoperfil[4];?></h6></div>

<div class="datoperfil"><h3>Correo</h3>
<h6><?php echo $resultadoperfil[5];?></h6></div>

<div class="datoperfil"><h3>Grupo</h3>
<h6><?php echo $resultadoperfil[6];?></h6></div>

<div class="datoperfil"><h3>Departamento</h3>
<h6><?php echo $resultadoperfil[7];?></h6></div>


<button class="restablecer_fuera" onclick="document.getElementById('id01').style.display='block'">Cambio de contraseña</button>

<div id="id01" class="modals">
  
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
     
    </div>

    <div class="contenedor">
      <input type="password" placeholder="Contraseña actual" name="contraact" required class="inputcambiarcontra">
      <br>
      <br>
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
# Cambiar contraseña
  if ($_POST["restablecer"]){
    $passactual=hash('sha256', $_POST['contraact']);
  
    $checkusuario="SELECT correo from usuarios where contrasena='$passactual' and correo='$correo'";
    $resultusercheck=mysqli_fetch_array(mysqli_query($conexioa,$checkusuario));
    if($resultusercheck[0] == $correo){
      if ($_POST['passwd'] == $_POST['passwdconf']){
        $password=$_POST['passwd'];
        $crypton = hash('sha256', $password);
        $acentos = $conexioa ->query("SET NAMES 'UTF8'");
        $sqlactualizarcontra = "UPDATE  usuarios SET contrasena='$crypton' WHERE correo = '$correo'";
        $consulta1 = mysqli_query($conexioa, $sqlactualizarcontra);
        mysqli_close($conexioa);
        ?>

    <?php
      } else {
        ?>
    <script>alert ("Las contraseñas no coinciden, intentalo de nuevo.")</script> 
    <?php

      }
    }else{
      ?>
      <script>alert ("Autenticación incorrecta, intentalo de nuevo.")</script> 
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