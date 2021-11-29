<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface CrudService
{
    public function all();

    public function AllWithPagination($size);

    public function find($element): ?Model;

    /**
     * @param array $data
     */
    public function create(array $data);

    /**
     * @param $element
     * @param array $data
     */
    public function update($element, array $data);

    public function delete($element);
}
