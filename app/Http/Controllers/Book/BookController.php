<?php

namespace App\Http\Controllers\Book;

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

class BookController extends Controller
{

    private SkeletonService $skeleton;

    public function __construct(SkeletonService $skeleton)
    {
        $this->skeleton = $skeleton;
    }

    public function index(){
        return view("books.list");
    }

    public function postLogin(Request $request){

        $response = $this->skeleton->getToken($request->all());
        dd($response);

        return view("auth.login");
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
