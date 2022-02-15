<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
                'name' => 'test',
                'email' => 'test@test.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'mobile' => $this->faker->e164PhoneNumber,
                'password' => 't3st',
            ];
        }
}
