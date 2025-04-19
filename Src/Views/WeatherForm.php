<?php
namespace App\Views;

class WeatherForm
{
    private $cities;

    public function __construct()
    {
        $jsonPath     = __DIR__ . '/../../city.list.json';
        $this->cities = json_decode(file_get_contents($jsonPath), true);
    }

    public function render()
    {
        $options = '';
        foreach ($this->cities as $city) {
            $options .= "<option value='{$city['name']}'>{$city['name']}</option>";
        }

        return <<<HTML
        <form method='POST' class="weather-form">
            <select name='city' class="city-select">
                <option value="">Select a city</option>
                {$options}
            </select>
            <button type='submit' class="submit-btn">Get Weather</button>
        </form>
        HTML;
    }
}
