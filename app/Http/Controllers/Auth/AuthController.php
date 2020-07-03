<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\User\IUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Str;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Auth
 */
class AuthController extends BaseController
{
    /**
     * @var IUserService
     */
    private $userService;

    /**
     * AuthController constructor.
     *
     * @param  IUserService  $userService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(RegistrationRequest $request)
    {
        $code = Response::HTTP_CREATED;
        $message = "Successfully created user!";
        $data = null;

        $user = $this->userService->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => Str::random(60)
        ]);

//         Send notification
//        $user->notify(new SignupActivate($user));

        return $this->response($data, $message, $code);
    }

    /**
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate($token)
    {
        $message = 'This activation token is invalid.';
        $code = Response::HTTP_NOT_FOUND;
        $data = null;

        $user = User::where('activation_token', $token)->first();
        if (!$user)
            return $this->response($data, $message, $code);
        $user->active = true;
        $user->activation_token = '';
        $user->save();

        return $user;
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(LoginRequest $request)
    {
        $message = 'Unauthorized.';
        $code = Response::HTTP_UNAUTHORIZED;
        $data = null;

        $credentials = request(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if(!Auth::attempt($credentials))
            return $this->response($data, $message, $code);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request): JsonResponse
    {
        $code = Response::HTTP_OK;
        $message = "Successfully logged out.";
        $data = null;

        $request->user()->token()->revoke();

        return $this->response($data, $message, $code);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request): JsonResponse
    {
        $code = Response::HTTP_OK;
        $message = "Successfully created user!";
        $data = null;

        return $this->response($data, $message, $code);
    }
}
