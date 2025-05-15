<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $menus = Menu::whereNull('deleted_at')
            ->latest()
            ->get();

        return response()->json([
            'code' => 200,
            'message' => 'Menu retrieved successfully',
            'data' => $menus
        ], 200);
    }
}
