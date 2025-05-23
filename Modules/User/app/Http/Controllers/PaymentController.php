<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\Order;
use Modules\User\Services\PaymobService;

class PaymentController extends Controller
{
    protected $paymob;

    public function __construct(PaymobService $paymob)
    {
        $this->paymob = $paymob;
    }

    public function checkout(Request $request, $order_id)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $order = Order::with('items')->findOrFail($order_id);

        $totalAmount = $order->total + 80;

        // Step 1: Get Paymob token
        $authToken = $this->paymob->getAuthToken();
        if (!$authToken) {
            return response()->json(['message' => 'Failed to get Paymob authentication token'], 500);
        }

        // Step 2: Create order on Paymob
        $paymobOrder = $this->paymob->createOrder($authToken, $totalAmount, env('PAYMOB_MERCHANT_ID'));
        if (!isset($paymobOrder['id'])) {
            return response()->json(['message' => 'Paymob order creation failed'], 500);
        }

        $billingData = [
            "first_name" => $user->name,
            "last_name" => "Customer",
            "email" => $user->email,
            "phone_number" => "+201234567890",
            "city" => "Cairo",
            "country" => "EG",
            "apartment" => "12",
            "floor" => "3",
            "street" => "Some Street",
            "building" => "123",
            "shipping_method" => "PKG",
            "postal_code" => "12345",
            "state" => "Cairo"
        ];

        // Step 3: Get payment key
        $paymentKey = $this->paymob->getPaymentKey(
            $authToken,
            $paymobOrder['id'],
            $totalAmount,
            env('PAYMOB_INTEGRATION_ID'),
            $billingData
        );

        if (!isset($paymentKey['token'])) {
            return response()->json(['message' => 'Failed to generate payment key'], 500);
        }

        // Step 4: Return iframe URL for payment
        $iframeUrl = $this->paymob->getIframeUrl($paymentKey['token']);

        return response()->json([
            'message' => 'Checkout initiated successfully',
            'iframe_url' => $iframeUrl,
        ]);
    }
}
