<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

//Customer 
$factory->define(App\Customer::class, function(Faker\Generator $faker){
	return [
		'name'=>$faker->company." (DUMMY)",
		'address'=>$faker->address,
		'contact_number'=>$faker->phoneNumber
	];
});

//Vendor
$factory->define(App\Vendor::class, function(Faker\Generator $faker){
	return [
		'name'=>$faker->company." (DUMMY)",
		'product_name'=>$faker->word,
		'phone'=>$faker->phoneNumber,
		'address'=>$faker->address,
	];
});