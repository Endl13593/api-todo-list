<?php


namespace App\Services;


use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Models\User;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws LoginInvalidException
     */
    public function login(string $email, string $password): array
    {
        $login = [
            'email'    => $email,
            'password' => $password
        ];

        if (!$token = auth()->attempt($login)) {
            throw new LoginInvalidException();
        }

        return [
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return User
     * @throws UserHasBeenTakenException
     */
    public function register(string $firstName, string $lastName, string $email, string $password): User
    {
        $user = User::whereEmail($email)->exists();

        if($user) {
            throw new UserHasBeenTakenException();
        }

        $userPassword = bcrypt($password ?? Str::random(10));

        $user = new User();
        $user->first_name = $firstName;
        $user->last_name  = $lastName;
        $user->email      = $email;
        $user->password   = $userPassword;
        $user->confirmation_token   = Str::random(60);
        $user->save();

        event(new UserRegistered($user));

        return $user;
    }

    /**
     * @param string $token
     * @return User
     * @throws VerifyEmailTokenInvalidException
     */
    public function verifyEmail(string $token): User
    {
        $user = User::whereConfirmationToken($token)->first();

        if (!$user) {
            throw new VerifyEmailTokenInvalidException();
        }

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }
}
