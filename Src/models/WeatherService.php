<?php
namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';
use GuzzleHttp\Client;

class WeatherService
{
    private $apiKey = "59c07c5920ea31b982cfa061a97314c3";
    private $url    = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct()
    {
    }

    public function getWeatherCurl($city)
    {
        $url = $this->url . '?q=' . urlencode($city) . '&appid=' . $this->apiKey . '&units=metric';
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        if ($response === false) {
            echo "cURL Error: " . curl_error($ch);
        } else {
            $data            = json_decode($response, true);
            $currentDateTime = new \DateTime();
            $currentDate     = $currentDateTime->format('Y-m-d');
            if (isset($data['main'])) {
                echo $currentDate . "<br>";
                echo "<br>";
                echo "Condition: " . $data['weather'][0]['description'] . "<br>";
                echo "<br>";
                echo "Temperature: " . $data['main']['temp'] . " °C<br>";
                echo "<br>";
                echo "Humidity: " . $data['main']['humidity'] . " %<br>";
                echo "<br>";
                echo "Feels Like: " . $data['main']['feels_like'] . " °C<br>";
            } else {
                echo "Error: Could not retrieve weather data for '$city'. Please try again.";
            }
        }
        curl_close($ch);
    }

    public function getWeatherGuzzle($city)
    {
        try {
            $client   = new Client();
            $response = $client->request('GET', $this->url, [
                'query' => [
                    'q'     => $city,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data && isset($data['main'])) {
                echo "City: " . $data['name'] . "<br>";
                echo "Temperature: " . $data['main']['temp'] . " °C<br>";
                echo "Humidity: " . $data['main']['humidity'] . " %<br>";
            } else {
                echo "Error: Unable to retrieve valid weather data.";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
