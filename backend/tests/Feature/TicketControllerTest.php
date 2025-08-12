<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Mockery;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected Category $category;
    protected TicketService $ticketService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Criar usuário e categoria para os testes
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create([
            'created_by' => $this->user->id
        ]);
        
        // Usar o Passport para autenticação API
        Passport::actingAs($this->user, ['*']);
        
        // Verificar se a autenticação está funcionando
        $this->assertAuthenticated();
    }

    public function test_index_returns_all_tickets()
    {
        // Criar alguns tickets
        Ticket::factory()->count(3)->create([
            'created_by' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->getJson('/api/tickets');

        $response->assertStatus(200)
                ->assertJsonCount(3);
    }

    public function test_store_creates_new_ticket()
    {
        $ticketData = [
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'category_id' => $this->category->id,
        ];

        // Debug: verificar se o usuário está autenticado
        $this->assertAuthenticated();
        dump('User ID: ' . auth()->id());
        dump('User authenticated: ' . (auth()->check() ? 'yes' : 'no'));

        $response = $this->postJson('/api/tickets', $ticketData);

        // Debug: verificar a resposta
        dump('Response status: ' . $response->status());
        dump('Response data: ' . $response->getContent());

        $response->assertStatus(201)
                ->assertJson([
                    'title' => 'Test Ticket',
                    'description' => 'Test Description',
                    'category_id' => $this->category->id,
                    'status' => 'aberto',
                    'created_by' => $this->user->id
                ]);

        $this->assertDatabaseHas('tickets', [
            'title' => 'Test Ticket',
            'created_by' => $this->user->id
        ]);
    }

    public function test_store_validates_required_fields()
    {
        $response = $this->postJson('/api/tickets', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'description', 'category_id']);
    }



    public function test_store_validates_category_exists()
    {
        $ticketData = [
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'category_id' => 99999, // ID inexistente
        ];

        $response = $this->postJson('/api/tickets', $ticketData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['category_id']);
    }

    public function test_show_returns_ticket()
    {
        $ticket = Ticket::factory()->create([
            'created_by' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->getJson("/api/tickets/{$ticket->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $ticket->id,
                    'title' => $ticket->title
                ]);
    }

    public function test_show_returns_404_for_nonexistent_ticket()
    {
        $response = $this->getJson('/api/tickets/99999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_ticket()
    {
        $ticket = Ticket::factory()->create([
            'created_by' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'category_id' => $this->category->id,
        ];

        $response = $this->putJson("/api/tickets/{$ticket->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'title' => 'Updated Title',
                    'description' => 'Updated Description',
                ]);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Updated Title'
        ]);
    }

    public function test_update_returns_404_for_nonexistent_ticket()
    {
        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'category_id' => $this->category->id,
        ];

        $response = $this->putJson('/api/tickets/99999', $updateData);

        $response->assertStatus(404)
                ->assertJson(['message' => 'Ticket não encontrado']);
    }

    public function test_update_validates_data()
    {
        $ticket = Ticket::factory()->create([
            'created_by' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->putJson("/api/tickets/{$ticket->id}", []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'description', 'category_id']);
    }

    public function test_destroy_deletes_ticket()
    {
        $ticket = Ticket::factory()->create([
            'created_by' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->deleteJson("/api/tickets/{$ticket->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    public function test_destroy_returns_404_for_nonexistent_ticket()
    {
        $response = $this->deleteJson('/api/tickets/99999');

        $response->assertStatus(404)
                ->assertJson(['message' => 'Ticket não encontrado']);
    }

    public function test_store_sets_default_status_and_created_by()
    {
        $ticketData = [
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'category_id' => $this->category->id,
        ];

        $response = $this->postJson('/api/tickets', $ticketData);

        $response->assertStatus(201);
        
        $ticket = Ticket::where('title', 'Test Ticket')->first();
        $this->assertEquals('aberto', $ticket->status);
        $this->assertEquals($this->user->id, $ticket->created_by);
    }

    public function test_title_can_be_updated_to_same_title_for_same_ticket()
    {
        $ticket = Ticket::factory()->create([
            'title' => 'Original Title',
            'created_by' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $updateData = [
            'title' => 'Original Title', // Mesmo título
            'description' => 'Updated Description',
            'category_id' => $this->category->id,
        ];

        $response = $this->putJson("/api/tickets/{$ticket->id}", $updateData);

        $response->assertStatus(200); // Deve funcionar
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
