<?php

namespace App\Http\Controllers\API\Auth;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;

class LoginController extends Controller
{

    public function __construct()
    {
    }

    public static $loginValidationRules = [
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ];

    /**
     * login api
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, self::$loginValidationRules);
        if ($validator->fails()) {
            return sendError($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user->password)) {
            return sendError("User not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->token = $user->createToken(config('app.name'))->plainTextToken;

        return sendResponse(new UserResource($user), 'login successfully', Response::HTTP_OK);
    }

    /**
     * @return \App\Http\Controllers\JsonResponse
     */
    public function logout()
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $user->tokens()->delete();
            return sendSuccess('Successfully logout');
        }

        return sendSuccess('User already logged out');
    }

    /**
     * @param LoginRequest $request
     */
    public function signup(LoginRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password =  \Hash::make($request->password);
        $user->save();
        $user->token = $user->createToken(config('app.name'))->plainTextToken;

        return sendResponse(new UserResource($user), 'Registration successfully.', Response::HTTP_OK);
    }
}
