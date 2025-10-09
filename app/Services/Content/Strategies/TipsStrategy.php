<?php

declare(strict_types=1);

namespace App\Services\Content\Strategies;

use App\Models\Content;
use App\Services\Content\Interfaces\ContentStrategy;

class TipsStrategy implements ContentStrategy 
{
    public function create(array $data): ?Content
    {
        $content = Content::create($data);

        return $content; 
    }
}