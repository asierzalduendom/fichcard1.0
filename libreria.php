<?php
function validar_dni($dnient){
      $dni=ucfirst($dnient);
      $letra = substr($dni, -1);
      $letramayus=strtoupper($letra);
      $numeros = substr($dni, 0, -1);
      if ( substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letramayus && strlen($letramayus) == 1 && strlen ($numeros) == 8 ){
        return true;
      }else{
        return false;
      }
    }

    ?>

    