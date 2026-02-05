<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Nama class model yang terkait.
     */
    protected $model = Pengguna::class;

    /**
     * Password default untuk factory.
     */
    protected static ?string $kataSandi;

    /**
     * Definisikan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_diverifikasi_pada' => now(),
            'kata_sandi' => static::$kataSandi ??= Hash::make('password'),
            'peran' => 'pelanggan',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indikasikan bahwa email pengguna belum diverifikasi.
     */
    public function belumDiverifikasi(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_diverifikasi_pada' => null,
        ]);
    }
}