<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->name(min([4])),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->numerify('########'),
            'password' => $this->faker->password(min([8])),
            'address' => $this->faker->text(min([5]))
        ];
    }
}
