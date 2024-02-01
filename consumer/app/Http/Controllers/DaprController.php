<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DaprController extends Controller
{
    //
    public function DaprReceive(Request $request) {
        Log::error("DaprReceive");
        $data = $request->all();
        Log::error(json_encode($data));
        return response()->json([
            "message" => "Dapr Receive endpoint received successfully"
        ]);
    }

    public function DaprCreateMessage(Request $request) {
        Log::error("Dapr Create Message");
        $data = $request->all();
        Log::error(json_encode($data));
        return response()->json([
            "message" => "Dapr Create endpoint received successfully"
        ]);
    }

    public function DaprRestMessage(Request $request) {
        Log::error("Dapr Rest message received");
        $data = $request->all();
        Log::error(json_encode($data));
        return response()->json([
            "message" => "Dapr REST request received successfully"
        ]);
    }

    public function DaprCancelMessage(Request $request) {
        Log::error("Dapr Cancel Message");
        $data = $request->all();
        Log::error(json_encode($data));
        return response()->json([
            "message" => "Dapr Cancel endpoint received successfully"
        ]);
    }
}
