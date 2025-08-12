<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements CrudRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     */
    public function all(array $with = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with($with)->get();
    }

    /**
     * Find record by ID
     */
    public function find(int $id, array $with = []): ?Model
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * Find record by ID or throw exception
     */
    public function findOrFail(int $id, array $with = []): Model
    {
        return $this->model->with($with)->findOrFail($id);
    }

    /**
     * Create new record
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update record
     */
    public function update(int $id, array $data): bool
    {
        $model = $this->find($id);
        
        if (!$model) {
            return false;
        }

        return $model->update($data);
    }

    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        $model = $this->find($id);
        
        if (!$model) {
            return false;
        }

        return $model->delete();
    }

    /**
     * Get paginated records
     */
    public function paginate(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return $this->model->with($with)->paginate($perPage);
    }
} 