<?php
    session_start();
    
    // Creo los valores aleatorios y guardo el resultado
    $Valor1 = rand(1,7);
    $Valor2 = rand(1,7);
    $_SESSION["ResultadoCaptcha"] = $Valor1 + $Valor2;
    
    // Creo una imagen vacia de 120x30 a la que pintaremos el fondo transparente y los valores en negro
    $Imagen = imagecreatetruecolor(80, 40);
    $Color_Fondo = imagecolorallocate($Imagen, 255, 255, 255);
    imagefill($Imagen, 0, 0, $Color_Fondo);
    $Color_Texto = imagecolorallocate($Imagen, 0, 0, 0);
    imagestring($Imagen, 4, 5, 9,  $Valor1." + ".$Valor2." =", $Color_Texto);
    
    // Cabecera para la imagen PNG
    header('Content-Type: image/png');
    
    // Imprimo la imagen
    imagepng($Imagen);
    
    // Liberar memoria
    imagedestroy($Imagen);
?>