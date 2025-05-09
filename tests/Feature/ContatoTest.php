<?php

namespace Tests\Feature;

use App\Jobs\ContatoCriadoJob;
use App\Models\Contato;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContatoTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_contatos()
    {

        $response = $this->getJson('/api/contatos');

        $response->assertStatus(200);
    }

    public function test_cadastrar_contato()
    {
        Queue::fake();
        $email = 'keven@email.com';

        $contato = Contato::where('email', $email)->first();
        if ($contato) {
            $contato->enderecos()->delete();
            $contato->delete();
        }

        $data = [
            'nome' => 'Keven Clayton',
            'email' => $email,
            'telefone' => '11999999999',
            'enderecos' => [
                [
                    'cep' => '12345-678',
                    'estado' => 'SP',
                    'cidade' => 'São Paulo',
                    'bairro' => 'Centro',
                    'endereco' => 'Rua XPTO',
                    'numero' => '100',
                    'complemento' => 'Bloco B'
                ]
            ]
        ];

        $response = $this->postJson('/api/contatos', $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['email' => 'keven@email.com']);

        $this->assertDatabaseHas('contatos', ['email' => 'keven@email.com']);

    }

    public function test_editar_contato()
    {
        $contato = Contato::factory()->create();

        $data = [
            'nome' => 'Nome Editado',
            'email' => $contato->email
        ];

        $response = $this->putJson("/api/contatos/{$contato->codigo}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Nome Editado']);

        $this->assertDatabaseHas('contatos', ['codigo' => $contato->codigo, 'nome' => 'Nome Editado']);
    }

    public function test_pode_excluir_contato()
    {
        $contato = Contato::factory()->create();

        $response = $this->deleteJson("/api/contatos/{$contato->codigo}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('contatos', ['codigo' => $contato->codigo]);
    }

    public function test_exporta_contatos_para_excel()
    {
        Contato::factory()->count(2)->create();

        $response = $this->get('/api/exportacao/excel?tipoExportacao=Contato');

        $response->assertStatus(200)
                 ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_dispara_email_na_fila()
    {
        Queue::fake();

        $data = [
            'nome' => 'Teste Fila',
            'email' => 'fila@email.com',
            'telefone' => '11999999999',
            'enderecos' => []
        ];

        $this->postJson('/api/contatos', $data);

        Queue::assertPushed(function (\Illuminate\Mail\SendQueuedMailable $mail) {
            return $mail->queue === 'back_emails';
        });
    }
}
