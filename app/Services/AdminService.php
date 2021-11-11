<?php


namespace App\Services;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public static function login($type, array $data): array
    {
//        Config::set('jwt.user', Admin::class);
//        Config::set('auth.admin', Admin::class);
        if (!$token = auth($type)->attempt($data)) {
            throw new \Exception(__('messages.invalid_login'), 401);
        }
        return self::createNewToken($token, $type);
    }

    public static function EmployeeLogin(array $data): array
    {
        $type = 'employee-api';
        if (!$token = auth($type)->attempt($data)) {
            throw new \Exception(__('messages.invalid_login'), 401);
        }
        return self::createNewToken($token, $type);
    }

    public static function createNewToken(string $token, $type)
    {
        return
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth($type)->factory()->getTTL() * 60
            ];
    }

    public static function updateProfile(array $data)
    {
        !isset($data['new_password']) ?: $data['password'] = Hash::make($data['new_password']);
        auth()->user()->update($data);
    }
}
