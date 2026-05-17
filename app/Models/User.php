<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\AccountStatusNotification;
use App\Traits\HasCustomMorphManyForNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Modules\Catalog\app\Models\Service;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    protected static function booted(): void
    {
        static::updated(function ($user) {
            if ($user->isDirty('status')) {
                $user->notify(new AccountStatusNotification($user->status));
            }
        });
    }

    public const CLIENT_TYPE_CUSTOMER = 'customer';

    public const CLIENT_TYPE_COMPANY = 'company';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasCustomMorphManyForNotifications, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'client_type',
        'phone',
        'city',
        'company_name',
        'company_bio',
        'commercial_register',
        'profile_image_path',
        'terms_accepted_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'profile_image_path',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'profile_image_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'terms_accepted_at' => 'datetime',
        ];
    }

    public function getProfileImageUrlAttribute(): ?string
    {
        if (! $this->profile_image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->profile_image_path);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }
}
