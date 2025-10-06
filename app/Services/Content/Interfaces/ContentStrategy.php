<?php

declare(strict_types=1);

namespace App\Services\Content\Interfaces;

use App\Models\Content;
use Illuminate\Database\Eloquent\Collection;

interface ContentStrategy 
{
    /**
     * Create a content and return a response with the created content data
     * 
     * @return
     * data: array {
     *      name: string,
     *      slug: string,
     *      content: string,
     *      content_type: string,
     *      content_status_id: integer,
     *      author_name: string,
     *      published_at: ?string,
     *      created_at: string,
     *      updated_at: string
     * }
     */
    public function create(array $data): ?Content;
}
