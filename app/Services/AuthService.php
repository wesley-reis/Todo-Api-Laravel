<?php

namespace App\Services;

use App\Events\ForgotPassword;
use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\ResetPasswordInvalidException;
use App\Exceptions\UserHasBeeTakenException;
use App\Exceptions\VerifyTokenEmailException;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;


/**
 *
 */
class AuthService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws LoginInvalidException
     */
    public function login(string $email, string $password)
    {
        $login = [
            'email' => $email,
            'password' => $password
        ];

        if (!$token = auth()->attempt($login)){
            throw new LoginInvalidException();
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @throws UserHasBeeTakenException
     */
    public function register(string $firstName, string $lastName, string $email, string $password)
    {

        $user = User::where('email', $email)->exists();

        if (!empty($user)) {
            throw new UserHasBeeTakenException();
        }

        $userPassword = bcrypt($password ?? Str::random(10));

        $user = User::create([
            'first_name'         => $firstName,
            'last_name'          => $lastName,
            'email'              => $email,
            'confirmation_token' => Str::random(60),
            'password'           => $userPassword,
        ]);

        event(new UserRegistered($user));

        return $user;
    }


    public function verifyEmail(string $token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (empty($user)){
            throw new VerifyTokenEmailException();
        }

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }


    public function forgotPassword(string $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        $token = Str::random(60);

        PasswordReset::create([
            'email' => $user->email,
            'token' => $token,
        ]);
        event(new ForgotPassword($user, $token));

        return '';
    }

    public function resetPassword(string $email, string $password, string $token)
    {
        $passReset = PasswordReset::where('email', $email)->where('token', $token)->first();

        if (empty($passReset)){
            throw new ResetPasswordInvalidException();
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->password = bcrypt($password);
        $user->save();

        PasswordReset::where('email', $email)->delete();

        return '';

    }










}
