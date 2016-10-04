<?php

require '../vendor/autoload.php';

use Guzzle\Http\Exception\ClientErrorResponseException;
use Omnipay\GoPay\GatewayFactory;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

$goId = $_ENV['GO_ID'];
$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];

$gateway = GatewayFactory::createInstance($goId, $clientId, $clientSecret, true);

try {
    $completeRequest = ['transactionReference' => '3044354339'];
    $response = $gateway->completePurchase($completeRequest);

    echo "Is Successful: " . $response->isSuccessful() . PHP_EOL;
    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "State code: " . $response->getCode() . PHP_EOL;
    echo "TransactionReference: " , $response->getTransactionReference() . PHP_EOL;
    echo "Data: " . var_export($response->getData(), true) . PHP_EOL;

} catch (ClientErrorResponseException $e) {
    dump((string)$e);
    dump($e->getResponse()->getBody(true));
}