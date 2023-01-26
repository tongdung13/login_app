<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            $user = User::query()->where('email', $request->email)->first();
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
                    'message' => 'Tài khoản của bạn bị khóa trong ' . $msg,
                    'data' => []
                ], 200);
            }

            $now = Carbon::now();
            if ($token = JWTAuth::attempt($credentials)) {
                $user->count_login_failed = 0;
                $user->count_login = 10;
                $user->save();
                DB::commit();
                return response()->json([
                    'status' => 1,
                    'code' => 200,
                    'message' => 'Đăng nhập thành công!',
                    'data' => [
                        'user' => Auth::user(),
                        'token' => $token,
                    ]
                ]);
            } else {
                if ($user->count_login_failed < 10) {
                    $user->count_login_failed += 1;
                    $user->count_login -= 1;
                    $user->save();

                    if ($user->count_login_failed == 10) {
                        $user->date_login_failed = $now->addMinutes(15);
                        $user->save();
                        DB::commit();
                        return response()->json([
                            'status' => 2,
                            'code' => 401,
                            'message' => 'Đăng nhập thất bại 10 lần tài khoản của bạn bị khóa trong 15 phút',
                            'data' => []
                        ], 200);
                    }
                    DB::commit();
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
                    DB::commit();
                    return response()->json([
                        'status' => 2,
                        'code' => 401,
                        'message' => 'Đăng nhập thất bại. Bạn còn ' . $user->count_login . ' đăng nhập',
                        'data' => []
                    ], 200);
                }
            }
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
