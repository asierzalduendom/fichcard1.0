<html style="background-color:#8A0808;">
   <head>
      <title>Iniciar sesion | Fichcard</title>
      <link type="text/css" href="/css/estilos.css" rel="stylesheet"/>
 <link rel="shortcut icon" type="img/png" href="./img/favicon.png">
</head>
   <header>
    </header>
   <body>
     <form action="" method="post">
  <div class="imgcontainer">
      <a href="login.php"><img src="/img/logo_blanco.png" class="imagenindexlogin" ></a>
  </div>
  <div class="div-login">
    
    <br><input class="input" id="animacion" type="text" placeholder="Usuario" name="usernamelogin" required autocomplete="off">
    <br>
    <input class="input" id="animacion" type="password" placeholder="Contraseña" name="loginpassword" required autocomplete="off">
    <br>
    <button class="button"type="submit">Iniciar sesión</button>
  </div>
</form>
<?php
   include("config.php");
   session_start();
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {

      $myusername =$_POST['usernamelogin'];
      $mypassword = $_POST['loginpassword'];
      $crypton = hash('sha256', $mypassword);
      //$sql= "insert into usuarios values ('2','admin@gmail.com', 'hola',null,null)";
      $sql = "SELECT id_usuario FROM usuarios WHERE correo = '$myusername' and contrasena = '$crypton'";
      $result = mysqli_query($conexioa,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      $ip=$_SERVER['REMOTE_ADDR'];


      if($count == 1) {

       header("location: https://10.122.27.105/");

         

         //if ($count1 == 1) {
           $_SESSION['login_user'] = $myusername;
           /* $sql2 = "INSERT INTO `accesos`(`username`,`result`,`fecha`,`source`) VALUES('$myusername',1,now(),'$ip');";
            $result2 = mysqli_query($conexioa,$sql2);
           

         }*/
     }else {
       //  $sql2 = "INSERT INTO `accesos`(`username`,`result`,`fecha`,`source`) VALUES('$myusername',0,now(),'$ip');";
        // $result2 = mysqli_query($conexioa,$sql2);
        echo "<h6 class='error'>Credenciales introducidas erroneas, int&eacute;ntalo de nuevo</h6>";

     }
  }
?>
           </div>
        </div>
     </div>
  </body>
</html>
