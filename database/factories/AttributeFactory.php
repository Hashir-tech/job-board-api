<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attribute;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $attributes = [
            'Experience'        => 'number',
            'Required Skills'   => 'text',
            'Technical Skills'  => 'text',
            'Work Mode'         => ['select', ['Remote', 'Hybrid', 'On-Site']],
            'Job Level'         => ['select', ['Junior', 'Mid', 'Senior']],
        ];

        $name = $this->faker->unique()->randomElement(array_keys($attributes));
        $type = $attributes[$name];

        $options = is_array($type) ? json_encode($type[1]) : null;
        $type = is_array($type) ? $type[0] : $type;

        return [
            'name'       => $name,
            'type'       => $type,
            'options'    => $options,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
