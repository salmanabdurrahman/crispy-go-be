<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->messages(),
                'data' => null,
            ], 422);
        }

        $message = ContactMessage::create($validator->validated());

        return response()->json([
            'code' => 201,
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 201);
    }
}
