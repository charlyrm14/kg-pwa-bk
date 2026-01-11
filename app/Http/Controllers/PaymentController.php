<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\{
    User,
    Payment
};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\Payment\PaymentService;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Resources\Payment\StorePaymentResource;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ){}

    /**
     * The `store` function in PHP handles the validation and creation of a payment record, associating
     * it with a user and calculating payment coverage.
     * 
     * @param StorePaymentRequest request The `store` function is responsible for storing a payment
     * record based on the data provided in the `StorePaymentRequest` object. Here's a breakdown of the
     * process:
     * 
     * @return JsonResponse A JSON response is being returned. If the payment is successfully
     * registered, a JSON response with a success message and the newly created payment data in the
     * "data" key is returned with a status code of 201 (Created). If there is an error during the
     * process, a JSON response with an error message is returned with a status code of 500 (Internal
     * Server Error).
     */
    public function store(StorePaymentRequest $request): JsonResponse
    {
        try {

            $data = $request->validated(); 

            $user = User::whereUuid($data['user_uuid'])->first();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            
            $coveredDate = $this->paymentService->calculateCoverageDate($data['payment_type_id'], $data['payment_date']);

            $data['user_id'] = $user->id;
            $data['payment_date'] = !is_null($data['payment_date']) ? $data['payment_date'] : Carbon::now();
            $data['covered_until_date'] = $coveredDate;
            $data['registered_by_user_id'] = $request->user()->id;

            $payment = Payment::create($data);
            $payment->load('user', 'type', 'reference');
            
            return response()->json([
                'message' => 'Payment register successfully',
                'data' => new StorePaymentResource($payment)
            ], 201);

        } catch (\Throwable $e) {

            Log::error("Error to register payment: " . $e->getMessage());

            return response()->json(["error" => 'Error to register payment'], 500);
        }
    }
}
