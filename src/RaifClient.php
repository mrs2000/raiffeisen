<?php

namespace mrssoft\raiffeisen;

class RaifClient extends \yii\base\Component
{
    public const QR_STATIC = 'QRStatic';
    public const QR_DYNAMIC = 'QRDynamic';
    public const QR_VARIABLE = 'QRVariable';

    public string $secretKey;

    public string $sbpMerchantId;

    public string $apiUrl = 'https://e-commerce.raiffeisen.ru/api';

    public string|null $qrExpirationDate = null;

    public function registerQr(string $qrType, RaifOrder $order): ?Response
    {
        $params = [
            'qrType' => $qrType,
            'sbpMerchantId' => $this->sbpMerchantId,
            'order' => $order->orderNum,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'additionalInfo' => mb_substr($order->description, 140),
            'paymentDetails' => mb_substr($order->description, 0, 185),
            //'redirectUrl' => $order->redirectUrl,
        ];

        if ($qrExpirationDate = $order->qrExpirationDate ?? $this->qrExpirationDate) {
            $params['qrExpirationDate'] = $qrExpirationDate;
        }

        $response = $this->request('POST', '/sbp/v2/qrs', $params);
        return $response ? new Response($response) : null;
    }

    public function infoQr(string $qrId): ?Response
    {
        $response = $this->request('GET', '/sbp/v2/qrs/' . $qrId);
        return $response ? new Response($response) : null;
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