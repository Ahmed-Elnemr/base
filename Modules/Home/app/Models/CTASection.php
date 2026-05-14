<?php

namespace Modules\Home\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class CTASection extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'cta_sections';

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_url',
    ];

    public $translatable = ['title', 'subtitle', 'button_text'];
}
