<?php

require '../vendor/autoload.php';

use Guzzle\Http\Exception\ClientErrorResponseException;
use Omnipay\GoPay\GatewayFactory;
use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__ . '/..');
$dotenv->load();

$goId = $_ENV['GO_ID'];
$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];

$gateway = GatewayFactory::createInstance($goId, $clientId, $clientSecret, true);

try {
    $returnUrl = 'http://localhost:8000/gateway-return.php';
    $notifyUrl = 'http://127.0.0.1/online-payments/uuid/notify';
    $description = 'Shopping at myStore.com';

    $goPayOrder = [
        'transactionReference' => '3081797108',
    ];

    $response = $gateway->cancelRecurrence($goPayOrder);

    echo 'Id: ' . $response->getId() . PHP_EOL;
    echo "Result: " . $response->getResult() . PHP_EOL;
    echo 'Is Successful: ' . (bool) $response->isSuccessful() . PHP_EOL;

} catch (ClientErrorResponseException $e) {
    dump((string)$e);
    dump($e->getResponse()->getBody(true));
}