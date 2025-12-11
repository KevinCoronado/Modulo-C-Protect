<?php
include 'Descifrado_Kiwi.php';
#Se llama al descifrado

######## Esta pagina solo sirve como ejemplo del funcionamiento del descifrado #######

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mensaje_cifrado'])) {
        $mensaje_cifrado_json = $_POST['mensaje_cifrado'];
        #El mensaje llega en string pero lo OCUPAMOS EN ARRAY
        $mensaje_cifrado = json_decode($mensaje_cifrado_json, true); #Convertir de JSON (String) a array

        if (is_array($mensaje_cifrado)) {
            echo("<br>");
            echo "El mensaje descifrado recibido es: ";
            #se descifra el mensaje
            $inicio_descifrado = microtime(true);
            $mensaje_descifrado = descifrar($mensaje_cifrado);
            $fin_descifrado = microtime(true);
            echo($mensaje_descifrado);
            echo("<br>");
echo("<br>");
echo("<br>");
            echo "Tiempo de descifrado: " . ($fin_descifrado - $inicio_descifrado) . " segundos<br><br>";
        } else {
            echo "El mensaje cifrado no es un array ";
        }
    } else {
        echo "No se recibió ningún mensaje cifrado.";
    }
} 
?>