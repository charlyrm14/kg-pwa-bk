<?php

declare(strict_types=1);

namespace App\Domain\Media\Services;

use Illuminate\Support\Facades\{
    Storage,
    Log
};

class DirectoryDeleteService
{
    /**
     * Remove a directory if it is empty and recursively attempt to remove
     * its parent directories as long as they remain empty.
     *
     * This method performs a best-effort cleanup:
     * - It never throws exceptions outward.
     * - If any error occurs, it will be logged and the execution continues.
     *
     * This is useful after deleting media files to avoid leaving
     * orphaned empty folders in storage.
     *
     * @param string $disk Storage disk name (e.g. "public", "private").
     * @param string $path File path used to determine the base directory.
     *
     * @return void
     */
    public function deleteEmptyDirectory(string $disk, string $path)
    {
        try {

            $directory = dirname($path);

            while ($directory && $directory !== '.') {

                $files = Storage::disk($disk)->files($directory);
                $dirs  = Storage::disk($disk)->directories($directory);

                if (count($files) === 0 && count($dirs) === 0) {
                    Storage::disk($disk)->deleteDirectory($directory);
                    $directory = dirname($directory);
                } else {
                    break;
                }
            }

        } catch (\Throwable $e) {

            Log::warning('Directory cleanup failed', [
                'disk' => $disk,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
        }
    }
}