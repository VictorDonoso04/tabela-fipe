<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nomeMarca = $_POST["nomeMarca"];

    $url = 'https://parallelum.com.br/fipe/api/v1/carros/marcas';

    $response = file_get_contents($url);

    $marcas = json_decode($response, true);

    if (!$marcas) {
        die('Erro ao decodificar JSON.');
    }

    $codigoMarca = null;
    foreach ($marcas as $marca) {
        if (strcasecmp($marca['nome'], $nomeMarca) === 0) {
            $codigoMarca = $marca['codigo'];
            break;
        }
    }

    if ($codigoMarca) {

        $urlModelos = "https://parallelum.com.br/fipe/api/v1/carros/marcas/{$codigoMarca}/modelos";


        $responseModelos = file_get_contents($urlModelos);

        $modelos = json_decode($responseModelos, true);

        if (!$modelos) {
            die('Erro ao decodificar JSON de modelos.');
        }

        echo '<h3>Modelos disponíveis:</h3><ul>';
        foreach ($modelos['modelos'] as $modelo) {
            echo '<li>' . $modelo['nome'] . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Marca de carro não encontrada.</p>';
    }
} else {

    header("Location: index.php");
    exit;
}
?>
