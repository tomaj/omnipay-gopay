<?php

require '../vendor/autoload.php';

use Omnipay\GoPay\GatewayFactory;
use Symfony\Component\HttpFoundation\Request;
use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__ . '/..');
$dotenv->load();

$goId = $_ENV['GO_ID'];
$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];

$parameters = [
    'id'   => '3081704379',
];
$httpRequest = Request::create('/notify', 'GET', $parameters, [], [], [], []);

$gateway = GatewayFactory::createInstance($goId, $clientId, $clientSecret, true, $httpRequest);

try {
    if (!$gateway->supportsAcceptNotification()) {
        echo "This Gateway does not support notifications";
    }

    $response = $gateway->acceptNotification();

    echo "PaymentId: " , $response->getTransactionReference() . PHP_EOL;
    echo "Message: " . $response->getMessage() . PHP_EOL;
    echo "Status: " . $response->getTransactionStatus() . PHP_EOL;
    echo "Data: " . var_export($response->getData(), true) . PHP_EOL;

} catch (\Exception $e) {
    dump($e->getResponse()->getBody(true));
    dump((string)$e);
}