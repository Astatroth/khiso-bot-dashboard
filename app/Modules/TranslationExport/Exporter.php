<?php


namespace App\Modules\TranslationExport;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Exporter
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $sourcePath;

    /**
     * @var string
     */
    private $stringsDomain = 'strings';

    /**
     * Exporter constructor.
     */
    public function __construct()
    {
        $this->filesystem = app('files');
        $this->sourcePath = lang_path();
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getMessages(): array
    {
        $messages = [];
        $path = $this->sourcePath;

        if (!$this->filesystem->exists($path)) {
            throw new \Exception("{$path} does not exist.");
        }

        foreach ($this->filesystem->allFiles($path) as $file) {
            $pathName = $file->getRelativePathname();
            $extension = $this->filesystem->extension($pathName);
            if ($extension !== 'php' && $extension !== 'json') {
                continue;
            }

            $key = substr($pathName, 0, -4);
            $key = str_replace('\\', '.', $key);
            $key = str_replace('/', '.', $key);
            [$locale, $key] = explode('.', $key);

            if (Str::startsWith($key, 'vendor') || $locale === 'messages') {
                continue;
            }

            $fullPath = $path.DIRECTORY_SEPARATOR.$pathName;
            if ($extension === 'php') {
                $messages[$locale][$key] = include $fullPath;
            } else {
                $fileContent = json_decode(file_get_contents($fullPath));

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new InvalidArgumentException(
                        'Error while trying to decode '.basename($fullPath).': '.json_last_error_msg()
                    );
                }

                foreach ($fileContent as $k => $value) {
                    $messages[$locale][$k] = $value;
                }
            }
        }

        $this->sortMessages($messages);

        return $messages;
    }

    /**
     * @param string $key
     * @return string
     */
    private function getVendorKey(string $key): string
    {
        $keyParts = explode('.', $key, 4);
        unset($keyParts[0]);

        return $keyParts[2].'.'.$keyParts[1].'::'.$keyParts[3];
    }

    /**
     * @param string $target
     * @param array  $options
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function performExport(string $target, array $options = [])
    {
        $messages = $this->getMessages();
        $this->prepareTarget($target);

        $template = $options['json']
            ? $template = $this->filesystem->get(__DIR__.'/Templates/messages.json')
            : $template = $this->filesystem->get(__DIR__.'/Templates/messages.js');

        $template = str_replace('\'{ messages }\'', json_encode($messages), $template);

        return $this->filesystem->put($target, $template);
    }

    /**
     * @param string $target
     */
    private function prepareTarget(string $target): void
    {
        $dirname = dirname($target);

        if (!$this->filesystem->exists($dirname)) {
            $this->filesystem->makeDirectory($dirname, 0755, true);
        }
    }

    /**
     * @param array|string $messages
     */
    private function sortMessages(&$messages): void
    {
        if (is_array($messages)) {
            ksort($messages);

            foreach ($messages as $key => &$value) {
                $this->sortMessages($value);
            }
        }
    }
}
