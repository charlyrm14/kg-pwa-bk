<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\{
    User,
    Payment,
    PaymentReference,
    PaymentType
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentDate = Carbon::create(
            now()->year,
            1,
            1
        )->addDays(fake()->numberBetween(0, now()->dayOfYear - 1));

        $coveredUntilDate = (clone $paymentDate)->addMonth();

        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'payment_type_id' => PaymentType::inRandomOrder()->value('id'),
            'amount' => fake()->randomFloat(2, 50, 9999),
            'payment_date' => $paymentDate->format('Y-m-d'),
            'covered_until_date' => $coveredUntilDate->format('Y-m-d'),
            'payment_reference_id' => PaymentReference::inRandomOrder()->value('id'),
            'registered_by_user_id' => 3,
            'notes' => fake()->optional()->sentence(12),
        ];
    }
}
