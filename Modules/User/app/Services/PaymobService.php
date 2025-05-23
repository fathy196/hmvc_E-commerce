<?php

namespace Modules\User\Services;



use Illuminate\Support\Facades\Http;

class PaymobService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('PAYMOB_API_KEY');
        $this->baseUrl = 'https://accept.paymob.com/api';
    }

    public function getAuthToken()
    {
        $response = Http::post("{$this->baseUrl}/auth/tokens", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json()['token'] ?? null;
    }

    public function createOrder($authToken, $amount, $merchantId)
    {
        $response = Http::post("{$this->baseUrl}/ecommerce/orders", [
            'auth_token' => $authToken,
            'delivery_needed' => false,
            'amount_cents' => $amount * 100,
            'currency' => 'EGP',
            'merchant_order_id' => time(),
            'items' => [],
        ]);

        return $response->json();
    }

    public function getPaymentKey($authToken, $orderId, $amount, $integrationId, $billingData)
    {
        $response = Http::post("{$this->baseUrl}/acceptance/payment_keys", [
            'auth_token' => $authToken,
            'amount_cents' => $amount * 100,
            'expiration' => 3600,
            'order_id' => $orderId,
            'currency' => 'EGP',
            'integration_id' => $integrationId,
            'billing_data' => $billingData,
        ]);

        \Log::error('Paymob payment key error', ['response' => $response->json()]);

        return $response->json();
    }

    public function getIframeUrl($paymentToken)
    {
        $iframeId = env('PAYMOB_IFRAME_ID');
        return "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentToken}";
    }
}
