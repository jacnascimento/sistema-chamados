<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Get categories with creator relationship
     */
    public function allWithCreator(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->all(['creator']);
    }

    /**
     * Find category with creator relationship
     */
    public function findWithCreator(int $id): ?Category
    {
        return $this->find($id, ['creator']);
    }

    /**
     * Find category with creator relationship or throw exception
     */
    public function findOrFailWithCreator(int $id): Category
    {
        return $this->findOrFail($id, ['creator']);
    }

    /**
     * Create category with creator
     */
    public function createWithCreator(array $data): Category
    {
        $category = $this->create($data);
        return $category->load('creator');
    }

    /**
     * Update category and return with creator
     */
    public function updateWithCreator(int $id, array $data): ?Category
    {
        $updated = $this->update($id, $data);
        
        if ($updated) {
            return $this->findWithCreator($id);
        }

        return null;
    }
} 