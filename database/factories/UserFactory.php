<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => Role::Member,
            'company_id'        => Company::factory(),
            'remember_token'    => Str::random(10),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state([
            'role'       => Role::SuperAdmin,
            'company_id' => null,
        ]);
    }

    public function admin(?int $companyId = null): static
    {
        return $this->state([
            'role'       => Role::Admin,
            'company_id' => $companyId ?? Company::factory(),
        ]);
    }

    public function member(int $companyId): static
    {
        return $this->state([
            'role'       => Role::Member,
            'company_id' => $companyId,
        ]);
    }

    public function sales(int $companyId): static
    {
        return $this->state([
            'role'       => Role::Sales,
            'company_id' => $companyId,
        ]);
    }

    public function manager(int $companyId): static
    {
        return $this->state([
            'role'       => Role::Manager,
            'company_id' => $companyId,
        ]);
    }
}
