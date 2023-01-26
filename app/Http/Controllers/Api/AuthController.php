<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
            $user = JWTAuth::toUser();
            $time_before = time() - strtotime($user->date_login_failed);

            if ($user->count_login_failed == 10 && $time_before < 0) {
                $t = 0 - $time_before;
                $m = floor($t / 60);
                $s = $t - ($m * 60);
                $msg = '';
                if ($m > 0) {
                    $msg .= $m . ' phút ';
                }
                $msg .= $s . ' giây';

                return response()->json([
                    'status' => 2,
                    'code' => 401,
                    'message' => 'Email của bạn bị khóa trong ' . $msg,
                    'data' => []
                ], 200);
            }

            $now = Carbon::now();

            if ($user->count_login_failed < 10) {
                $user->count_login_failed += 1;
                $user->count_login -= 1;
                $user->save();
                if ($user->count_login_failed == 10) {
                    $user->date_login_failed = $now->addMinutes(15);
                    $user->save();

                    return response()->json([
                        'status' => 2,
                        'code' => 401,
                        'message' => 'Đăng nhập thất bại 10 lần tài khoản của bạn bị khóa trong 15 phút',
                        'data' => []
                    ], 200);
                }

                return response()->json([
                    'status' => 2,
                    'code' => 401,
                    'message' => 'Không đúng mật khẩu. Bạn còn ' . $user->count_login . ' đăng nhập',
                    'data' => []
                ], 200);
            }
            if ($user->count_login_failed >= 10 && $user->date_login_failed < date('Y-m-d H:i:s')) {
                $user->count_login_failed = 0;
                $user->count_login = 10;
                $user->count_login -= 1;
                $user->count_login_failed += 1;
                $user->save();

                return response()->json([
                    'status' => 2,
                    'code' => 401,
                    'message' => 'Đăng nhập thất bại. Bạn còn ' . $user->count_login . ' đăng nhập',
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
