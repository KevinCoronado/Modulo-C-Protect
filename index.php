<?php
include 'Modulo_C-Protect.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuela XYZ - Página de Inicio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color:rgba(51, 191, 147, 0.94);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color:rgba(37, 157, 113, 0.98);
            padding: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .hero {
            text-align: center;
            padding: 50px 20px;
            background: url('escuela.jpg') no-repeat center center/cover;
            color: white;
            font-size: 28px;
            font-weight: bold;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 5px black;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            color: #004080;
            margin-bottom: 20px;
        }

        .footer {
            background-color:rgba(37, 157, 113, 0.98);x
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <header>Universidad Tecnologica Gral. Mariano Escobedo</header>

    <nav>
        <a href="#">Oferta educativa</a>
        <a href="#">Servicios escolares</a>
        <a href="#">Acerca de</a>
        <a href="#">Servicios estudiantiles</a>
        <a href="#">Vinculacion</a>
    </nav>

    <div class="hero">
        ¡Bienvenidos a la Universidad Tecnológica Gral. Mariano Escobedo! Excelencia en educación.
    </div>

    <div class="container">
        <h2>Sobre Nosotros</h2>
        <p>La Universidad Tecnológica Gral. Mariano Escobedo, es una escuela pública de nivel superior desde septiembre de 1998. Nuestra oferta educativa consta de 8 licenciaturas e ingenierías. Ofrecemos becas externas e internas, actividades culturales y deportivas, todo esto y más en nuestras instalaciones de primer nivel. </p>
    </div>

    <div class="container">
        <h2>Nuestros Valores</h2>
        <ul>
            <li>Calidad educativa</li>
            <li>Respeto y responsabilidad</li>
            <li>Innovación y creatividad</li>
            <li>Trabajo en equipo</li>
        </ul>
    </div>

    <div class="footer">
        &copy; 2025 Escuela XYZ. Todos los derechos reservados.
    </div>

</body>
</html>
