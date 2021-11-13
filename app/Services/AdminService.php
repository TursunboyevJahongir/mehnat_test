<?php


namespace App\Services;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public static function login($type, array $data): array
    {
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

    public function index($size, $role = null): LengthAwarePaginator
    {
        return Admin::query()
            ->when(isset($role), function ($query) use ($role) {
                return $query->whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role);
                });
            })
            ->paginate($size);
    }

    public function companyEmployees(Company $company, $size, $position = null): LengthAwarePaginator
    {
        return $company
            ->employees()
            ->when(isset($position), function ($employee, $position) {
                return $employee->wherePositionId($position);
            })
            ->paginate($size);
    }

    public function create(array $data): Model|Builder
    {
        $data['password'] = Hash::make($data['password']);

        $admin = Admin::create($data);
        if (isset($data['roles']) && !in_array('superadmin', $data['roles']))
            $admin->assignRole($data['roles']);
        return $admin;
    }

    public function update(Admin $admin, array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if (!$admin->hasRole('superadmin'))
            if (isset($data['roles'])) {
                if (!in_array('superadmin', $data['roles']))
                    $admin->syncRoles($data['roles']);
            } else $admin->syncRoles(null);
        $admin->update($data);
    }

    public function updateProfile(array $data)
    {
        !isset($data['new_password']) ?: $data['password'] = Hash::make($data['new_password']);
        auth()->user()->update($data);
    }

    public function delete(Admin $id)
    {
        if ($id->id === Auth::id())
            throw new \Exception(__('messages.fail'), 403);

        if ($id->hasRole('superadmin'))
            throw new \Exception(__('messages.cannot_change_superadmin'), 403);
        $name = $id->name;
        $id->delete();
        return $name;
    }
}
