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
    $orderNo = uniqid();
    $returnUrl = 'http://localhost:8000/gateway-return.php';
    $notifyUrl = 'http://127.0.0.1/online-payments/uuid/notify';
    $description = 'Shopping at myStore.com';

    $goPayOrder = [
        'transactionReference' => '3081796328',
        'purchaseData' => [
            'amount'            => 1000,
            'currency'          => 'CZK',
            'order_number'      => $orderNo,
            'order_description' => $description,
            'items'             => [
                ['count' => 1, 'name' => $description, 'amount' => 1000],
            ],
            'eet'               => [
                "celk_trzba" => 15000,
                "zakl_dan1"  => 14000,
                "dan1"       => 1000,
                "zakl_dan2"  => 14000,
                "dan2"       => 1000,
                "mena"       => 'CZK'
            ],
        ],
    ];

    $response = $gateway->recurrence($goPayOrder);

    echo 'Our OrderNo: ' . $orderNo . PHP_EOL;
    echo "Parent id: " . $response->getParentId() . PHP_EOL;
    echo "TransactionReference: " . $response->getTransactionReference() . PHP_EOL;
    echo 'Is Successful: ' . (bool) $response->isSuccessful() . PHP_EOL;
    echo 'Is redirect: ' . (bool) $response->isRedirect() . PHP_EOL;

} catch (ClientErrorResponseException $e) {
    dump((string)$e);
    dump($e->getResponse()->getBody(true));
}