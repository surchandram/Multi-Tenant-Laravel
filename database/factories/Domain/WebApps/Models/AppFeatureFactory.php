<?php

namespace Database\Factories\Domain\WebApps\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\WebApps\Models\App;
use SAAS\Domain\WebApps\Models\AppFeature;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SAAS\Domain\WebApps\Models\AppFeature>
 */
class AppFeatureFactory extends Factory
{
    protected $model = AppFeature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ltd = $this->faker->randomElement([true, false]);

        return [
            // 'app_id' => App::factory(),
            // 'feature_id' => Feature::factory(),
            'limit' => $ltd ? 0 : rand(2, 10),
            'is_unlimited' => $ltd,
            'default' => $this->faker->randomElement([true, false]),
        ];
    }
}
