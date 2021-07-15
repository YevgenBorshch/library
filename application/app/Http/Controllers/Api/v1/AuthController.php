<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\ApiAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return Response
     * @throws ApiAuthException
     */
    public function register(RegisterRequest $request): Response
    {
        $credentials = $request->validated();
        try {
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password'])
            ]);

            return response([
                'user' => $user,
                'token' => $user->createToken('Token')->accessToken
            ], 201);
        } catch (Exception $e) {
            throw new ApiAuthException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('auth.exception.create'))
            );
        }
    }

    /**
     * @param LoginRequest $request
     * @return Response
     * @throws ApiAuthException
     */
    public function login(LoginRequest $request): Response
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new ApiAuthException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('auth.exception.find'))
            );
        }

        return response([
            'user' => $user,
            'token' => $user->createToken('Token')->accessToken
        ], 201);

    }
}
