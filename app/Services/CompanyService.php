<?php


namespace App\Services;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyService
{
    public function index($size): LengthAwarePaginator
    {
        return Company::query()->paginate($size);
    }

    public function create(array $data): Model|Builder
    {
        $data['creator_id'] = Auth::id();
        return Company::create($data);
    }

    public function update(Company $company, array $data)
    {
        $data['creator_id'] = Auth::id();//yangilovchi
        $company->update($data);
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
