<?php
session_start();



#Numeros secretos
function generarNumeroSecreto() {
    $numerosSecretos = [
        '01101110101011001010101010101000101011001111111011110011011010110101101110101110000001010101100110010010101011111001101010011110', // Bloque 1: 00:00 - 04:00
        '10101101001111100101010010011010001100100110100111010001011001001000101100111001100010101100100011110010101001000101110101001111', // Bloque 2: 04:01 - 08:00
        '11001001010011101010010010110001110011001011011111011111101100101010011001111010110111010010001101110100111010101010011000011101', // Bloque 3: 08:01 - 12:00
        '10111010010110101001101011001000101011110010010011110100011001101001110011110100111011010100001000101010001010011111100011000110', // Bloque 4: 12:01 - 16:00
        '01011010110110011010110101100010010010100110001010110111011010001111100101001010010010101010010010101010100101010001010100001100', // Bloque 5: 16:01 - 20:00
    ];


    $horaActual = (int)date("G"); 

    
    if ($horaActual >= 0 && $horaActual < 4) {
        return $numerosSecretos[0]; 
    } elseif ($horaActual >= 4 && $horaActual < 8) {
        return $numerosSecretos[1];
    } elseif ($horaActual >= 8 && $horaActual < 12) {
        return $numerosSecretos[2]; 
    } elseif ($horaActual >= 12 && $horaActual < 16) {
        return $numerosSecretos[3];
    } else {
        return $numerosSecretos[4]; 
    }
}


#Operacion XOR
function operacionXOR($bits1, $bits2) {
    $clavePrivada = '';
    for ($i = 0; $i < 128; $i++) {  
        $clavePrivada .= (int)$bits1[$i] ^ (int)$bits2[$i];
    }

    return $clavePrivada;
}


#Rotamos bits
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

function generarOrdenRevertido($orden) {
    #Se crea un array del mismo tamaño que el original (de momento todos son 0)
    $revertido = array_fill(0, count($orden), 0); 

    #Se invierten los indices
    #Los indices del orden, ahora son valores en el nuevo array
    foreach ($orden as $i => $pos) {
        $revertido[$pos] = $i;
    }

    return $revertido;
}


function permutarBits($bits, $orden) {
    $resultado = '';
 
    #Cada bit toma el indice de los digitos del orden
    foreach ($orden as $i) {
        $resultado .= $bits[$i];
    }
 
    return $resultado;
}




function unirBloquesYDecodificar($bloques){
    $bloque_descifrado = '';
    $mensaje_plano = '';
    foreach ($bloques as $bloque){
        $bloque_descifrado .= $bloque;
    }
    for ($i = 0; $i < strlen($bloque_descifrado); $i += 8) {
        $segmento = substr($bloque_descifrado, $i, 8);
        $mensaje_plano .= chr(bindec($segmento));
    }

    return $mensaje_plano;
}


function descifrar($mensaje_cifrado){
    #Proceso
    #Obtenemos el mensaje cifrado y la llave publica   
    $clave_publica = array_pop($mensaje_cifrado);
    
    #1° Fase, se define el numero secreto y se obitiene la clave privada
    $numero_secreto = generarNumeroSecreto(); 
    $clave_privada = operacionXOR($clave_publica,$numero_secreto);
    
    
    #2° Fase, se aplica la operacion XOR con los paquetes cifrados y la clave privada
    $bloques_FaseXOR = [];
    foreach ($mensaje_cifrado as $bloque_cifrado){
        $bloque_XOR = operacionXOR($bloque_cifrado, $clave_privada);
        $bloques_FaseXOR[] .= $bloque_XOR;
    }
    
    #3° Fase rotamos los bits
    $bloques_Rotados =[];
    foreach ($bloques_FaseXOR as $bloque_FaseXOR){
        $bloque_Rotado = rotarBits($bloque_FaseXOR);
        $bloques_Rotados[] .= $bloque_Rotado;
    }
    
    #Permutar bits
    #Permutacion inicial
    $orden = [19, 101, 23, 36, 42, 17, 27, 84, 103, 40, 115, 92, 83, 94, 85, 
    123, 4, 121, 28, 73, 120, 100, 55, 43, 1, 60, 77, 33, 127, 108, 66, 125, 
    110, 75, 29, 26, 25, 63, 22, 12, 79, 78, 30, 46, 82, 109, 3, 99, 89, 21, 
    2, 32, 68, 39, 118, 114, 74, 126, 7, 10, 81, 106, 58, 107, 48, 87, 71, 8, 
    16, 50, 72, 70, 96, 113, 53, 124, 37, 9, 111, 15, 59, 91, 65, 90, 49, 20, 
    34, 67, 112, 61, 88, 64, 93, 76, 117, 5, 47, 116, 86, 102, 105, 0, 44, 57, 
    6, 35, 56, 14, 119, 24, 38, 98, 18, 69, 62, 41, 95, 45, 104, 54, 80, 97, 
    13, 52, 122, 11, 31, 51];
    $ordenRevertido = generarOrdenRevertido($orden);
    
    $mensaje_descifrado = [];
    foreach ($bloques_Rotados as $bloque_rotado){
        $bloque_permutado = permutarBits($bloque_rotado,$ordenRevertido);
        $mensaje_descifrado[] .= $bloque_permutado;
    }
    
    #Unir bloques y decodificar
    $mensaje_plano = '';
    $mensaje_plano = unirBloquesYDecodificar($mensaje_descifrado);
    return($mensaje_plano);

}





?>