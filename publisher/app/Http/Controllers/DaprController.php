<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\DaprPublishService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DaprController extends Controller
{

    public function __construct(protected DaprPublishService $daprPublishService) { }

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
        $result = $this->daprPublishService->sendMessage($validated['orderId'], $validated['type']);

        if ($result)
        {
            return response()->json([
                "message" => "Message published successfully"
            ]);
        } else {
            return response()->json([
                "message" => "Message failed to publish"
            ]);
        }

    }
}
