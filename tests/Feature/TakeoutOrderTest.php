<?php

namespace Tests\Feature;

use App\Models\TakeoutOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TakeoutOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_order_with_valid_data()
    {
        $data = [
            'nome_solicitante' => 'John Doe',
            'destino' => 'Paris',
            'data_ida' => '2024-12-01',
            'data_volta' => '2024-12-15',
        ];
        User::create([
            'name'=>'Breno',
            'email'=> 'teste@email.com',
            'password' => 'senha123',
        ]);

        $credentials = [
            'email' => 'teste@email.com',
            'password' => 'senha123',
        ];
        $token = JWTAuth::attempt($credentials); 
        $response = $this->postJson('/api/createOrder', $data, [
            'Authorization' => 'Bearer ' . $token,  // Incluindo o token no cabeçalho
        ]);

        $response->assertStatus(201);  // Verifica se foi criado com sucesso
        $response->assertJson($data);  // Verifica se os dados foram retornados corretamente
        $this->assertDatabaseHas('takeout_orders', $data);  // Verifica se o pedido foi salvo no banco
    }

    /** @test */
    public function it_returns_validation_error_for_missing_fields()
    {
        $data = [
            'nome_solicitante' => 'John Doe',
            'data_volta' => '2024-12-02',
            'data_ida' => '2024-12-01',
            // Falta o campo 'data_volta'
        ];

        User::create([
            'name'=>'Breno',
            'email'=> 'teste1@email.com',
            'password' => 'senha123',
        ]);

        $credentials = [
            'email' => 'teste1@email.com',
            'password' => 'senha123',
        ];
        $token = JWTAuth::attempt($credentials); 
        $response = $this->postJson('/api/createOrder', $data, [
            'Authorization' => 'Bearer ' . $token,  // Incluindo o token no cabeçalho
        ]);

        $response->assertStatus(422);  // Verifica erro de validação
        $response->assertJson([
            'error' => 'Erro de validação',
            'mensagem' => [
                'destino' => ['The destino field is required.']
            ]
        ]);
    }

    /** @test */
    public function it_returns_validation_error_for_invalid_dates()
    {
        $data = [
            'nome_solicitante' => 'John Doe',
            'destino' => 'Paris',
            'data_ida' => '2024-12-01',
            'data_volta' => '2024-11-30',  // Data de volta antes da data de ida
        ];

        User::create([
            'name'=>'Breno',
            'email'=> 'teste2@email.com',
            'password' => 'senha123',
        ]);

        $credentials = [
            'email' => 'teste2@email.com',
            'password' => 'senha123',
        ];
        $token = JWTAuth::attempt($credentials); 
        $response = $this->postJson('/api/createOrder', $data, [
            'Authorization' => 'Bearer ' . $token,  // Incluindo o token no cabeçalho
        ]);

        $response->assertStatus(422);  // Verifica erro de validação
        $response->assertJson([
            'error' => 'Erro de validação',
            'mensagem' => [
                'data_volta' => ["The data volta field must be a date after or equal to data ida."]
            ]
        ]);
    }
}
