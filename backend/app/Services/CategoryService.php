<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService extends BaseService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all categories with creator
     */
    public function getAllWithCreator(): Collection
    {
        return $this->repository->allWithCreator();
    }

    /**
     * Find category with creator
     */
    public function findWithCreator(int $id): ?Category
    {
        return $this->repository->findWithCreator($id);
    }

    /**
     * Find category with creator or throw exception
     */
    public function findOrFailWithCreator(int $id): Category
    {
        return $this->repository->findOrFailWithCreator($id);
    }

    /**
     * Create category with creator
     */
    public function createWithCreator(array $data): Category
    {
        return $this->repository->createWithCreator($data);
    }

    /**
     * Update category and return with creator
     */
    public function updateWithCreator(int $id, array $data): ?Category
    {
        return $this->repository->updateWithCreator($id, $data);
    }

    /**
     * Create category with authenticated user
     */
    public function createByUser(array $data): Category
    {
        $data['created_by'] = auth()->id() ?? 1;
        return $this->createWithCreator($data);
    }
} 