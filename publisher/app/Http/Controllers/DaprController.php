<?php

namespace App\Http\Controllers;


use App\Services\DaprService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class DaprController extends Controller
{

    public function __construct(protected DaprService $daprService) { }

    /**
     * @throws ValidationException
     */
    public function DaprPublishMessage(Request $request): JsonResponse
    {
        // Validate the request
        $types = array('create', 'cancel');

        $rules = [
            'orderId' => 'required',
            'type' => [
                'required',
                Rule::in($types),
            ],
        ];

        // Add custom messages
        $messages = [
            'orderId.required' => 'Order ID is required',
            'type.required' => 'Type is required',
            'type.in' => 'Type must be one of the following: ' . implode(', ', $types),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            $messages = $validator->messages();
            $errors = $messages->all();
            return response()->json([
                "message" => $errors
            ]);
        }

        $validated = $validator->validated();

        // Publish the message using Dapr Service
        $result = $this->daprService->sendTopicMessage('orders',$validated['orderId'], $validated['type']);

        if ($result)
        {
            return response()->json([
                "message" => "Message published successfully"
            ]);
        } else {
            return response()->json([
                "message" => "Message failed to publish"
            ], 400);
        }

    }


    public function DaprHttpInvoke(Request $request): JsonResponse
    {
        $result = $this->daprService->sendRestRequest("test Rest Request", "RestRequest");

        if ($result) {
            return response()->json([
                "message" => "Dapr HTTP Invoke successful",
                "result" => $result
            ]);
        }

        return response()->json([
            "message" => "Dapr HTTP Invoke failed",
        ], 500);
    }

    public function DaprHealthCheck(): JsonResponse
    {
        $result = $this->daprService->getDaprHealth();

        if ($result) {
            return response()->json([
                "message" => "Dapr is Healthy",
            ]);
        }

        return response()->json([
            "message" => "Dapr is Unhealthy",
        ], 500);
    }
}
