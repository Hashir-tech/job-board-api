<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Language;
use App\Models\Location;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\JobAttributeValue;
use Faker\Factory as Faker;

class JobSeeder extends Seeder {
    public function run()
    {
        $faker = Faker::create();

        // Create some categories
        $categories = Category::factory()->count(5)->create();

        // Create some languages
        $languages = Language::factory()->count(5)->create();

        // Create some locations
        $locations = Location::factory()->count(5)->create();

        // Create some attributes
        $attributes = Attribute::factory()->count(3)->create();

        // Create Jobs
        Job::factory()->count(10)->create()->each(function ($job) use ($categories, $languages, $locations, $attributes, $faker) {
            $job->categories()->attach($categories->random(2));
            $job->languages()->attach($languages->random(2));
            $job->locations()->attach($locations->random(2));

            // Add random attribute values
            foreach ($attributes as $attribute) {
                $value = match ($attribute->type) {
                    'text' => $faker->sentence(3), // Random short text
                    'number' => $faker->randomNumber(), // Random number
                    'boolean' => $faker->boolean(), // True or False
                    'date' => $faker->date(), // Random date
                    'select' => $faker->randomElement(json_decode($attribute->options, true) ?? []), // Random option from JSON
                    default => null,
                };

                JobAttributeValue::create([
                    'job_id' => $job->id,
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        });
    }
}

