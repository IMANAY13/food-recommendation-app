<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$config = require 'config.php';

function getRecommendation($preferences) {
    $client = new Client([
        'base_uri' => $config['personalizer_endpoint'],
        'headers' => [
            'Ocp-Apim-Subscription-Key' => $config['personalizer_key'],
            'Content-Type' => 'application/json',
        ],
    ]);

    $contextFeatures = [
        ['name' => 'Spicy', 'value' => $preferences['spicy']],
        ['name' => 'Vegan', 'value' => $preferences['vegan']],
        ['name' => 'GlutenFree', 'value' => $preferences['glutenFree']],
    ];

    $actions = [
        ['id' => 'Pizza', 'features' => [['type' => 'Spicy', 'value' => true]]],
        ['id' => 'Salad', 'features' => [['type' => 'Vegan', 'value' => true]]],
        ['id' => 'Burger', 'features' => [['type' => 'GlutenFree', 'value' => false]]],
    ];

    $body = json_encode([
        'contextFeatures' => $contextFeatures,
        'actions' => $actions,
        'excludedActions' => [],
        'eventId' => 'recommendation-' . time(),
    ]);

    $response = $client->post('/personalizer/v1.0/rank', ['body' => $body]);
    $responseData = json_decode($response->getBody(), true);

    return $responseData['rewardActionId'] ?? 'No recommendation';
}

// Proses permintaan dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preferences = [
        'spicy' => isset($_POST['spicy']),
        'vegan' => isset($_POST['vegan']),
        'glutenFree' => isset($_POST['glutenFree']),
    ];

    $recommendation = getRecommendation($preferences);
    echo json_encode(['recommendedFood' => $recommendation]);
}