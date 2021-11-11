<?php


namespace App\Services;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function index($size, $position = null): LengthAwarePaginator
    {
        return Employee::query()
            ->when(isset($position), function ($employee, $position) {
                return $employee->wherePositionId($position);
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
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $employee->update($data);
    }

    public function updateProfile(array $data)
    {
        !isset($data['new_password']) ?: $data['password'] = Hash::make($data['new_password']);
        auth()->user()->update($data);
    }

    public function delete(string $name)
    {
        if ($name === 'superadmin') {
            throw new \Exception(__('messages.cannot_change_superadmin'), 403);
        }
        $role = Role::where(['name' => $name])->first();
        $role->delete();
    }
}
