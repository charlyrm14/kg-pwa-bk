<?php

declare(strict_types=1);

namespace App\Services\Content\Strategies;

use App\Models\Content;
use Illuminate\Support\Arr;
use App\Services\Content\Interfaces\ContentStrategy;

class EventStrategy implements ContentStrategy
{
    public function create(array $data): ?Content
    {
        $contentData = Arr::only($data, ['name', 'content', 'content_type_id', 'content_status_id', 'author_id']);        
        $contentDetail = Arr::only($data, ['location', 'start_date', 'end_date']);

        $content = Content::create($contentData);
        $content->event()->create($contentDetail);

        return $content;
    }
}