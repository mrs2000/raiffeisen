<?php

namespace mrssoft\raiffeisen;

use yii\base\ErrorException;

class RaifClient extends \yii\base\Component
{
    public const QR_STATIC = 'QRStatic';
    public const QR_DYNAMIC = 'QRDynamic';
    public const QR_VARIABLE = 'QRVariable';

    public string $secretKey;

    public string $sbpMerchantId;

    public string $apiUrl = 'https://e-commerce.raiffeisen.ru/api';

    public function registerQr(string $qrType, RaifOrder $order): ?array
    {
        if (empty($order->orderNum)) {
            throw new ErrorException('');
        }

        $params = [
            'qrType' => $qrType,
            'sbpMerchantId' => $this->sbpMerchantId,
            'order' => $order->orderNum,
            'additionalInfo' => $order->description,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'paymentDetails' => $order->description,
            'redirectUrl' => $order->redirectUrl,
        ];

        return $this->request('POST', '/sbp/v2/qrs', $params);
    }

    public function infoQr(string $qrId): ?array
    {
        return $this->request('GET', '/sbp/v2/qrs/' . $qrId);
    }

    private function request(string $method, string $endpoint, array $params = null): ?array
    {
        $curl = curl_init();

        $options = [
            CURLOPT_URL => $this->apiUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->secretKey,
            ],
        ];

        if ($method === 'POST' && $params) {
            $options[CURLOPT_CUSTOMREQUEST] = 'POST';
            $options[CURLOPT_POSTFIELDS] = json_encode($params, JSON_UNESCAPED_UNICODE);
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response ? json_decode($response, true) : null;
    }
}