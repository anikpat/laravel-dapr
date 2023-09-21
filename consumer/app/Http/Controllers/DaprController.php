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
    }

    public function DaprCreateMessage(Request $request) {
        Log::error("Dapr Create Message");
        $data = $request->all();
        Log::error(json_encode($data));
    }

    public function DaprCancelMessage(Request $request) {
        Log::error("Dapr Cancel Message");
        $data = $request->all();
        Log::error(json_encode($data));
    }
}
