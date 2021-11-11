<?php


namespace App\Services;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DirectorEmployeeService
{
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
        $data['company_id'] = auth()->user()->director->id;
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

    public function show(Employee $employee): Employee
    {
        $this->isMyWorker($employee);
        return $employee;
    }

    public function delete(Employee $employee)
    {
        $this->isMyWorker($employee);
        $employee->delete();
    }

    public function isMyWorker(Employee $employee)
    {
        if ($employee->company_id !== auth()->user()->director->id) {
            throw new \Exception(__('messages.isnt_your_worker'), 403);
        }
    }
}
