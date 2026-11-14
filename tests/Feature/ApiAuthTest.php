<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Vérifie que l'API n'est plus accessible sans token Sanctum.
 * Ces tests n'ont pas besoin de base de données.
 */
class ApiAuthTest extends TestCase
{
    public static function protectedEndpoints(): array
    {
        return [
            'liste clients'      => ['GET', '/api/v1/clients'],
            'création client'    => ['POST', '/api/v1/clients'],
            'suppression client' => ['DELETE', '/api/v1/clients/1'],
            'projets'            => ['GET', '/api/v1/projets'],
            'tâches'             => ['GET', '/api/v1/tasks'],
            'suppression tâche'  => ['DELETE', '/api/v1/tasks/1'],
            'journaux'           => ['GET', '/api/v1/journaux'],
            'articles'           => ['GET', '/api/v1/items'],
            'fournisseurs'       => ['GET', '/api/v1/providers'],
            'devis'              => ['GET', '/api/v1/invoices'],
            'devis du mois'      => ['POST', '/api/v1/get_month_invoices'],
            'factures'           => ['GET', '/api/v1/factures'],
            'pdf facture'        => ['GET', '/api/v1/facture_pdf/1/facture'],
            'achats'             => ['GET', '/api/v1/achats'],
            'transactions'       => ['GET', '/api/v1/transactions'],
            'favoris'            => ['GET', '/api/v1/favoris'],
            'personas'           => ['GET', '/api/v1/personas'],
            'demos'              => ['GET', '/api/demos'],
            'me'                 => ['GET', '/api/v1/me'],
            'logout'             => ['POST', '/api/v1/logout'],
            'user'               => ['GET', '/api/user'],
        ];
    }

    #[DataProvider('protectedEndpoints')]
    public function test_endpoint_refuse_les_requetes_sans_token(string $method, string $uri): void
    {
        $this->json($method, $uri)->assertUnauthorized();
    }

    public function test_inscription_desactivee_par_defaut(): void
    {
        $this->postJson('/api/v1/register', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password123',
        ])->assertNotFound();
    }

    public function test_me_renvoie_l_utilisateur_du_token_et_ignore_user_id(): void
    {
        $user = new User(['email' => 'moi@example.com', 'firstname' => 'Moi']);
        $user->id = 42;
        Sanctum::actingAs($user);

        $this->getJson('/api/v1/me?user_id=1')
            ->assertOk()
            ->assertJsonPath('data.id', 42)
            ->assertJsonPath('data.email', 'moi@example.com');
    }

    public function test_logout_authentifie_repond_200(): void
    {
        $user = new User(['email' => 'moi@example.com']);
        $user->id = 42;
        Sanctum::actingAs($user);

        $this->postJson('/api/v1/logout')
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}
