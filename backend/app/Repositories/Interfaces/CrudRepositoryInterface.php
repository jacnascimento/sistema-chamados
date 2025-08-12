<?php

namespace App\Repositories\Interfaces;

interface CrudRepositoryInterface
{
    /**
     * Get all records
     */
    public function all(array $with = []): \Illuminate\Database\Eloquent\Collection;

    /**
     * Find record by ID
     */
    public function find(int $id, array $with = []): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Find record by ID or throw exception
     */
    public function findOrFail(int $id, array $with = []): \Illuminate\Database\Eloquent\Model;

    /**
     * Create new record
     */
    public function create(array $data): \Illuminate\Database\Eloquent\Model;

    /**
     * Update record
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete record
     */
    public function delete(int $id): bool;

    /**
     * Get paginated records
     */
    public function paginate(int $perPage = 15, array $with = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
} 