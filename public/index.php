<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    // require_once __DIR__ . '/../Src/models/WeatherService.php';
    // require_once __DIR__ . '/../Src/Views/WeatherForm.php';

    use App\Models\WeatherService;
    use App\Views\WeatherForm;

    $weatherForm    = new WeatherForm();
    $weatherService = new WeatherService();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Weather Forecast</h1>
    <?php
        echo $weatherForm->render();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ! empty($_POST['city'])) {
            echo "<div class='weather-result'>";
            // $weatherService->getWeatherGuzzle($_POST['city']);
            $weatherService->getWeatherCurl($_POST['city']);
            echo "</div>";
        }
    ?>
</body>
</html>
