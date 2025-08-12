<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\TicketController;
use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class TicketControllerTest extends TestCase
{
    protected TicketController $controller;
    protected TicketService $ticketService;
    protected TicketRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->ticketService = Mockery::mock(TicketService::class);
        $this->controller = new TicketController($this->ticketService);
    }

    public function test_index_returns_json_response()
    {
        // Arrange
        $tickets = new \Illuminate\Database\Eloquent\Collection([
            new Ticket(['id' => 1, 'title' => 'Test 1']),
            new Ticket(['id' => 2, 'title' => 'Test 2'])
        ]);
        
        $this->ticketService->shouldReceive('getAllWithRelations')
            ->once()
            ->andReturn($tickets);

        // Act
        $response = $this->controller->index();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        // Comparar os dados serializados em vez do objeto
        $responseData = $response->getData(true);
        $this->assertCount(2, $responseData);
        $this->assertEquals('Test 1', $responseData[0]['title']);
        $this->assertEquals('Test 2', $responseData[1]['title']);
    }

    public function test_store_creates_ticket_and_returns_201()
    {
        // Arrange
        $ticketData = [
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'category_id' => 1,
        ];
        
        $createdTicket = new Ticket($ticketData + ['id' => 1, 'created_by' => 1, 'status' => 'aberto']);
        
        $this->ticketService->shouldReceive('createByUser')
            ->once()
            ->with($ticketData)
            ->andReturn($createdTicket);

        $request = Mockery::mock(TicketRequest::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($ticketData);

        // Act
        $response = $this->controller->store($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        
        // Comparar os dados em vez do objeto
        $responseData = $response->getData(true);
        $this->assertEquals($ticketData['title'], $responseData['title']);
        $this->assertEquals($ticketData['description'], $responseData['description']);
        $this->assertEquals($ticketData['category_id'], $responseData['category_id']);
        $this->assertEquals('aberto', $responseData['status']);
        $this->assertEquals(2, $responseData['created_by']);
    }

    public function test_show_returns_ticket()
    {
        // Arrange
        $ticketId = 1;
        $ticket = new Ticket(['id' => $ticketId, 'title' => 'Test Ticket']);
        
        $this->ticketService->shouldReceive('findOrFailWithRelations')
            ->once()
            ->with($ticketId)
            ->andReturn($ticket);

        // Act
        $response = $this->controller->show($ticketId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        // Comparar os dados em vez do objeto
        $responseData = $response->getData(true);
        if (isset($responseData['id'])) {
            $this->assertEquals($ticketId, $responseData['id']);
        }
        $this->assertEquals('Test Ticket', $responseData['title']);
    }

    public function test_show_throws_exception_when_ticket_not_found()
    {
        // Arrange
        $ticketId = 999;
        
        $this->ticketService->shouldReceive('findOrFailWithRelations')
            ->once()
            ->with($ticketId)
            ->andThrow(new \Illuminate\Database\Eloquent\ModelNotFoundException());

        // Assert
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        // Act
        $this->controller->show($ticketId);
    }

    public function test_update_returns_updated_ticket()
    {
        // Arrange
        $ticketId = 1;
        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'category_id' => 1,
        ];
        
        $updatedTicket = new Ticket($updateData + ['id' => $ticketId]);
        
        $this->ticketService->shouldReceive('updateWithRelations')
            ->once()
            ->with($ticketId, $updateData)
            ->andReturn($updatedTicket);

        $request = Mockery::mock(TicketRequest::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($updateData);

        // Act
        $response = $this->controller->update($request, $ticketId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        // Comparar os dados em vez do objeto
        $responseData = $response->getData(true);
        $this->assertEquals($updateData['title'], $responseData['title']);
        $this->assertEquals($updateData['description'], $responseData['description']);
        $this->assertEquals($updateData['category_id'], $responseData['category_id']);
    }

    public function test_update_returns_404_when_ticket_not_found()
    {
        // Arrange
        $ticketId = 999;
        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'category_id' => 1,
        ];
        
        $this->ticketService->shouldReceive('updateWithRelations')
            ->once()
            ->with($ticketId, $updateData)
            ->andReturn(null);

        $request = Mockery::mock(TicketRequest::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($updateData);

        // Act
        $response = $this->controller->update($request, $ticketId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['message' => 'Ticket não encontrado'], $response->getData(true));
    }

    public function test_destroy_returns_204_when_ticket_deleted()
    {
        // Arrange
        $ticketId = 1;
        
        $this->ticketService->shouldReceive('delete')
            ->once()
            ->with($ticketId)
            ->andReturn(true);

        // Act
        $response = $this->controller->destroy($ticketId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        // Para status 204, verificar que não há dados retornados
        $this->assertEquals('', $response->getData());
    }

    public function test_destroy_returns_404_when_ticket_not_found()
    {
        // Arrange
        $ticketId = 999;
        
        $this->ticketService->shouldReceive('delete')
            ->once()
            ->with($ticketId)
            ->andReturn(false);

        // Act
        $response = $this->controller->destroy($ticketId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['message' => 'Ticket não encontrado'], $response->getData(true));
    }

    public function test_controller_constructor_injects_ticket_service()
    {
        // Arrange & Act
        $controller = new TicketController($this->ticketService);
        
        // Assert
        $this->assertInstanceOf(TicketService::class, $controller->ticketService);
    }

    public function test_store_logs_validated_data()
    {
        // Arrange
        $ticketData = [
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'category_id' => 1,
        ];
        
        $createdTicket = new Ticket($ticketData + ['id' => 1, 'created_by' => 1, 'status' => 'aberto']);
        
        $this->ticketService->shouldReceive('createByUser')
            ->once()
            ->with($ticketData)
            ->andReturn($createdTicket);

        $request = Mockery::mock(TicketRequest::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($ticketData);

        // Mock Log facade
        Log::shouldReceive('info')
            ->once()
            ->with($ticketData);

        // Act
        $response = $this->controller->store($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
