<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Stripe</title>

    </head>
    <body>
        <h1>By my book for $25</h1>

{{--        <form action="/purchases" method="POST">

            {{ csrf_field() }}

            <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ config('services.stripe.key') }}"
                    data-amount="2500"
                    data-name="Some book"
                    data-description="This will give you everything to get started."
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-zip-code="true">
            </script>
        </form>--}}

        <form id="checkout-form" action="/purchases" method="POST">
            {{ csrf_field() }}

            <input type="hidden" id="stripeToken" name="stripeToken">
            <input type="hidden" id="stripeEmail" name="stripeEmail">

            <button type="submit">Buy Me Book</button>
        </form>

        <script src="https://checkout.stripe.com/checkout.js"></script>

        <script>
            let stripe = StripeCheckout.configure({
                key: "{{ config('services.stripe.key') }}",
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                token: function (token) {
                    console.log(token);

                    document.querySelector('#stripeEmail').value = token.email;
                    document.querySelector('#stripeToken').value = token.id;

                    document.querySelector('#checkout-form').submit();
                }
            });

            document.querySelector('button').addEventListener('click', function(e) {
                stripe.open({
                    name: 'My Book',
                    description: 'Some details about the book.',
                    zipCode: true,
                    amount: 2500
                });

                e.preventDefault();
            });
        </script>

    </body>
</html>
