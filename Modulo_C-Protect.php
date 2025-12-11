<?php
session_start();



function verificar_frecuencia_visitas($max_visitas = 10, $intervalo_segundos = 10) {
    #Si no esta la variable visitas, la crea
    if (!isset($_SESSION['visitas'])) {
        $_SESSION['visitas'] = [];
    }

    $tiempo_actual = time();

    
    #Se filtran las visitas tomando en cuenta solo las que ocurren en el tiempo establecido
    #Cada visita se guarda, las que hayan pasado antes del tiempo estimado, se eliminan
    $_SESSION['visitas'] = array_filter($_SESSION['visitas'], function($timestamp) use ($tiempo_actual, $intervalo_segundos) {
        return ($tiempo_actual - $timestamp) < $intervalo_segundos;
    });

    #La variable visitas se toma como el tiempo actual en el que se acaba de entrar
    $_SESSION['visitas'][] = $tiempo_actual;

    #Si las visitas sobrepasan el maximo de visitas, el usuario es mandado al captcha
    if (count($_SESSION['visitas']) > $max_visitas) {
        header("Location: captcha.html");
        exit();
    }

    
}

function generar_captcha(){
    #El codigo se compone del siguiente alfabeto y se compone de 5 caracteres
    #str_Shuffle reorganiza aleatoriamente el string y subsrt substrae una porcion
    $codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'),0,5);
    
    #Parametros de la creacion de imagen del captcha
    $ancho = 150;
    $alto = 50;
    $fuente = realpath('Consolas.ttf');
    $tamanioFuente = 35;

    #Se hashea el codigo para aumentar la seguridad
    $_SESSION['codigo_verificacion'] = sha1($codigo);

    #Se crea la imagen
    $imagen = imagecreatetruecolor($ancho, $alto);
    $colorFondo = imagecolorallocate($imagen, 255, 255,255);
    imagefill($imagen, 0,0, $colorFondo);
    $colorText = imagecolorallocate($imagen, 50, 50,50);
    $colorSecundario = imagecolorallocate($imagen, 0, 0 ,128);

    #Se crean lineas que dificultan la percepcion de la imagen del captcha
    for($i = 0; $i < 6; $i++){
        imageline($imagen, 0,  rand(0,$alto),$ancho, rand(0,$alto), $colorSecundario);
    }

    #Se crean aberraciones que dificultan la percepcion de la imagen del captcha
    for($i = 0; $i < 1000; $i++){
        imagesetpixel($imagen, rand(0,$ancho), rand(0,$alto), $colorSecundario);

    }


    imagettftext($imagen, $tamanioFuente,-5,10,35, $colorText, $fuente, $codigo);
    header('Content-Type: image/png');
    imagepng($imagen);
    exit();
}



function verificar_captcha() {
    #Si recibimos el codigo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        #Se eliminan los espacios
        $codigo_ingresado = trim($_POST['codigo_ingresado']);
        #Si el codigo de verificacion existe y si este es igual al ingresado, permitira el acceso
        if (isset($_SESSION['codigo_verificacion']) && sha1($codigo_ingresado) === $_SESSION['codigo_verificacion']) {
            unset($_SESSION['codigo_verificacion']);
            header("Location: index.php");
            exit();
        } else {
        #Se crea una alerta en caso de no detectar o fallar el captcha
            echo "<script>alert('Código incorrecto. Inténtelo de nuevo.'); window.history.back();</script>";
        }
    }
}


function expirarSesion() {
    #15 minutos de tolerancia
    $tiempo_limite = 10; 

    #Crea la variable ultimo acceso
    if (!isset($_SESSION['ultimo_acceso'])) {
        $_SESSION['ultimo_acceso'] = time();
        return true;
    }


    #Si al restar el tiempo actual con el del ultimo acceso es menor al tiempo limite
    if (time() - $_SESSION['ultimo_acceso'] > $tiempo_limite) {
        #Se elimina la sesion
        session_unset();
        session_destroy();
        return false;
    }
    #Se actualiza el tiempo de ultimo acceso al ingresar en otra pagina
    $_SESSION['ultimo_acceso'] = time(); 
    return true;
}

function verificarIP() {
    #Se establece una subred
    $subred_permitida = "127.0.0.0";
    $mascara = 24;
    #Se verifica si existen cabeceras que son añadidas por proxys para ocultar la IP de origen
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip =  explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $ip =  $_SERVER['HTTP_X_REAL_IP'];
    } else {
    #Esta cabecera es la que realmente tiene la IP origen sin uso de proxys
        $ip =  $_SERVER['REMOTE_ADDR'];
    }


    #ip2long convierte el numero ip en un numero decimal
    $ip_numerica = ip2long($ip);
    $subred_numerica = ip2long($subred_permitida);
    #Se calculan los bits que no pertenecen a la subred
    #Aqui se dezplaza 1 a la izquierda despues de 8 posiciones en 0
    $mascara_numerica = -1 << (32 - $mascara);

    #Si la ip y la mascara coincide con la entrante entonces se permite el acceso
    #Se compara bit a bit mediante  el metodo AND para verificar las IP's
    if (($ip_numerica & $mascara_numerica) === ($subred_numerica & $mascara_numerica)){
        return true;
    } else{
        return false;
    }

}



#las siguiente lineas aplican las funciones al entrar a la pagina

#Si es falso se bloquea la pagina
if (!verificarIP()) {
    header("Location: Bloqueo_de_pagina.html"); 
    exit();
}

#Checar la sesion
if (!expirarSesion()){
    header("Location: sesion_Expirada.html");
    exit();
}

#Si no hay captcha se genera uno
if (isset($_GET['captcha'])) {
    generar_captcha();
}

#Se recibe el captcha y se manda a verificar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    verificar_captcha();
}

#Estar constantemente checando las visitas
verificar_frecuencia_visitas();


?>
