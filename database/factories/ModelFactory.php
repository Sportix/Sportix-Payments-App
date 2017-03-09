<?php

use Carbon\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'photo_url' => $faker->imageUrl(300, 300),
        'remember_token' => str_random(10),
        'current_account_id' => 1,
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'active' =>  1,
        'owner_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'name' =>  $faker->name,
        'photo_url' =>  $faker->imageUrl(300, 300),
        'stripe_id' =>  'acct_' . $faker->md5,
        'app_fee_percent' =>  4,
        'card_brand' =>  $faker->randomElement(['Visa', 'Mastercard', 'Visa']),
        'card_last_four' =>  rand(2001, 9212),
        'card_country' =>  $faker->randomElement(['CA', 'USD']),
        'billing_address' =>  $faker->address,
        'billing_address_line_2' =>  '',
        'billing_city' =>  $faker->city,
        'billing_state' =>  $faker->randomElement(['FL', 'CA', 'MI', 'UT', 'NH']),
        'billing_zip' =>  rand(23421, 90210),
        'billing_country' =>  'US',
        'extra_billing_information' =>  $faker->text,
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'account_id' =>  1,
        'created_by' => 1,
        'product_name' =>  $faker->randomElement([
            'Team Fees', 'Tournament Registration', 'Pub Fundraiser'
        ]),
        'payment_amount' => $faker->numberBetween(1000, 99999),
        'payment_description' => $faker->randomElement([
           'Fee', 'Registration', 'Random Something'
        ]),
        'description' =>  'Here is a fake description',
        'is_fixed_payment' =>  $faker->boolean,
        'recurring_interval' =>  'monthly',
        'recurring_cycles' => '3',
        // 'has_custom_form' =>  $faker->boolean,
        // 'custom_form_id' =>  1,
        'due_date' =>  $faker->date(),
        'charge_app_fee' =>  $faker->boolean,
        'app_fee_percent' =>  4
    ];
});

$factory->state(App\Product::class, 'published', function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 week')
    ];
});

$factory->state(App\Product::class, 'openlive', function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 week'),
        'due_date' => Carbon::parse('+1 week'),
    ];
});

$factory->state(App\Product::class, 'unpublished', function ($faker) {
    return [
        'published_at' => null
    ];
});

$factory->define(App\Order::class, function (Faker\Generator $faker) {
    return [
        'product_id' =>  1,
        'product_type' =>  'FUND',
        'email' =>  $faker->email,
        'total_amount' => 0,
        'payment_amount' => 0,
        'app_fee_percent' => 0,
        'charge_app_fee' => true,
    ];
});

// $factory->define(App\CustomForm::class, function (Faker\Generator $faker) {
//     return [
//         'account_id' =>  1,
//         'form_name' =>  $faker->randomElement(['Registration Form', 'Team Info', 'Player Details']),
//         'is_archive' =>  $faker->boolean,
//     ];
// });

// $factory->define(App\CustomFormQuestion::class, function (Faker\Generator $faker) {
//     return [
//         'custom_form_id' =>  1,
//         'order_number' =>  1,
//         'is_required' =>  $faker->boolean,
//         'question' =>  $faker->randomElement(['What is your name?', 'How old are you?', 'Where do you live?', 'Do you have a phone?']),
//         'help_text' =>  $faker->sentence(),
//         'response_options' =>  '',
//     ];
// });

// $factory->define(App\CustomFormResponse::class, function (Faker\Generator $faker) {
//     return [
//         'custom_form_id' =>  1,
//         'custom_form_question_id' =>  1,
//         'email' =>  $faker->safeEmail,
//         'response' =>  $faker->word,
//     ];
// });
