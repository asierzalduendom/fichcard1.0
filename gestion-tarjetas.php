<?php
include('session.php');
$correo=$_SESSION['login_user'];
$_POST['tipo-tajeta']="";
$selectusuarios="SELECT id_usuario FROM usuarios WHERE correo='$correo'";
$iduser=mysqli_fetch_array(mysqli_query($conexioa,$selectusuarios));

$sqlpermisos="SELECT permisos.activo FROM usuarios join grupos on usuarios.grupo = grupos.id_grupo join permisos on grupos.id_grupo = permisos.grupo where accion ='$_SERVER[REQUEST_URI]' and correo ='$correo'";
$resultados_permisos=mysqli_query($conexioa,$sqlpermisos);
$arrayDatos = mysqli_fetch_array($resultados_permisos);

if ($arrayDatos[0] == "on"){
$_SESSION['tipotarjeta'] = $_POST['tipo-tarjeta'];
?>

<head>
<link type="text/css" href="/css/estilos.css" rel="stylesheet"/>
<script>
      function submitForm(elem) {
          if (elem.value) {
              elem.form.submit();
          }
      }
  </script>
</head>
<form method="post" action="">
    
<?php
$tarjeta=file_get_contents('http://10.122.27.162:4000/infocards3/user1/');
$key="KeyMustBe16ByteOR24ByteOR32ByT3!";
$encrypted_data = base64_decode($tarjeta);

$cookie = openssl_decrypt($encrypted_data, 'AES-256-ECB',$key,OPENSSL_RAW_DATA);
$json = json_decode($cookie);
$activa = $json->current_card;
$num_inter = $json->card_international;
$num_europ = $json->card_europe;

if($activa == "INTERNATIONAL"){
    echo "<h3> Tarjeta Internacional</h3>";
    echo "<br><br><label class='switch'>
    <input type='checkbox' onchange='submitForm(this)' name='tipo-tarjeta'  active='yes'>
    <span class='slider round'></span></label>";
    echo "<div class='inter_card'>
    <div class='num_tarjeta'>$num_inter</div>
    <div class='tipo_tarjetas'>FICHCARD S.L</div>
    <div class='fecha_caducidad'>04/23</div>
    </div>";


}elseif($activa == "EUROPE"){
    echo "<h3> Tarjeta Europea</h3>";
    echo "<br><br><label class='switch'>
    <input type='checkbox' onchange='submitForm(this)' name='tipo-tarjeta' >
    <span class='slider round'></span></label>";
    echo "<div class='europe_card'>
    <div class='num_tarjeta'>$num_europ</div>
    <div class='tipo_tarjetas'>FICHCARD S.L</div>
    <div class='fecha_caducidad'>10/25</div>
    </div>";   

}
?>
<form>
    <?php
    if($_POST['tipo-tarjeta']){
        if($activa == "EUROPE"){
            $tarjeta=file_get_contents('http://10.122.27.162:4000/enablecard3/user1/INTERNATIONAL');
            $key="KeyMustBe16ByteOR24ByteOR32ByT3!";
            $encrypted_data = base64_decode($tarjeta);
            
            $cookie = openssl_decrypt($encrypted_data, 'AES-256-ECB',$key,OPENSSL_RAW_DATA);
            $json = json_decode($cookie);
            ?>
            <script>window.location.href = window.location.href</script>
            <?php
        }elseif($activa == "INTERNATIONAL"){
            $tarjeta=file_get_contents('http://10.122.27.162:4000/enablecard3/user1/EUROPE');
            $key="KeyMustBe16ByteOR24ByteOR32ByT3!";
            $encrypted_data = base64_decode($tarjeta);
            
            $cookie = openssl_decrypt($encrypted_data, 'AES-256-ECB',$key,OPENSSL_RAW_DATA);
            $json = json_decode($cookie);
            ?>
            <script>window.location.href = window.location.href</script>
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
