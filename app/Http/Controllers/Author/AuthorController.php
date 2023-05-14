<?php

namespace App\Http\Controllers\Author;

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

class AuthorController extends Controller
{

    private SkeletonService $skeleton;

    public function __construct(SkeletonService $skeleton)
    {
        $this->skeleton = $skeleton;
    }

    public function index(){
        $getToken = session('accessToken');

        $collectAuthors = $this->skeleton->fetchAuthors([
            'orderBy' => "birthday",
            "direction" => "ASC",
            "limit" => 12,
            "page" => 1
        ], $getToken);

        return view("authors.list", compact('collectAuthors'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $authorId = $request->route("id");
        $getToken = session('accessToken');

        $author = $this->skeleton->getAuthorById($authorId, $getToken);
        if ($author['status_code'] != 200){
            // Show error message
        }

        $author = $author['data'];

        return view('authors.show', compact('author'));
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
