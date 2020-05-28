<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiBaseController
{
    public function login(Request $request)
    {
        $messages = ['exists' => 'User not found'];

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'exists:users'],
            'password' => ['required', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return $this->error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!Auth::attempt($request->all())) {
            return $this->error('Wrong password', Response::HTTP_UNAUTHORIZED);
        }

        $response['email'] = $request->email;
        $response['name'] = Auth::user()->name;
        $response['access_token'] = Auth::user()->createToken('Personal Access Token')->accessToken;

        return $this->success(['data' => $response], 'Logged in successfully!', Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $response['email'] = $request->email;
        $response['access_token'] = $user->createToken('Personal Access Token')->accessToken;

        return $this->success(['data' => $response], 'Registered successfully!', Response::HTTP_CREATED);
    }
}
