<?php

declare(strict_types=1);

namespace App\Domain\Contents\Events;

use App\Models\Content;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentPublishedEvent
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public readonly Content $content
    ){}
}

