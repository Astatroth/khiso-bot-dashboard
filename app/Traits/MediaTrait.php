<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;

trait MediaTrait
{
    /**
     * @var string[]
     */
    protected $forbiddenSymbols = [
        ' ', '#', '<', '>', '$', '+', '%', '!', '`', '&', '*', '\'', '|', '{', '}', '?', '"', '=', '/', ':', '\\', '@'
    ];

    /**
     * @param string|array|Collection $files
     * @param string|null             $attribute
     * @return void
     */
    public function deleteFiles(string|array|Collection $files, string $attribute = null): void
    {
        if (is_string($files)) {
            \File::delete(storage_path('app/public/files/shares'.$files));
        } else {
            foreach ($files as $file) {
                \File::delete(storage_path('app/public/files/shares'.$file->{$attribute}));
            }
        }
    }

    /**
     * @param UploadedFile $file
     * @param bool         $preserveOriginalName
     * @return object
     */
    protected function resolveFilename(UploadedFile $file, bool $preserveOriginalName): object
    {
        $parts = explode('.', $file->getClientOriginalName());
        $name = $preserveOriginalName
            ? \Str::transliterate(str_replace($this->forbiddenSymbols, '_', $parts[0]), '_').'_'.uniqid()
            : md5(time().uniqid());

        $dir = substr(md5(date('d-m-Y')), 0, 2)
            .'/'.substr(md5(date('H:i')), 0, 2);

        return (object)[
            'name' => $name,
            'extension' => last($parts),
            'dir' => $dir,
            'path' => $this->resolveStoragePath()
        ];
    }

    /**
     * @return string
     */
    protected function resolveStoragePath(): string
    {
        return storage_path('app/public/files/shares/');
    }

    /**
     * @param UploadedFile $file
     * @param bool         $preserveOriginalName
     * @return string
     */
    public function uploadFile(UploadedFile $file, bool $preserveOriginalName = false): string
    {
        $filename = $this->resolveFilename($file, $preserveOriginalName);

        app('files')->ensureDirectoryExists($filename->path.$filename->dir, 0755, true);

        $path = $filename->dir.'/'.$filename->name.'.'.$filename->extension;

        $file->storeAs('files/shares/'.$path);

        return '/'.$path;
    }

    /**
     * @param UploadedFile $file
     * @param bool         $preserveOriginalName
     * @param string       $encodeTo
     * @param int          $width
     * @param int          $height
     * @return string
     */
    public function uploadImage(
        UploadedFile $file,
        bool $preserveOriginalName = false,
        string $encodeTo = '',
        int $width = 0,
        int $height = 0
    ): string {
        $filename = $this->resolveFilename($file, $preserveOriginalName);
        $image = Image::make($file);

        // TODO: smart resizing

        if ($encodeTo) {
            $image->encode($encodeTo);
            $filename->extension = $encodeTo;
        }

        app('files')->ensureDirectoryExists($filename->path.$filename->dir, 0755, true);

        $path = $filename->dir.'/'.$filename->name.'.'.$filename->extension;

        $image->save($filename->path.$path);

        return '/'.$path;
    }
}
