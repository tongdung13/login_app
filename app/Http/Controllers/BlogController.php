<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()
            ->select('id', 'title', 'content', 'image')
            ->paginate(12);
        $response = $blogs->items();
        $dataPage = [];
        // $dataPage[] = [
        //     // 'page' => $blogs->hasPages,
        //     'total_page' => $blogs->perPage
        // ];
        return response()->json([
            'status' => 1,
            'code' => 200,
            'message' => 'Danh sach blog',
            'data' => [
                'blogs' => $response,
            ]
        ], 200);
    }
}
