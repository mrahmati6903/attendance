<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JWTAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated());
            if (!$token = Auth::guard('api')->login($user)) {
                throw new Exception();
            }
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'register success',
                'data'    => $this->tokenDataResponse($token)
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'internal server error'
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status'  => false,
                'message' => 'email or password is wrong'
            ], 401);
        }

        return response()->json([
            'status'  => true,
            'message' => 'login success',
            'data'    => $this->tokenDataResponse($token)
        ], 200);
    }

    public function me()
    {
        return response()->json([
            'status' => true,
            'data'   => Auth::user()
        ], 200);
    }

    public function refresh()
    {
        return response()->json([
            'status'  => true,
            'message' => 'refresh success',
            'data'    => $this->tokenDataResponse(Auth::guard('api')->refresh())
        ], 200);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status'  => true,
            'message' => 'logout success'
        ]);
    }

    public function tokenDataResponse($token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60
        ];
    }
}
