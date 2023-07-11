<?php
session_start();

// Obtener los datos enviados desde el formulario
if (isset($_POST['edad']) && isset($_POST['peso'])) {
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];

    // Verificar la categoría según la edad
    if ($edad >= 0 && $edad <= 12) {
        $categoria = 'Niños';
    } elseif ($edad >= 13 && $edad <= 29) {
        $categoria = 'Jóvenes';
    } elseif ($edad >= 30 && $edad <= 59) {
        $categoria = 'Adultos';
    } else {
        $categoria = 'Viejos';
    }

    // Almacenar los datos en un array en la sesión
    if (!isset($_SESSION['muestreo'])) {
        $_SESSION['muestreo'] = array();
    }

    $_SESSION['muestreo'][] = array('edad' => $edad, 'peso' => $peso, 'categoria' => $categoria);
}

// Calcular el promedio de peso en cada categoría
$categorias = array('Niños', 'Jóvenes', 'Adultos', 'Viejos');
$promedios = array();

foreach ($categorias as $categoria) {
    $pesos = array();
    foreach ($_SESSION['muestreo'] as $registro) {
        if ($registro['categoria'] === $categoria) {
            $pesos[] = $registro['peso'];
        }
    }
    if (!empty($pesos)) {
        $promedios[$categoria] = array_sum($pesos) / count($pesos);
    } else {
        $promedios[$categoria] = 0;
    }
}

// Mostrar los resultados
echo "<h2>Resultados</h2>";
foreach ($promedios as $categoria => $promedio) {
    echo "$categoria: $promedio<br>";
}
?>
