<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Software Development',
                'Project Management',
                'Data Science',
                'Marketing',
                'Sales',
                'Customer Support',
                'Human Resources',
                'Finance & Accounting',
                'Legal',
                'Healthcare',
                'Engineering',
                'Operations',
                'Education & Training',
                'Design & Creative',
                'IT & Security'
            ]), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
