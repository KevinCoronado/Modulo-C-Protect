<?php
#init y gmp
# Criptografía moderna
 
 
####################### Codificador #############################


function codificarABinarioYSacarBloques($string){
    # El paquete se convierte en binario

    $binario = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $binario .= str_pad(decbin(ord($string[$i])), 8, '0', STR_PAD_LEFT);
    }

    # Se generan bloques de 128 bits
    $tamanoBloque = 128;
    #Mide la longitud del binario y lo divide entre 128 para sacar el numero de bloques
    $numBloques = ceil(strlen($binario) / $tamanoBloque);
    
    # Separación
    $bloques = [];
    for ($i = 0; $i < $numBloques; $i++) {
        $inicio = $i * $tamanoBloque;
        $bloque = substr($binario, $inicio, $tamanoBloque);
        #El bloque sale como string de 128 bits
    
        # Rellenar el último bloque a 128 bits
        if (strlen($bloque) < $tamanoBloque) {
            #Rellenar con 0 hasta que se complete el bloque
            $bloque .= str_repeat("0", $tamanoBloque - strlen($bloque));
        }
    
        #Cada bloque se mete en un array
        $bloques[] = $bloque;

    }


    return $bloques;

} 
 
 
###################### Creacion de claves #################################
function generarClavePrivada() {
    #La clave privada se genera aleatoriamente
    $clavePrivada = '';
    for ($i = 0; $i < 128; $i++) {
        $clavePrivada .= rand(0, 1); 
    }
    return $clavePrivada;
}


function generarNumeroSecreto() {
    #Se crea una lista de 5 bloques secretos que cambia dependiendo el horario
    $numerosSecretos = [
        '01101110101011001010101010101000101011001111111011110011011010110101101110101110000001010101100110010010101011111001101010011110', // Bloque 1: 00:00 - 04:00
        '10101101001111100101010010011010001100100110100111010001011001001000101100111001100010101100100011110010101001000101110101001111', // Bloque 2: 04:01 - 08:00
        '11001001010011101010010010110001110011001011011111011111101100101010011001111010110111010010001101110100111010101010011000011101', // Bloque 3: 08:01 - 12:00
        '10111010010110101001101011001000101011110010010011110100011001101001110011110100111011010100001000101010001010011111100011000110', // Bloque 4: 12:01 - 16:00
        '01011010110110011010110101100010010010100110001010110111011010001111100101001010010010101010010010101010100101010001010100001100', // Bloque 5: 16:01 - 20:00
    ];

    #Se saca la hora actual
    $horaActual = (int)date("G");

    #Dependiendo la hora se eligira un bloque
    if ($horaActual >= 0 && $horaActual < 4) {
        return $numerosSecretos[0]; # Bloque 1: 00:00 - 04:00
    } elseif ($horaActual >= 4 && $horaActual < 8) {
        return $numerosSecretos[1]; # Bloque 2: 04:01 - 08:00
    } elseif ($horaActual >= 8 && $horaActual < 12) {
        return $numerosSecretos[2]; # Bloque 3: 08:01 - 12:00
    } elseif ($horaActual >= 12 && $horaActual < 16) {
        return $numerosSecretos[3]; # Bloque 4: 12:01 - 16:00
    } else {
        return $numerosSecretos[4]; # Bloque 5: 16:01 - 12:59
    }
}


 
#################### Encriptacion  ####################################################
 
#1er paso, permutacion (cambiar de posicion de los bits)
function permutarBits($bits, $orden) {
    #Permutacion
    
    $resultado = '';
 
    #Cada bit toma el indice de los digitos del orden
    foreach ($orden as $i) {
        $resultado .= $bits[$i];
    }
 
    return $resultado;
}
 

#2da fase, Rotacion de bits

function rotarBits($bits){
    
    $resultado = '';
    $longitud = strlen($bits);
    
    #cada 8 bits, los 4 primeros pasan a la posicion de los 4 ultimos 
    for ($i=0; $i<$longitud;$i+=8){
        #Se extrae una porcion de bits
        $grupo = substr($bits,$i,8);
        #Se toman los 4 ultimos y los 4 primeros
        $nuevo_grupo = substr($grupo,4,4) . substr($grupo,0,4);
        $resultado .= $nuevo_grupo;
    }
 
    return $resultado;
}
 

 
 
#3ra fase, Operacion XOR 
function operacionXOR($bits,$bits2){
    $resultado = '';
    for ($i = 0;$i < strlen($bits);$i++){
        $resultado .=(int)$bits[$i] ^ (int)$bits2[$i];
 
    }
    return $resultado;
}


function cifrar($mensaje){
    #Codificacion
    $bloques = codificarABinarioYSacarBloques($mensaje);
    $orden = [19, 101, 23, 36, 42, 17, 27, 84, 103, 40, 115, 92, 83, 94, 85, 
    123, 4, 121, 28, 73, 120, 100, 55, 43, 1, 60, 77, 33, 127, 108, 66, 125, 
    110, 75, 29, 26, 25, 63, 22, 12, 79, 78, 30, 46, 82, 109, 3, 99, 89, 21, 
    2, 32, 68, 39, 118, 114, 74, 126, 7, 10, 81, 106, 58, 107, 48, 87, 71, 8, 
    16, 50, 72, 70, 96, 113, 53, 124, 37, 9, 111, 15, 59, 91, 65, 90, 49, 20, 
    34, 67, 112, 61, 88, 64, 93, 76, 117, 5, 47, 116, 86, 102, 105, 0, 44, 57, 
    6, 35, 56, 14, 119, 24, 38, 98, 18, 69, 62, 41, 95, 45, 104, 54, 80, 97, 
    13, 52, 122, 11, 31, 51];
    #Se inicia la variable bloques_permutados
    $bloques_permutados = [];
    #Recorre cada bloque y le aplica la funcion permutar bits
    foreach ($bloques as $bloque){
        $bloque_permutado = permutarBits($bloque,$orden);
        $bloques_permutados[] .= $bloque_permutado;
    }

    #Rotacion de bits
    #Se inicia la variable bloques_rotados
    $bloques_rotados = [];
    #Se recorre cada bloque y se le aplica la funcion rotarBits
    foreach ($bloques_permutados as $bloque_permutado){
        $bloque_rotado = rotarBits($bloque_permutado);
        $bloques_rotados[] .= $bloque_rotado;
 
    }
    
    #Claves
    #Se obtiene el valor del bloque secreto
    $numeroSecreto = generarNumeroSecreto();

    #Se obtienen la clave Privada y la clave Publica
    $clavePrivada = generarClavePrivada();
    $clavePublica = operacionXOR($clavePrivada, $numeroSecreto);
    
    #Operacion XOR con la clave privada
    $bloques_cifrados = [];
    foreach ($bloques_rotados as $bloque_rotado){
        $bloque_cifrado = operacionXOR($bloque_rotado,$clavePrivada);
        $bloques_cifrados[] .= $bloque_cifrado;
    }

    #Se adjunta al mensaje la clave publica
    $bloques_cifrados[] .= $clavePublica;

    #Regresa un array
    return $bloques_cifrados;
}


$simulacro = cifrar('ñ');





   

 
?>