# RBS
Component for payment through the payment gateway bank "Raiffeisen"

[Raiffeisen Manual](https://pay.raif.ru/doc/sbp.html#operation/post-sbp-v2-qrs)

[![Latest Stable Version](https://img.shields.io/packagist/v/mrssoft/raiffeisen.svg)](https://packagist.org/packages/mrssoft/raiffeisen)
![PHP](https://img.shields.io/packagist/php-v/mrssoft/raiffeisen.svg)
![Github](https://img.shields.io/github/license/mrs2000/yii2-raiffeisen.svg)
![Total Downloads](https://img.shields.io/packagist/dt/mrssoft/raiffeisen.svg)

### Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Either run
```
php composer.phar require --prefer-dist mrssoft/raiffeisen "*"
```
or add
```
"mrssoft/raiffeisen": "*"
```
to the require section of your `composer.json` file.

### Usage
Register order
```php

```
Get order status
```php

```
Get order info
```php

```
### Usage as Yii component
```php
    
    // Application config
    ...
    'components' => [
        'raiffeisen' = > [
            'class' => \mrssoft\raiffeisen\Rbs::class,
            ''
        ]
    ]
    ...

    // Selecting account "second"
    $response = Yii::$app->raiffeisen->register($rbsOrder);
```