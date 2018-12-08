<?php

namespace App\Http\Controllers;

use App\User;
use App\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = \App\User::where('email', '=', $request['email'])->first();

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(
            [
                'user' => $user,
                compact('token')
            ]
        );
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'login' => $request->get('login'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
            try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
                }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                return response()->json(['token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                return response()->json(['token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                return response()->json(['token_absent'], $e->getStatusCode());

            }

            return response()->json(compact('user'));
    }

    public function getOperations($id) {

        $user = User::where('id', '=', $id)->first();

        foreach($user->operations as $operation) {

            User::getCategoryLabel($operation);
        }

        return response()->json([
            'operations' => $user->operations
        ], 200);
    }

    public function getCategoryOperations(Request $request, $id) {

        $user = User::where('id', '=', $id)->first();
        $type_operations = $user->type_operations;

        return response()->json([
            'type_operations' => $type_operations
        ], 200);
    }

    public function getTheUserInfo(Request $request) {

        $user = User::where('id', '=', $request->get('id'))->first();

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function updateTheUserInfo(Request $request) {

        $user = User::where('id', '=', $request->get('id'))->first();
        $user->update($request->all());

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function deleteTheUser(Request $request) {

        $user = User::where('id', '=', $request->get('id'))->first();
        $user->delete();

        return response()->json([
            'user' => $user
        ], 200);
    }
}