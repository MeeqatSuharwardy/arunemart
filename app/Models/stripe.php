<?php

return [
    'api_keys' => [
        'secret_key' => env('STRIPE_SECRET_KEY', null)
    ]
];

$stripe = new \Stripe\StripeClient(
    'sk_test_0CaAJrFqtvoLO3pfWUayDGgK'
);
$stripe->tokens->create([
    'card' => [
        'number' => '4242424242424242',
        'exp_month' => 2,
        'exp_year' => 2023,
        'cvc' => '314',
    ],
]);

$stripe = new \Stripe\StripeClient(
    'sk_test_0CaAJrFqtvoLO3pfWUayDGgK'
);
$stripe->charges->create([
    'amount' => 100 * 1,
    'currency' => 'gbp',
    'source' => 'tok_mastercard',
    'description' => 'My First Test Charge',
]);