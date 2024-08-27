<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $primaryKey = 'id';

    public function __construct(protected Model $model)
    {
        
    }

    public function getAll(): Collection
    {
        return $this->model::get();
    }

    public function findBy(array $condition = []):Collection
    {
        return $this->model::where($condition)->get();
    }

    public function get(int $id):Model
    {
        return $this->model::find($id);
    }

    public function getWith(int $id, array $with = []):Model
    {
        return $this->model::with($with)->find($id);
    }

    public function getWithWhere(array $with = [], array $condition = []):Model
    {
        return $this->model::with($with)->where($condition)->first();
    }

    public function save(array $data): Model
    {
        return $this->model::create($data);
    }

    public function delete(int $id = null, array $condition = null):bool
    {
        if(null !== $condition) return $this->model::where($condition)->delete();

        return $this->model::where($this->primaryKey, $id)->delete();
    }

    public function getPaginatedWith(array $data = [], array $with = []): LengthAwarePaginator
    {
        $paginationLength = $data['perPage'] ?? config('general.request.paginationLength');

        $query = $this->model::with($with);

        $this->model->timestamps ? $query->latest() : $query->latest($this->primaryKey);

        return $query->paginate($paginationLength);
    }
}