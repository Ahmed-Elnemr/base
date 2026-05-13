<?php

namespace Tests\Feature\Filament;

use App\Models\Admin;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Models\SupportMessage;
use Modules\Support\Filament\Resources\SupportMessage\Pages\EditSupportMessage;
use Modules\Support\Filament\Resources\SupportMessage\Pages\ListSupportMessages;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SupportMessageResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_support_messages_in_dashboard(): void
    {
        Filament::setCurrentPanel('admin');

        /** @var Admin $admin */
        $admin = Admin::factory()->createOne();
        $role = Role::query()->create([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);
        $admin->assignRole($role);

        $message = SupportMessage::factory()->create([
            'full_name' => 'Ahmed Elnemr',
        ]);

        $this->actingAs($admin, 'admin');

        Livewire::test(ListSupportMessages::class)
            ->assertCanSeeTableRecords([$message]);
    }

    public function test_admin_can_update_support_message_status(): void
    {
        Filament::setCurrentPanel('admin');

        /** @var Admin $admin */
        $admin = Admin::factory()->createOne();
        $role = Role::query()->create([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);
        $admin->assignRole($role);

        $message = SupportMessage::factory()->create([
            'status' => SupportMessageStatusEnum::New->value,
        ]);

        $this->actingAs($admin, 'admin');

        Livewire::test(EditSupportMessage::class, [
            'record' => $message->getKey(),
        ])
            ->fillForm([
                'status' => SupportMessageStatusEnum::Resolved->value,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('support_messages', [
            'id' => $message->id,
            'status' => SupportMessageStatusEnum::Resolved->value,
        ]);
    }
}
