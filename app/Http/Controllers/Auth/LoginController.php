<?php

namespace App\Http\Controllers\Auth;

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
use App\Services\SkeletonService;

class LoginController extends Controller
{

    private SkeletonService $skeleton;

    public function __construct(SkeletonService $skeleton)
    {
        $this->skeleton = $skeleton;
    }

    public function getLogin(){
        return view("auth.login");
    }

    public function postLogin(Request $request){

        $response = $this->skeleton->getToken($request->all());
        if($response['status_code'] == 200){
            // Store the access token in the Laravel session
            session(['accessToken' => $response['data']['token_key']]);
            return redirect('authors');
        }
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
}
