<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    public function getAll(): Collection;
    public function findBy(array $condition = []): ?Collection;
    public function findOneBy(array $condition = []): ?Model;
    public function get(int $id): ?Model;
    public function getWith(int $id, array $with = []): ?Model;
    public function getWithWhere(array $with = [], array $condition = []): ?Model;
    public function save(array $data): Model;
    public function update(array $data, int $id): Model;
    public function delete(int $id = null, array $condition = null): bool;
    public function getPaginatedWith(array $data = [], array $with = []): LengthAwarePaginator;
}
