<?php

declare(strict_types=1);

namespace App\Services\Report;

use Illuminate\Support\Facades\Log;
use App\Services\Report\ReportStrategyFactory;

class ReportManager 
{
    public function __construct(
        protected ReportStrategyFactory $factory
    ){}

    /**
     * The function handles different types of reports using a strategy pattern and logs any errors
     * that occur.
     * 
     * @param array data The `handle` function takes an array `` as a parameter. This array should
     * contain a key named `report_type` which is used to determine the type of report strategy to be
     * used. The function then creates an instance of the appropriate `ReportStrategy` using a factory
     * and calls the `
     * 
     * @return The `handle` function is returning the result of the `generate` method called on the
     * `` object.
     */
    public function handle(array $data)
    {
        $reportType = $data['report_type'];

        /** @var ReportStrategy $strategy */
        $strategy = $this->factory->make($reportType);

        try {
            
            return $strategy->generate($data);

        } catch (\Throwable $e) {

            Log::error("Report manager: " . $e->getMessage());
            abort(500, 'Error reporting manager');

        }
    }
}