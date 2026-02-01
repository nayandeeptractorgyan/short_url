<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            'original_url' => fake()->url(),
            'short_code'   => ShortUrl::generateShortCode(),
            'company_id'   => Company::factory(),
            'created_by'   => User::factory(),
        ];
    }
}
