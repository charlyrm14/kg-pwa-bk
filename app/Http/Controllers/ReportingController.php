<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Report\ReportingRequest;
use App\Services\Report\ReportManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportingController extends Controller
{
    public function __construct(
        protected ReportManager $manager
    ){}

    /**
     * The function generates a report based on a validated reporting request.
     * 
     * @param ReportingRequest request The `generate` function takes a `ReportingRequest` object as a
     * parameter. This object is type-hinted in the function signature, indicating that it expects an
     * instance of the `ReportingRequest` class to be passed in when the function is called. The
     * function then calls the `handle` method
     * 
     * @return The `generate` function is returning the result of calling the `handle` method on the
     * `manager` object with the validated data from the ``.
     */
    public function generate(ReportingRequest $request): BinaryFileResponse
    {
        return $this->manager->handle($request->validated());
    }
}
