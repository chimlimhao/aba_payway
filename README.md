# Laravel ABA PayWay Integration

This Laravel package provides an easy-to-use integration with ABA PayWay payment gateway. ABA PayWay is a payment solution provided by Advanced Bank of Asia Ltd. (ABA Bank) in Cambodia.

## Requirements

- PHP >= 8.0
- Laravel >= 9.0
- SSL Certificate (for production environment)
- ABA PayWay Merchant Account

## Installation

### Development Environment

1. Clone the repository:
```bash
git clone https://github.com/yourusername/aba-payway.git
cd aba-payway
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Configure your development environment variables in `.env`:
```env
APP_ENV=local
APP_DEBUG=true

# ABA PayWay Configuration
ABA_PAYWAY_API_URL=https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments
ABA_PAYWAY_API_KEY=your_test_api_key
ABA_PAYWAY_MERCHANT_ID=your_test_merchant_id
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

### Production Environment

1. Clone the repository on your production server:
```bash
git clone https://github.com/yourusername/aba-payway.git
cd aba-payway
```

2. Install dependencies (optimize for production):
```bash
composer install --no-dev --optimize-autoloader
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Configure your production environment variables in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# ABA PayWay Configuration
ABA_PAYWAY_API_URL=https://checkout.payway.com.kh/api/payment-gateway/v1/payments
ABA_PAYWAY_API_KEY=your_live_api_key
ABA_PAYWAY_MERCHANT_ID=your_live_merchant_id
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Optimize the application:
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

7. Set proper permissions:
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

8. Configure your web server (Apache/Nginx) with SSL certificate

9. Set up proper security measures:
   - Enable HTTPS only
   - Configure firewall rules
   - Set up proper backup system
   - Configure error logging
   - Set up monitoring

## Usage

### 1. Basic Configuration

The package includes a PayWayService that handles the integration with ABA PayWay. The configuration is automatically loaded from your `.env` file through the `config/payway.php` configuration:

```php
// config/payway.php
return [
    'api_url' => env('ABA_PAYWAY_API_URL'),
    'api_key' => env('ABA_PAYWAY_API_KEY'),
    'merchant_id' => env('ABA_PAYWAY_MERCHANT_ID'),
];
```

### 2. Creating a Payment

```php
use App\Services\PayWayService;

public function checkout(PayWayService $payWayService)
{
    $transactionData = [
        'tran_id' => time(),  // Unique transaction ID
        'amount' => '100.00',
        'items' => [
            ['name' => 'Product 1', 'quantity' => 1, 'price' => '50.00'],
            ['name' => 'Product 2', 'quantity' => 1, 'price' => '50.00']
        ],
        'firstName' => 'John',
        'lastName' => 'Doe',
        'phone' => '0123456789',
        'email' => 'john@example.com',
        'shipping' => '0.00',
        'type' => 'purchase',
        'currency' => 'USD'
    ];

    // Generate hash and return checkout view
    return view('checkout', $payWayService->prepareCheckout($transactionData));
}
```

### 3. Checkout Form

Create a checkout form in your blade view (`resources/views/checkout.blade.php`):

```html
<form method="POST" action="{{ config('payway.api_url') }}/api/payment-gateway/v1/payments/purchase" id="payway-form">
    <input type="hidden" name="hash" value="{{ $hash }}">
    <input type="hidden" name="tran_id" value="{{ $transactionId }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="firstname" value="{{ $firstName }}">
    <input type="hidden" name="lastname" value="{{ $lastName }}">
    <input type="hidden" name="phone" value="{{ $phone }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="items" value="{{ $items }}">
    <input type="hidden" name="shipping" value="{{ $shipping }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="currency" value="{{ $currency }}">
    <input type="hidden" name="merchant_id" value="{{ $merchant_id }}">
    <input type="hidden" name="req_time" value="{{ $req_time }}">
    
    <button type="submit">Proceed to Payment</button>
</form>
```

### 4. Handling Payment Response

Create routes and methods to handle successful and failed payments:

```php
// routes/web.php
Route::post('payment/success', [PaymentController::class, 'handleSuccess']);
Route::post('payment/cancel', [PaymentController::class, 'handleCancel']);
```

```php
// PaymentController.php
public function handleSuccess(Request $request)
{
    // Verify the transaction
    $isValid = $this->payWayService->verifyTransaction($request->all());
    
    if ($isValid) {
        // Process successful payment
        return redirect()->route('payment.success');
    }
    
    return redirect()->route('payment.failed');
}

public function handleCancel(Request $request)
{
    return redirect()->route('payment.cancelled');
}
```

## Security

The package includes built-in security features:

- Hash verification for all transactions
- SSL encryption for API communication
- Request validation
- Timestamp verification

## Testing

For testing purposes, use the sandbox environment provided by ABA PayWay:

1. Set `PAYWAY_API_URL` to sandbox URL in your `.env`
2. Use test credentials provided by ABA PayWay
3. Test cards are available in the ABA PayWay documentation

## Error Handling

Common error codes and their meanings:

- `0`: Success
- `1`: Invalid hash
- `2`: Invalid transaction ID
- `3`: Invalid amount
- `4`: Invalid currency
- `5`: Transaction not found
- `6`: Transaction expired

## Support

For support and issues, please create an issue in the GitHub repository or contact ABA PayWay support for API-specific questions.

## License

The Laravel ABA PayWay Integration is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

<!-- ```
MIT License

Copyright (c) 2024 [Your Name]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE. -->