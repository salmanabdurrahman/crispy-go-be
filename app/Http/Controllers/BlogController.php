<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = BlogPost::whereNotNull('published_at')
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return response()->json([
            'code' => 200,
            'message' => 'Blog posts retrieved successfully',
            'data' => $posts
        ], 200);
    }

    public function show(string $slug): JsonResponse
    {
        $post = BlogPost::where('slug', '=', $slug)
            ->whereNotNull('published_at')
            ->whereNull('deleted_at')
            ->first();

        if (!$post) {
            return response()->json([
                'code' => 404,
                'message' => 'Blog post not found',
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Blog post retrieved successfully',
            'data' => $post
        ], 200);
    }
}