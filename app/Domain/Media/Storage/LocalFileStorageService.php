<?php

declare(strict_types=1);

namespace App\Domain\Media\Storage;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Domain\Media\Contracts\FileStorageInterface;

class LocalFileStorageService implements FileStorageInterface
{
    /**
     * The function generates a base path for file uploads based on the current date.
     * 
     * @return string The function `generateBasePath()` returns a string representing the folder path
     * where files will be uploaded. The folder path is based on the current year, month, and day, and
     * it ensures that the folder structure exists by creating the necessary directories if they do not
     * already exist.
     */
    public function generateBasePath(): string
    {
        $now = Carbon::now();

        return sprintf(
            'uploads/%s/%s/%s/%s',
            $now->year,
            $now->format('m'),
            $now->format('d'),
            (string) Str::uuid()
        );
    }

    /**
     * The function putFile takes a disk, path, and file as input, and stores the file on the specified
     * disk with a hashed filename.
     * 
     * @param string disk The `disk` parameter specifies the storage disk to which the file will be
     * saved. This could be a local disk, a cloud storage disk (like Amazon S3), or any other disk
     * configured in your application.
     * @param string path The `path` parameter in the `putFile` function represents the directory path
     * where you want to store the uploaded file on the specified disk. It is the location within the
     * storage disk where the file will be saved.
     * @param UploadedFile file The `file` parameter in the `putFile` function is an instance of the
     * `UploadedFile` class. This class represents a file uploaded through a form in a web application.
     * It contains information about the uploaded file such as its name, size, MIME type, and other
     * properties. In the
     * 
     * @return string the path where the uploaded file is stored after using the `putFileAs` method
     * from the Laravel Storage facade.
     */
    public function putFile(string $disk, string $path, UploadedFile $file): string
    {
        return Storage::disk($disk)->putFileAs($path, $file, $file->hashName());
    }

    /**
     * The function `putContent` saves the provided content to a specified path on a given disk using
     * Laravel's Storage facade.
     * 
     * @param string disk The "disk" parameter refers to the disk where you want to store the content.
     * In Laravel, you can configure multiple disks in the filesystems.php configuration file, each
     * with its own storage location (local, S3, etc.). When calling the `putContent` function, you
     * specify the disk
     * @param string path The `path` parameter in the `putContent` function represents the location
     * where the content will be stored on the specified disk. It is a string that specifies the path
     * to the file where the content will be written.
     * @param string content The `content` parameter in the `putContent` function represents the data
     * that you want to store in a file. This could be text, binary data, JSON, XML, or any other type
     * of data that you want to write to a file on the specified disk at the given path.
     */
    public function putContent(string $disk, string $path, string $content): void
    {
        Storage::disk($disk)->put($path, $content);
    }
}