<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdeaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Idea::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 20),
            'category_id' => $this->faker->numberBetween(1, 4),
            'title' => ucwords($this->faker->words(4, true)),
            'description' => $this->faker->paragraph(5),
        ];
    }
}
