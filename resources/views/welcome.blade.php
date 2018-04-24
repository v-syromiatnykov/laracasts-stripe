<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Stripe</title>

        <script>
            let Laracasts = {
                csrfToken: "{{ csrf_token() }}",
                stripeKey: "{{ config('services.stripe.key') }}"
            }
        </script>
    </head>
    <body>
        <div id="app">
            <h1>Subscription</h1>

            <checkout-form :plans="{{ $plans }}"></checkout-form>
        </div>

        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
