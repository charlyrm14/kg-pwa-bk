<?php

declare(strict_types=1);

namespace App\QueryFilter\Analytics\Payments;

use App\QueryFilter\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class PaymentDistribution implements QueryFilter
{
    /**
     * The function applies a query to calculate the total amount and percentage of payments for each
     * payment type, grouping and ordering the results accordingly.
     *
     * @param Builder query The `apply` function takes a query builder instance as a parameter and
     * modifies it by selecting specific columns, calculating the total amount and percentage, joining
     * the `payment_types` table with the `payments` table, grouping the results by certain columns,
     * and ordering the results by total amount in descending order.
     *
     * @return Builder The `apply` function is returning a Builder instance after applying a select
     * query to it. The query selects specific columns from the database tables `payment_types` and
     * `payments`, calculates the total amount of payments for each payment type, and calculates the
     * percentage of each payment type's total amount relative to the overall total amount of all
     * payments. The query also joins the `payment_types` table with the `
     */
    public function apply(Builder $query): Builder
    {
        return $query
            ->selectRaw("
                payment_types.id,
                payment_types.name,
                payment_types.slug,
                SUM(payments.amount) as total_amount,
                ROUND(SUM(payments.amount)/ SUM(SUM(payments.amount)) OVER() * 100, 2) as percentage
            ")
            ->join('payment_types', 'payment_types.id', '=', 'payments.payment_type_id')
            ->groupBy('payment_types.id', 'payment_types.name', 'payment_types.slug')
            ->orderByDesc('total_amount');
    }
}
