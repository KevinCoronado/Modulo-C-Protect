<?php

// Se incluye el archivo de cifrado
include 'Cifrado_Kiwi.php';

/* 
    Este script sirve como ejemplo para mostrar el funcionamiento 
    del cifrado utilizando JSON.
*/

// Datos de ejemplo en formato array
$array = [
  "nombre" => "Juan Ñáñes",
  "edad" => 25,
  "ciudad" => "México¿?",
  "squadName" => "Super hero squad ÑÑ",
  "homeTown" => "Metro City",
  "formed" => 2016,
  "secretBase" => "Super tower",
  "active" => true,
  "members" => [
      [
          "name" => "Molecule Man",
          "age" => 29,
          "secretIdentity" => "Dan Jukes",
          "powers" => ["Radiation resistance", "Turning tiny", "Radiation blast"]
      ],
      [
          "name" => "Madame Uppercut",
          "age" => 39,
          "secretIdentity" => "Jane Wilson",
          "powers" => [
              "Million tonne punch",
              "Damage resistance",
              "Superhuman reflexes"
          ]
      ],
      [
          "name" => "Eternal Flame",
          "age" => 1000000,
          "secretIdentity" => "Unknown",
          "powers" => [
              "Immortality",
              "Heat Immunity",
              "Inferno",
              "Teleportation",
              "Interdimensional travel"
          ]
      ]
  ]
];

// Convertir el array a JSON, sin escapar caracteres Unicode
$arrayJson = json_encode($array, JSON_UNESCAPED_UNICODE);


// Mostrar los datos JSON para comprobar
echo "Inicio del mensaje \n";
echo("<br>");
print_r($arrayJson);
echo("<br>");
echo("<br>");
echo("<br>");


// Cifrado de los mensajes (la entrada debe ser un string)
$mensaje_cifradoA = cifrar($arrayJson);


// Mostrar los mensajes cifrados
echo "<pre>";
echo "El paquete cifrado enviado \n";
echo "</pre>";
echo("<br>");
print_r($mensaje_cifradoA);
echo("<br>");




// Convertir los mensajes cifrados a JSON (no es obligatorio que sea JSON, pero se convierte a string)
$mensaje_cifrado_jsonA = json_encode($mensaje_cifradoA);




$url = 'http://127.0.0.1/Modulo_C-Protect/descifrar.php';

$ch = curl_init($url);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('mensaje_cifrado' => $mensaje_cifrado_jsonA)));
$responseA = curl_exec($ch);




if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    
    echo 'Respuesta del servidor: ' . $responseA;
}


echo("<br>");
echo("<br>");
echo("<br>");




curl_close($ch);
?>
