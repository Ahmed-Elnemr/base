<?php

namespace Modules\Home\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class HomeStat extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'value',
        'is_active',
        'sort_order',
    ];

    public $translatable = ['title', 'value'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
