<?php

namespace mrssoft\raiffeisen;

class RaifOrder
{
    public string $orderNum;
    public float $amount;
    public string $description = '';
    public string $redirectUrl = '';
    public string|null $qrExpirationDate = null;

    public string $currency = 'RUB';
}