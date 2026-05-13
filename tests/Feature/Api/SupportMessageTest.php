<?php
namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Support\app\Models\SupportPage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class SupportMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_support_message(): void
    {
        app()->setLocale('ar');

        Storage::fake('public');

        SupportPage::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->post('/api/v1/support/messages', [
            'full_name'    => 'Ahmed Elnemr',
            'phone'        => '0500000000',
            'email'        => 'ahmed@example.com',
            'message_type' => 'inquiry',
            'message'      => 'Hello support',
            'image'        => UploadedFile::fake()->image('support.jpg'),
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.full_name', 'Ahmed Elnemr');
        $response->assertJsonPath('data.message_type', 'inquiry');
        $response->assertJsonPath('data.status', 'new');
        $response->assertJsonPath('data.image_url', fn($url) => is_string($url) && $url !== '');

        $this->assertDatabaseHas('support_messages', [
            'full_name'    => 'Ahmed Elnemr',
            'phone'        => '0500000000',
            'email'        => 'ahmed@example.com',
            'message_type' => 'inquiry',
            'status'       => 'new',
            'locale'       => 'ar',
        ]);

        $messageId = $response->json('data.id');

        $this->assertTrue(Media::query()
                ->where('model_type', 'Modules\\Support\\app\\Models\\SupportMessage')
                ->where('model_id', $messageId)
                ->exists());
    }

    public function test_support_message_validation_fails_with_invalid_message_type(): void
    {
        $response = $this->postJson('/api/v1/support/messages', [
            'full_name'    => 'Ahmed',
            'message_type' => 'invalid',
            'message'      => 'Hello support',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message_type']);

        $this->assertDatabaseCount('support_messages', 0);
    }
}
