<?php

declare(strict_types=1);

namespace App\Services\Content\Strategies;

use App\Models\Content;
use Illuminate\Support\Arr;
use App\Services\Content\Interfaces\ContentStrategy;

class NewsStrategy implements ContentStrategy 
{
    public function create(array $data): ?Content
    {
        $contentData = Arr::only($data, ['name', 'content', 'content_type_id', 'content_status_id', 'author_id']);

        $content = Content::create($contentData);

        return $content; 
    }
}