<?php

namespace Database\Factories;

use App\Models\Contact; // モデルクラスのみをインポート
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{

    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->name,
            'gender' => $this->faker->numberBetween(1, 2),
            'email' => $this->faker->email,
            'opinion' => $this->faker->sentence,
            'postcode' => $this->faker->regexify('^\d{3}-\d{4}$'),
            'address' => function (array $attributes) {
                $postcode = $attributes['postcode'];
                $addressWithoutPostcode = str_replace($postcode, '', $this->faker->streetAddress);
                return trim($addressWithoutPostcode);
            },
        ];
    }
}
