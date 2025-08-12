<?php

namespace App\Services;

use App\Services\Interfaces\CrudServiceInterface;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseService implements CrudServiceInterface
{
    protected CrudRepositoryInterface $repository;

    public function __construct(CrudRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     */
    public function getAll(array $with = []): Collection
    {
        return $this->repository->all($with);
    }

    /**
     * Find record by ID
     */
    public function find(int $id, array $with = []): ?Model
    {
        return $this->repository->find($id, $with);
    }

    /**
     * Find record by ID or throw exception
     */
    public function findOrFail(int $id, array $with = []): Model
    {
        return $this->repository->findOrFail($id, $with);
    }

    /**
     * Create new record
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update record
     */
    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get paginated records
     */
    public function paginate(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $with);
    }
} 