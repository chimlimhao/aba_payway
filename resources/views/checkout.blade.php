<!-- resources/views/checkout.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PayWay Checkout Sample</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="author" content="PayWay">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            margin-top: 75px;
        }

        .container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        #checkout_button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #checkout_button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 75px; margin: 0 auto;">
        <div style="width: 200px; margin: 0 auto;">
            <h2>TOTAL: ${{ $amount }}</h2>
            <form method="POST" target="aba_webservice" action="{{ config('payway.api_url') }}" id="aba_merchant_request">
                @csrf
                <input type="hidden" name="hash" value="{{ $hash }}" id="hash" />
                <input type="hidden" name="tran_id" value="{{ $transactionId }}" id="tran_id" />
                <input type="hidden" name="amount" value="{{ $amount }}" id="amount" />
                <input type="hidden" name="firstname" value="{{ $firstName }}" />
                <input type="hidden" name="lastname" value="{{ $lastName }}" />
                <input type="hidden" name="phone" value="{{ $phone }}" />
                <input type="hidden" name="email" value="{{ $email }}" />
                <input type="hidden" name="items" value="{{ $items }}" id="items" />
                <input type="hidden" name="return_params" value="{{ $return_params }}" />
                <input type="hidden" name="shipping" value="{{ $shipping }}" />
                <input type="hidden" name="currency" value="{{ $currency }}" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <input type="hidden" name="payment_option" value="{{ $payment_option }}" />
                <input type="hidden" name="merchant_id" value="{{ $merchant_id }}" />
                <input type="hidden" name="req_time" value="{{ $req_time }}" />
            </form>
            <input type="button" id="checkout_button" value="Checkout Now">
        </div>
    </div>
    <script src="https://checkout.payway.com.kh/plugins/checkout2-0.js"></script>

    <script>
        $(document).ready(function () {
            $('#checkout_button').click(function () {
                AbaPayway.checkout();
            });
        });
    </script>
</body>

</html>
