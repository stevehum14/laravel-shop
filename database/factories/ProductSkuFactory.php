<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductSku;
use Faker\Generator as Faker;

$factory->define(ProductSku::class, function (Faker $faker) {
    return [
        'title'       => $this->faker->word,
        'description' => $this->faker->sentence,
        'price'       => $this->faker->randomNumber(4),
        'stock'       => $this->faker->randomNumber(5),
    ];
});
