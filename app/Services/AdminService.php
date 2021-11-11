<?php


namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public static function Login(array $data): array
    {
        if (!$token = auth('api')->attempt($data)) {
            throw new \Exception(__('messages.invalid_login'), 401);
        }

        return self::createNewToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    public static function createNewToken(string $token)
    {
        return
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ];
    }

    public static function updateProfile(array $data)
    {
        !isset($data['new_password']) ?: $data['password'] = Hash::make($data['new_password']);
        auth()->user()->update($data);
    }
}
