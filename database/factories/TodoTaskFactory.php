<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\Boolean;
use Psy\VersionUpdater\IntervalChecker;

class TodoTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'label' => $this->faker->sentence(4),
            'todo_id' => $this->faker->randomNumber(1, 10),
            'is_complete' => $this->faker->boolean,
        ];

    }
}
