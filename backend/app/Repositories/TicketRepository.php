<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository extends BaseRepository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

    /**
     * Get tickets with category and user relationships
     */
    public function allWithRelations(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->all(['category', 'createdBy']);
    }

    /**
     * Find ticket with category and user relationships
     */
    public function findWithRelations(int $id): ?Ticket
    {
        return $this->find($id, ['category', 'createdBy']);
    }

    /**
     * Find ticket with category and user relationships or throw exception
     */
    public function findOrFailWithRelations(int $id): Ticket
    {
        return $this->findOrFail($id, ['category', 'createdBy']);
    }

    /**
     * Create ticket with relationships
     */
    public function createWithRelations(array $data): Ticket
    {
        $ticket = $this->create($data);
        return $ticket->load(['category', 'createdBy']);
    }

    /**
     * Update ticket and return with relationships
     */
    public function updateWithRelations(int $id, array $data): ?Ticket
    {
        $updated = $this->update($id, $data);
        
        if ($updated) {
            return $this->findWithRelations($id);
        }

        return null;
    }

    /**
     * Get tickets by status
     */
    public function getByStatus(string $status): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['category', 'createdBy'])
            ->where('status', $status)
            ->get();
    }

    /**
     * Get tickets by category
     */
    public function getByCategory(int $categoryId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['category', 'createdBy'])
            ->where('category_id', $categoryId)
            ->get();
    }
} 