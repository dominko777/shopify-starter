<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence(),
            'stars' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'name' => $this->faker->name,
            'user_id' => 1,
            'comment' => '',
            'product_id' => $this->faker->randomElement(['gid://shopify/Product/5868267176097', 'gid://shopify/Product/5880929452193', 'gid://shopify/Product/5955119284385']),
            'created_at' => $this->faker->dateTimeBetween("-60 day" , now()),
            'updated_at' => $this->faker->dateTimeBetween("-60 day" , now()),
        ];
    }
}
