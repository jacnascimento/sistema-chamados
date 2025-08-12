<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class TicketService extends BaseService
{
    public function __construct(TicketRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all tickets with relationships
     */
    public function getAllWithRelations(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->allWithRelations();
    }

    /**
     * Find ticket with relationships
     */
    public function findWithRelations(int $id): ?Ticket
    {
        return $this->repository->findWithRelations($id);
    }

    /**
     * Find ticket with relationships or throw exception
     */
    public function findOrFailWithRelations(int $id): Ticket
    {
        return $this->repository->findOrFailWithRelations($id);
    }

    /**
     * Create ticket with relationships
     */
    public function createWithRelations(array $data): Ticket
    {
        return $this->repository->createWithRelations($data);
    }

    /**
     * Update ticket and return with relationships
     */
    public function updateWithRelations(int $id, array $data): ?Ticket
    {
        return $this->repository->updateWithRelations($id, $data);
    }

    /**
     * Create ticket with authenticated user
     */
    public function createByUser(array $data): Ticket
    {
        // Debug: verificar autenticação
        \Log::info('Auth check: ' . (auth()->check() ? 'yes' : 'no'));
        \Log::info('Auth ID: ' . auth()->id());
        \Log::info('User: ' . (auth()->user() ? json_encode(auth()->user()->toArray()) : 'null'));
        
        $data['created_by'] = auth()->id() ?? 1;
        $data['status'] = $data['status'] ?? 'aberto';
        
        \Log::info('Final data: ' . json_encode($data));
        
        return $this->createWithRelations($data);
    }

    /**
     * Get tickets by status
     */
    public function getByStatus(string $status): Collection
    {
        return $this->repository->getByStatus($status);
    }

    /**
     * Get tickets by category
     */
    public function getByCategory(int $categoryId): Collection
    {
        return $this->repository->getByCategory($categoryId);
    }

    /**
     * Update ticket status
     */
    public function updateStatus(int $id, string $status): ?Ticket
    {
        return $this->updateWithRelations($id, ['status' => $status]);
    }
} 