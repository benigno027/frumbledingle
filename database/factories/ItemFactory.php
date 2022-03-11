<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Location;
use App\Models\Category;
use \Illuminate\Database\Eloquent\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //List of items
            'name' => $this->faker->randomElement(['laptop', 'phone', 'shirt', 'watch', 'shoes', 'book', 'mouse', 'keyboard', 'headphones',
                'camera', 'speaker', 'tablet', 'chair', 'lamp', 'cup', 'pen', 'pencil', 'bag', 'wallet',
                'backpack', 'umbrella', 'notebook', 'paper', 'pencil case', 'pencil sharpener', 'eraser',
            ]),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'location_id' => Location::factory(),
            'category_id' => Category::factory(),
        ];
    }
}