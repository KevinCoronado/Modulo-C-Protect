<?php
// Se incluye el archivo de cifrado
include 'Cifrado_Kiwi.php';

// La URL de la API
$url = "https://c40c-200-94-131-82.ngrok-free.app/apiConcentrado.php";

// Datos para enviar en el cuerpo de la solicitud POST
$data = array(
    'g' => '18MEC-1-D-8A',
    't' => '0',
    'c' => '2024,2024,2'
);

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'Accept-Charset: UTF-8',
));

// Ejecutar la solicitud y almacenar la respuesta
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error de cURL: ' . curl_error($ch);
} else {
    echo "Respuesta de la API: " . $response . "<br><br>";
}

// Medir tiempo de cifrado
$inicio_cifrado = microtime(true);
$array_cifrado = cifrar($response);
$fin_cifrado = microtime(true);
$mensaje_cifrado = json_encode($array_cifrado);


echo "Tiempo de cifrado: " . ($fin_cifrado - $inicio_cifrado) . " segundos<br><br>";
print_r($array_cifrado);
echo "<br><br>";

// Simulación de envío a otro archivo para descifrar
$url = 'http://127.0.0.1/Modulo_C-Protect/descifrar.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('mensaje_cifrado' => $mensaje_cifrado)));

// Medir tiempo de descifrado

$responseA = curl_exec($ch);


if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else { 
    echo("<br>");
echo("<br>");
echo("<br>");
    echo 'Respuesta del servidor: ' . $responseA . "<br><br>";
   
}

// Cerrar cURL
curl_close($ch);
?>
