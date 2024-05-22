<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     protected $model = Food::class;
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->lexify('id-????'),
            'price' => fake()->numberBetween(70, 100),
            'price_sale' =>fake()->randomFloat(30, 50, 69),
            'detail' => fake()->lexify('id-????'),
            'image' => '.png', // Sử dụng đường dẫn tương đối
            // 'mf_id' => rand(1,8),
        ];
    }
}
