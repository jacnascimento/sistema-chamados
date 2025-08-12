<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tickets = $this->ticketService->getAllWithRelations();
        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        $ticket = $this->ticketService->createByUser($validatedData);

        return response()->json($ticket, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $ticket): JsonResponse
    {
        $ticketModel = $this->ticketService->findOrFailWithRelations($ticket);
        return response()->json($ticketModel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, int $ticket): JsonResponse
    {
        $ticketModel = $this->ticketService->updateWithRelations($ticket, $request->validated());
        
        if (!$ticketModel) {
            return response()->json(['message' => 'Ticket não encontrado'], 404);
        }

        return response()->json($ticketModel);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(int $ticket): JsonResponse
    {
        $deleted = $this->ticketService->delete($ticket);
        
        if (!$deleted) {
            return response()->json(['message' => 'Ticket não encontrado'], 404);
        }

        return response()->json('', 204);
    }
} 