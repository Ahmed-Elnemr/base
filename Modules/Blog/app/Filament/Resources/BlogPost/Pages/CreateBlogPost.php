<?php

namespace Modules\Blog\Filament\Resources\BlogPost\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Blog\Filament\Resources\BlogPost\BlogPostResource;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;
}
