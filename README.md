# Omnipay: Sipay

**Sipay driver for the Omnipay PHP payment processing library**

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment processing library for PHP. This package implements Sipay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `keune/omnipay-sipay` with Composer:

```bash
composer require league/omnipay
composer require keune/omnipay-sipay
```

## Basic Usage

The following gateways are provided by this package:

* Sipay

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

### Gateway Configuration

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Sipay');
$gateway->setAppKey('your-app-key');
$gateway->setAppSecret('your-app-secret');
$gateway->setMerchantKey('your-merchant-key');
$gateway->setMerchantId('your-merchant-id');
$gateway->setTestMode(true); // Set to false for production environment
```

### Authentication

Before making any API calls, you need to fetch a bearer token:

```php
$response = $gateway->fetchBearerToken()->send();

if ($response->isSuccessful()) {
    $token = $response->getToken();
    $gateway->setBearerToken($token);
} else {
    echo $response->getMessage();
}
```

### Standard Purchase

```php
$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'TRY',
    'card' => $card,
    'orderKey' => 'ORDER-123456',
    'items' => [
        [
            'name' => 'Product Name',
            'description' => 'Product Description',
            'quantity' => 1,
            'price' => '10.00'
        ]
    ]
])->send();

if ($response->isSuccessful()) {
    // Payment was successful
    echo $response->getTransactionReference();
} else {
    // Payment failed
    echo $response->getMessage();
}
```

### 3D Secure Purchase

```php
$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'TRY',
    'card' => $card,
    'orderKey' => 'ORDER-123456',
    'items' => [
        [
            'name' => 'Product Name',
            'description' => 'Product Description',
            'quantity' => 1,
            'price' => '10.00'
        ]
    ],
    'returnUrl' => 'https://www.example.com/return',
    'cancelUrl' => 'https://www.example.com/cancel',
    'use3DSecure' => true,
    'installmentNumber' => 1 // Optional: Number of installments
])->send();

if ($response->isRedirect()) {
    // Redirect to 3D Secure page
    $response->redirect();
} else {
    // Something went wrong
    echo $response->getMessage();
}
```

### Complete 3D Secure Purchase

After the customer has completed the 3D Secure process and is redirected back to your site:

```php
$response = $gateway->completePurchase([
    'orderKey' => 'ORDER-123456'
])->send();

if ($response->isSuccessful()) {
    // Payment was successful
    echo $response->getTransactionReference();
} else {
    // Payment failed
    echo $response->getMessage();
}
```

### Get Installment Options

```php
$response = $gateway->getInstallments([
    'amount' => '10.00',
    'currency' => 'TRY',
    'binNumber' => '411111' // First 6 digits of the card number
])->send();

if ($response->isSuccessful()) {
    $installments = $response->getInstallments();
    foreach ($installments as $installment) {
        echo "Installment: " . $installment['count'] . " - Total: " . $installment['total'] . "\n";
    }
} else {
    echo $response->getMessage();
}
```

### Get Merchant Commissions

```php
$response = $gateway->getMerchantCommissions([
    'amount' => '10.00',
    'currency' => 'TRY'
])->send();

if ($response->isSuccessful()) {
    $commissions = $response->getCommissions();
    foreach ($commissions as $commission) {
        echo "Commission: " . $commission['rate'] . " - Total: " . $commission['total'] . "\n";
    }
} else {
    echo $response->getMessage();
}
```

### Get Enabled Installments

```php
$response = $gateway->getEnabledInstallments()->send();

if ($response->isSuccessful()) {
    $enabledInstallments = $response->getEnabledInstallments();
    foreach ($enabledInstallments as $installment) {
        echo "Installment: " . $installment['count'] . " - Enabled: " . ($installment['enabled'] ? 'Yes' : 'No') . "\n";
    }
} else {
    echo $response->getMessage();
}
```

### Fetch Transaction

```php
$response = $gateway->fetchTransaction([
    'transactionReference' => 'TRANSACTION-123456'
])->send();

if ($response->isSuccessful()) {
    $transaction = $response->getTransaction();
    echo "Status: " . $transaction['status'] . "\n";
    echo "Amount: " . $transaction['amount'] . "\n";
} else {
    echo $response->getMessage();
}
```

### Refund

```php
$response = $gateway->refund([
    'transactionReference' => 'TRANSACTION-123456',
    'amount' => '10.00',
    'currency' => 'TRY'
])->send();

if ($response->isSuccessful()) {
    echo "Refund successful: " . $response->getTransactionReference();
} else {
    echo "Refund failed: " . $response->getMessage();
}
```

## License

The MIT License (MIT)
