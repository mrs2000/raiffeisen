<?php

namespace mrssoft\raiffeisen;

class Response
{
    public const STATE_NEW = 'NEW';

    public string $qrId = '';
    public string $payload = '';
    public string $qrUrl = '';
    public string $qrStatus = '';

    public function __construct(array $params)
    {

        foreach ($params as $k => $v) {
            if (isset($this->{$k})) {
                $this->{$k} = $v;
            }
        }
    }
}