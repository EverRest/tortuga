<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\PasswordReset;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Notifications\PasswordReset\PasswordResetRequest;
use App\Notifications\PasswordReset\PasswordResetSuccess;
use Carbon\Carbon;

/**
 * Class PasswordResetController
 *
 * @package App\Http\Controllers\Password
 */
class PasswordResetController extends BaseController
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $message = "We can\'t find a user with that e-mail address.";
        $code = Response::HTTP_NOT_FOUND;
        $data = null;

        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return $this->response($data, $message, $code);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60)
             ]
        );
        if ($user&&$passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );

        $message = "We have e-mailed your password reset link!";

        return $this->response($data, $message, $data);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $message = "This password reset token is invalid.";
        $code = Response::HTTP_NOT_FOUND;
        $data = null;

        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return $this->response($data, $message, $code);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return $this->response($data, $message, $code);
        }
        return response()->json($passwordReset);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $message = "This password reset token is invalid.";
        $code = Response::HTTP_NOT_FOUND;
        $data = null;

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return $this->response($data, $message, $code);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return $this->response($data, $message, $code);

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();
        // Send notification
        // $user->notify(new PasswordResetSuccess($passwordReset));
        $data = $user;
        $code = Response::HTTP_OK;

        return $this->response($data, $message, $code);
    }
}
