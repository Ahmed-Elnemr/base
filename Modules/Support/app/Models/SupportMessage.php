<?php
namespace Modules\Support\app\Models;

use Database\Factories\SupportMessageFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Support\app\Enums\SupportMessageStatusEnum;
use Modules\Support\app\Enums\SupportMessageTypeEnum;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SupportMessage extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected static function newFactory(): Factory
    {
        return SupportMessageFactory::new ();
    }

    protected $fillable = [
        'full_name',
        'support_page_id',
        'phone',
        'email',
        'message_type',
        'message',
        'status',
        'locale',
    ];

    protected $casts = [
        'message_type' => SupportMessageTypeEnum::class,
        'status'       => SupportMessageStatusEnum::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('support_message_image')
            ->useDisk('public')
            ->singleFile();
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(SupportPage::class, 'support_page_id');
    }
}
