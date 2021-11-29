<?php


namespace App\Services;

use App\Models\Company;
use App\Repository\CrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CompanyCrudService implements CrudService
{
    public function __construct(
        protected Company $model,
    )
    {
    }

    public function all()
    {
    }

    public function AllWithPagination($size): LengthAwarePaginator
    {
        return $this->model->query()->paginate($size);
    }

    public function create(array $data): Model
    {
        $data['creator_id'] = Auth::id();
        return $this->model->create($data);
    }

    public function find($element): ?Model
    {
        return $this->model->findOrFail($element);
    }

    public function update($element, array $data): Model
    {
        $data['creator_id'] = Auth::id();
        $this->find($element)->update($data);
        return $this->find($element);
    }

    public function delete($element)
    {
        $this->find($element)->delete();
    }


}
