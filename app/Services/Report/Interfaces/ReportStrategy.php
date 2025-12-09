<?php

declare(strict_types=1);

namespace App\Services\Report\Interfaces;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ReportStrategy 
{
    /**
     * Create a content and return a response with the created content data
     * 
     * @return
     * BinaryFileResponse
     */
    public function generate(array $data): BinaryFileResponse;
}