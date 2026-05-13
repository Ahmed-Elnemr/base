<?php
namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_receive_token(): void
    {
        Storage::fake('public');

        $response = $this->postJson('/api/auth/register', [
            'client_type'           => User::CLIENT_TYPE_CUSTOMER,
            'name'                  => 'Test User',
            'email'                 => 'user@example.com',
            'phone'                 => '0500000000',
            'city'                  => 'Riyadh',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'terms_accepted'        => true,
            'profile_image'         => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.user.email', 'user@example.com');
        $response->assertJsonPath('data.token_type', 'Bearer');

        $this->assertDatabaseHas('users', [
            'email'       => 'user@example.com',
            'phone'       => '0500000000',
            'client_type' => User::CLIENT_TYPE_CUSTOMER,
        ]);

        $user = User::firstWhere('email', 'user@example.com');
        $this->assertNotNull($user->profile_image_path);
        Storage::disk('public')->assertExists($user->profile_image_path);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'phone'       => '0501234567',
            'password'    => 'password',
            'client_type' => User::CLIENT_TYPE_CUSTOMER,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'phone'       => '0501234567',
            'password'    => 'password',
            'client_type' => User::CLIENT_TYPE_CUSTOMER,
        ]);

        $response->assertOk();
        $response->assertJsonPath('data.user.id', $user->id);
        $response->assertJsonPath('data.token_type', 'Bearer');
    }

    public function test_login_fails_with_bad_credentials(): void
    {
        User::factory()->create([
            'phone'       => '0590000000',
            'password'    => 'password',
            'client_type' => User::CLIENT_TYPE_CUSTOMER,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'phone'       => '0590000000',
            'password'    => 'wrong-password',
            'client_type' => User::CLIENT_TYPE_CUSTOMER,
        ]);

        $response->assertStatus(401);
        $response->assertJsonPath('status_code', 401);
    }

    public function test_authenticated_user_can_logout_and_fetch_profile(): void
    {
        $user = User::factory()->create([
            'client_type' => User::CLIENT_TYPE_CUSTOMER,
            'phone'       => '0512345678',
        ]);
        $newToken       = $user->createToken('api');
        $plainTextToken = $newToken->plainTextToken;
        $tokenId        = $newToken->accessToken->id;

        $meResponse = $this->withHeader('Authorization', 'Bearer ' . $plainTextToken)
            ->getJson('/api/auth/me');

        $meResponse->assertOk();
        $meResponse->assertJsonPath('data.user.id', $user->id);

        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $plainTextToken)
            ->postJson('/api/auth/logout');

        $logoutResponse->assertOk();
        $logoutResponse->assertJsonPath('message', __('auth.logout.success'));

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }
}
