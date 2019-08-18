use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'name'   => Str::random(10),
        'price'  => $faker->randomFloat(2, 1, 999),
        'weight' => $faker->randomFloat(2, 1, 999)
    ];
});
