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
    
</head>
<form method="post" action="">
    <legend>DNI</legend>
    <input type="text" name="dni" requiered>
<legend>Nombre</legend>
    <input type="text" name="nombre" autocomplete="off" required></td>
    <legend>Apellido</legend>
    <input type="text" name="apellido" autocomplete="off" required></td>
    <legend>Dirección</legend>
    <input type="text" name="direccion" required>
    <legend>Telefono</legend>
    <input type="number" name="telefono" required>
  <legend>Correo</legend>
    <input type="email" name="correo" autocomplete="off" required></td>

  <legend>Contraseña</legend>
    <input type="password" name="password" autocomplete="off" required></td>
  <legend>Confirmar contraseña</legend>
    <input type="password" name="confpassword"  autocomplete="off"required></td>
  <legend>Grupo</legend>
    <select name="grupo">
     <?php
     include('session.php');
     include('libreria.php');
 $consultagrupos="SELECT id_grupo,nombre FROM grupos";
 $resultados=mysqli_query($conexioa, $consultagrupos);
 while ($fila = $resultados->fetch_row()) {
     ?>
         <option value="<?php echo $fila[0];?>"><?php echo $fila[1];}?></option>
     </select>
     <legend>Departamento</legend>
     <select name="dep">
     <?php
 $consultadep="SELECT id_departamento,nombre FROM departamentos";
 $resultados=mysqli_query($conexioa, $consultadep);
 while ($dep = $resultados->fetch_row()) {
     ?>
         <option value="<?php echo $dep[0];?>"><?php echo $dep[1];}?></option>
     </select>
     <br>
     <br>
     <input type="submit" name="Insertar" value="Registrar usuario">
   
   </form>


   <?php
if(isset($_POST['Insertar'])){
    $dni=$_POST['dni'];
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $direccion=$_POST['direccion'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];
    $password=$_POST['password'];
    $confpassword=$_POST['confpassword'];
    $grupo=$_POST['grupo'];
    $departamento=$_POST['dep'];
    $userexits="SELECT id_usuario FROM usuarios where correo ='$correo'";
    $resultadousers=mysqli_query($conexioa,$userexits);
    $countusers=mysqli_num_rows($resultadousers);
    $valido=validar_dni($dni);
    
    if($countusers == 0){
        if(($_POST['correo'] == null || $_POST['password'] == null || $_POST['confpassword'] == null || $_POST['grupo'] == null || $_POST['dep'] == null || $_POST['nombre'] == null || $_POST['apellido'] == null || $_POST['direccion'] == null || $_POST['telefono'] == null || $_POST['dni'] == null)){
            ?>
                <script>alert("Un campo o varios no pueden estar vacios.")</script>
                <?php
        }else{
           
            if($valido){
                if(is_numeric($telefono) && strlen($telefono) == 9){
            if($_POST['password'] == $_POST['confpassword']){
                
                $passwordhash= hash('sha256', $password);
                $sqlinsertar="INSERT INTO usuarios(correo,contrasena,grupo,dep) VALUES ('$correo','$passwordhash',$grupo,$departamento);";
                mysqli_query($conexioa,$sqlinsertar);
                $selectusuarioinsertado="SELECT id_usuario FROM usuarios WHERE correo='$correo'";
                $resultadoiduser=mysqli_query($conexioa,$selectusuarioinsertado);
                $datos=mysqli_fetch_array($resultadoiduser);

                $sqlinsertarempleado="INSERT INTO empleados(dni,nombre,apellido,direccion,telefono,usuario) VALUES ('$dni','$nombre','$apellido','$direccion','$telefono',$datos[0]);";
                $queryempleado=mysqli_query($conexioa,$sqlinsertarempleado);
                if($resultadoiduser && $queryempleado){
                    ?>
                <script>alert("Empleado registrado correctamente.")</script>
                <?php
                }else{
                    ?>
                <script>alert("Ha ocurrido un error al registrar el empleado.")</script>
                <?php
                }
            }else{
                ?>
                <script>alert("Las contraseñas no coinciden, intentalo de nuevo.")</script>
                <?php
            }
        }else{
            ?>
                <script>alert("Telefono introducido no valido")</script>
                <?php
        }
        }elseif ($valido == null){
            ?>
                <script>alert("El DNI no cumple los requisitos.")</script>
                <?php
        }
        }
    }else{
        ?>
        <script>alert("Ya existe un usuario con el correo introducido")</script>
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
