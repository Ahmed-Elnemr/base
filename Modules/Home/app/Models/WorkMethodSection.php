<?php

namespace Modules\Home\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class WorkMethodSection extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'work_method_sections';

    protected $fillable = [
        'title',
        'steps',
    ];

    public $translatable = ['title', 'steps'];

    protected $casts = [
        'steps' => 'array',
    ];
}
