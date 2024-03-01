<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customDomain = '@mailinator.com';
        $email = "";
        do
        {
            $emailFake = fake()->unique()->safeEmail();
            $email = str_replace(strstr($emailFake, '@'), $customDomain,$emailFake);
        }
        while(User::where("Email",$email)->first() != null);        
        return [
            'TenDangNhap' => fake()->userName(),
            'HoVaTen' => fake()->name(),
            'Email' => $email,
            'NgaySinh'=>fake()->date(),            
            'SDT' => fake()->phoneNumber(),
            'password' => '123',            
            'token' => strtoupper(Str::random(20)),            
            'GioiTinh'=>fake()->randomElement(['Nam', 'Nữ']),
            'DaXacMinh'=>fake()->boolean()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
