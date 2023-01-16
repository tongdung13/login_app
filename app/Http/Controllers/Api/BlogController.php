<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()
            ->select('id', 'title', 'content', 'image')
            ->paginate(12);
        $response = $blogs->items();
        $dataPage = [];
        $dataPage = [
            'page' => $blogs->currentPage(),
            'total_page' => $blogs->lastPage(),
            'per_page' => $blogs->perPage(),
            'next_page' => $blogs->hasMorePages(),
        ];
        return response()->json([
            'status' => 1,
            'code' => 200,
            'message' => 'Danh sach blog',
            'data' =>  $response,
            'page' => $dataPage,
        ], 200);
    }

    public function show($id)
    {
        $blog = Blog::query()
            ->where('id', $id)->first();
        if (empty($blog)) {
            return response()->json([
                'status' => 1,
                'message' => 'Bài viết không tồn tại',
                'data' => []
            ], 200);
        }
        return response()->json([
            'status' => 1,
            'message' => 'Chi tiết Bài viết',
            'data' => $blog
        ], 200);
    }
}
