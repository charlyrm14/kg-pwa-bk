<?php

declare(strict_types=1);

namespace App\Services\Content\Interfaces;

use App\Models\Content;

interface ContentStrategy 
{
    /**
     * Create a content and return a response with the created content data
     * 
     * @return
     * data: array {
     *      name: string
     *      slug: string
     *      content: string
     *      content_type: string
     *      status: string
     *      author: string
     *      published_at: string
     *      created_at: string
     *      updated_at: string
     *      details: null | array {
     *          location: string
     *          start_date: string
     *          end_date: string
     *      }
     * }
     */
    public function create(array $data): ?Content;
}
