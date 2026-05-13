<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\CustomNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test sending a notification to a user.
     */
    public function test_can_send_notification_to_user(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $user->notify(new CustomNotification(
            title: [
                'en' => 'Test Notification',
                'ar' => 'إشعار تجريبي'
            ],
            body: [
                'en' => 'This is a test notification',
                'ar' => 'هذا إشعار تجريبي'
            ],
            type: 'test',
            modelId: null
        ));

        Notification::assertSentTo($user, CustomNotification::class);
    }

    /**
     * Test getting notifications via API.
     */
    public function test_can_get_notifications_via_api(): void
    {
        $user = User::factory()->create();

        $user->notify(new CustomNotification(
            title: ['en' => 'Test', 'ar' => 'اختبار'],
            body: ['en' => 'Message', 'ar' => 'رسالة'],
            type: 'test',
            modelId: null
        ));

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/notifications');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'notifications' => [
                        'data' => [
                            '*' => [
                                'id',
                                'data' => [
                                    'title',
                                    'message',
                                    'type',
                                    'model_id'
                                ],
                                'is_read',
                                'created_at'
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test getting unread count via API.
     */
    public function test_can_get_unread_count_via_api(): void
    {
        $user = User::factory()->create();

        $user->notify(new CustomNotification(
            title: ['en' => 'Test', 'ar' => 'اختبار'],
            body: ['en' => 'Message', 'ar' => 'رسالة'],
            type: 'test',
            modelId: null
        ));

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/notifications/unread');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'unread_count' => 1
                ]
            ]);
    }

    /**
     * Test deleting a notification via API.
     */
    public function test_can_delete_notification_via_api(): void
    {
        $user = User::factory()->create();

        $user->notify(new CustomNotification(
            title: ['en' => 'Test', 'ar' => 'اختبار'],
            body: ['en' => 'Message', 'ar' => 'رسالة'],
            type: 'test',
            modelId: null
        ));

        $notification = $user->notifications()->first();

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/v1/notifications/{$notification->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('notifications', [
            'id' => $notification->id
        ]);
    }

    /**
     * Test deleting all notifications via API.
     */
    public function test_can_delete_all_notifications_via_api(): void
    {
        $user = User::factory()->create();

        // Create multiple notifications
        for ($i = 0; $i < 3; $i++) {
            $user->notify(new CustomNotification(
                title: ['en' => "Test $i", 'ar' => "اختبار $i"],
                body: ['en' => "Message $i", 'ar' => "رسالة $i"],
                type: 'test',
                modelId: null
            ));
        }

        $this->assertEquals(3, $user->notifications()->count());

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/notifications');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertEquals(0, $user->notifications()->count());
    }

    /**
     * Test notifications require authentication.
     */
    public function test_notifications_require_authentication(): void
    {
        $response = $this->getJson('/api/v1/notifications');
        $response->assertStatus(401);

        $response = $this->getJson('/api/v1/notifications/unread');
        $response->assertStatus(401);

        $response = $this->deleteJson('/api/v1/notifications/fake-uuid');
        $response->assertStatus(401);

        $response = $this->deleteJson('/api/v1/notifications');
        $response->assertStatus(401);
    }
}
