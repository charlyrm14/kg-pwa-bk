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
use App\DTOs\Payment\StorePaymentDTO;
use App\Services\Payment\PaymentService;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Resources\Payment\{
    IndexPaymentCollection,
    StorePaymentResource,
};

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ){}

    
    /**
     * This PHP function retrieves a list of payments based on optional start and end dates, paginates
     * the results, and returns a JSON response with the data.
     * 
     * @param Request request The `index` function is a controller method that retrieves a list of
     * payments based on the provided request parameters. Here's a breakdown of the function:
     * 
     * @return JsonResponse A JSON response is being returned. If the payments are found, it will
     * return a JSON response with the data in the 'data' key, which is formatted using the
     * IndexPaymentCollection. If no payments are found, it will return a JSON response with a message
     * indicating that the resources were not found. If an error occurs during the process, it will
     * return a JSON response with an error message.
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $query = Payment::query();

            if($request->filled(['start_date', 'end_date'])) {
                $query->whereBetween('payment_date', [ $request->start_date, $request->end_date]);
            }

            $payments = $query->with('user', 'type', 'reference')
                ->orderByDesc('id')
                ->cursorPaginate(15);

            if($payments->isEmpty()) {
                return response()->json(['message' => 'Resources not found'], 404);
            }
            
            return response()->json([
                'data' => new IndexPaymentCollection($payments)
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get payments list: " . $e->getMessage());

            return response()->json(["error" => 'Error to get payments list'], 500);
        }
    }

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
            
            $dto = StorePaymentDTO::fromArray($request->validated(), $request->user()->id);

            $user = User::whereUuid($dto->userUuid)->first();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $coveredDate = $this->paymentService->calculateCoverageDate($dto->paymentTypeId, $dto->paymentDate);
            
            $payment = Payment::create([
                'user_id' => $user->id,
                'payment_type_id' => $dto->paymentTypeId,
                'amount' => $dto->amount,
                'payment_date' => $dto->paymentDate,
                'covered_until_date' => $coveredDate,
                'payment_reference_id' => $dto->paymentReferenceId,
                'registered_by_user_id' => $dto->registeredByUserId,
                'notes' => $dto->notes,
            ]);

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

    /**
     * This PHP function deletes a payment record and returns a JSON response indicating success or
     * failure.
     * 
     * @param Request request The `Request ` parameter in the `destroy` function represents the
     * HTTP request being made to the server. It contains all the data sent by the client in the
     * request.
     * @param Payment payment The `destroy` function you provided is a method that deletes a payment
     * record from the database. The `` parameter is an instance of the `Payment` model that
     * represents the payment record to be deleted.
     * 
     * @return JsonResponse A JSON response is being returned. If the payment is deleted successfully,
     * a JSON response with a success message is returned with status code 200. If there is an error
     * during the deletion process, a JSON response with an error message is returned with status code
     * 500.
     */
    public function destroy(Request $request, Payment $payment): JsonResponse
    {
        try {
            
            $payment->delete();

            return response()->json([
                'message' => 'Payment delete successfully'
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to delete payment: " . $e->getMessage());

            return response()->json(["error" => 'Error to delete payment'], 500);
        }
    }
}
