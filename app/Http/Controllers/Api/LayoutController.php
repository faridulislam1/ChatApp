<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layout;

class LayoutController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array'
        ]);

        $layout = Layout::create([
            'data' => $validated['data']
        ]);

        return response()->json([
             'status' => 200,
            'message' => 'Layout saved successfully',
            // 'layout' => $layout
        ], 201);
    }

    // ✅ Get all layouts
    public function index()
    {
        return response()->json(Layout::all(), 200);
    }

    

    public function show($id)
    {
        $layout = Layout::find($id);

        if (!$layout) {
            return response()->json(['message' => 'Layout not found'], 404);
        }

        return response()->json($layout, 200);
    }
}
