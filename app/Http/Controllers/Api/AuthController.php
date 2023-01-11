<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        DB::beginTransaction();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                DB::rollBack();
                return response()->json([
                    'status' => 2,
                    'code' => 401,
                    'message' => 'Tài khoản hoặc mật khẩu sai!',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 1,
                'code' => 200,
                'message' => 'Đăng nhập thành công!',
                'data' => [
                    'user' => Auth::user(),
                    'token' => $token,
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 2,
                'code' => 401,
                'message' => 'Có lỗi xảy ra!',
                'data' => []
            ], 200);
        }


    }
}
