<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class TranslationManagerService
{
    const GROUP_JSON = '_json';

    /**
     * @var array
     */
    protected $locales = [];

    /**
     * @var string
     */
    protected $ignoreFilePath;

    /**
     * @var array
     */
    protected $ignoredLocales = [];

    /**
     * TranslationManagerService constructor.
     *
     * @param Application $app
     * @param Filesystem  $filesystem
     * @param Dispatcher  $events
     */
    public function __construct(
        protected Application $app,
        protected Filesystem $filesystem,
        protected Dispatcher $events
    ) {
        $this->ignoreFilePath = storage_path('.ignore_locales');
        $this->ignoredLocales = $this->getIgnoredLocales();
    }

    /**
     * @param string|null $path
     * @return int
     */
    public function discoverTranslations(string $path = null): int
    {
        if (is_null($path)) {
            $path = base_path();
        }
        $groupKeys = [];
        $stringKeys = [];
        $functions = config('translation-manager.trans_functions');

        $groupPattern =                          // See https://regex101.com/r/WEJqdL/6
            "[^\w|>]" .                          // Must not have an alphanum or _ or > before real method
            '(' . implode('|', $functions) . ')' .  // Must start with one of the functions
            "\(" .                               // Match opening parenthesis
            "[\'\"]" .                           // Match " or '
            '(' .                                // Start a new group to match:
            '[\/a-zA-Z0-9_-]+' .                 // Must start with group
            "([.](?! )[^\1)]+)+" .               // Be followed by one or more items/keys
            ')' .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                             // Close parentheses or new parameter

        $stringPattern =
            "[^\w]".                                     // Must not have an alphanum before real method
            '('.implode('|', $functions).')'.             // Must start with one of the functions
            "\(\s*".                                       // Match opening parenthesis
            "(?P<quote>['\"])".                            // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)". // Match any string that can be {quote} escaped
            "\k{quote}".                                   // Match " or ' previously matched
            "\s*[\),]";                                    // Close parentheses or new parameter

        $finder = new Finder();
        $finder->in($path)
               ->exclude('storage')
               ->exclude('lang')
               ->exclude('vendor')
               ->name('*.php')
               ->name('*.vue')->files();

        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder as $file) {
            if (preg_match_all("/$groupPattern/siU", $file->getContents(), $matches)) {
                foreach ($matches[2] as  $key) {
                    $groupKeys[] = $key;
                }
            }

            if (preg_match_all("/$stringPattern/siU", $file->getContents(), $matches)) {
                foreach ($matches['string'] as $key) {
                    if (preg_match("/(^[\/a-zA-Z0-9_-]+([.][^\1)\ ]+)+$)/siU", $key, $groupMatches)) {
                        continue;
                    }

                    if (!(\Str::contains($key, '::') && \Str::contains($key, '.'))
                        || \Str::contains($key, ' ')) {
                        $stringKeys[] = $key;
                    }
                }
            }
        }

        $groupKeys = array_unique($groupKeys);
        $stringKeys = array_unique($stringKeys);

        foreach ($groupKeys as $key) {
            list($group, $item) = explode('.', $key, 2);
            $this->missingKey('', $group, $item);
        }

        foreach ($stringKeys as $key) {
            $group = self::GROUP_JSON;
            $item = $key;
            $this->missingKey('', $group, $item);
        }

        return count($groupKeys + $stringKeys);
    }

    /**
     *
     */
    protected function exportAllTranslations(): void
    {
        $groups = Translation::whereNotNull('value')->selectDistinctGroup()->get('group');

        foreach ($groups as $group) {
            if ($group->group === self::GROUP_JSON) {
                $this->exportTranslations(null, true);
            } else {
                $this->exportTRanslations($group->group);
            }
        }
    }

    /**
     * @param string|null $group
     * @param bool        $isJson
     */
    public function exportTranslations(string $group = null, bool $isJson = false): void
    {
        $group = basename($group);
        $basePath = lang_path();

        if (!is_null($group) && !$isJson) {
            if (!in_array($group, config('translation-manager.excluded_groups'))) {
                $vendor = false;

                if (!$group || $group === 'all') {
                    $this->exportAllTranslations();
                    return;
                } else {
                    if (\Str::startsWith($group, 'vendor')) {
                        $vendor = true;
                    }
                }

                $tree = $this->makeTree(
                    Translation::ofTranslatedGroups($group)
                               ->orderByGroupKeys(\Arr::get(config('translation-manager'), 'sort_keys', false))
                               ->get()
                );

                foreach ($tree as $locale => $groups) {
                    $locale = basename($locale);

                    if (isset($groups[$group])) {
                        $translations = $groups[$group];
                        $path = lang_path();
                        $localePath = $locale.DIRECTORY_SEPARATOR.$group;

                        if ($vendor) {
                            $path = $basePath.'/'.$group.'/'.$locale;
                            $localePath = \Str::after($group, '/');
                        }

                        $subFolders = explode(DIRECTORY_SEPARATOR, $localePath);
                        array_pop($subFolders);

                        $subFolderLevel = '';
                        foreach ($subFolders as $subFolder) {
                            $subFolderLevel = $subFolderLevel.$subFolder.DIRECTORY_SEPARATOR;
                            $tempPath = rtrim($path.DIRECTORY_SEPARATOR.$subFolderLevel, DIRECTORY_SEPARATOR);
                            if (!is_dir($tempPath)) {
                                mkdir($tempPath, 0777, true);
                            }
                        }

                        if ($vendor) {
                            $path = $path.DIRECTORY_SEPARATOR.'messages.php';
                        } else {
                            $path = $path.DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR.$group.'.php';
                        }

                        $output = "<?php\n\nreturn ".var_export($translations, true).';'.\PHP_EOL;
                        $this->filesystem->put($path, $output);
                    }
                }

                Translation::ofTranslatedGroups($group)->update([
                    'status' => Translation::STATUS_SAVED
                ]);
            }
        }

        if ($isJson) {
            $tree = $this->makeTree(
                Translation::ofTranslatedGroups(self::GROUP_JSON)
                           ->orderByGroupKeys(\Arr::get(config('translation-manager'), 'sort_keys', false))
                           ->get(),
                true
            );

            foreach ($tree as $locale => $groups) {
                if (isset($groups[self::GROUP_JSON])) {
                    $translations = $groups[self::GROUP_JSON];
                    $path = lang_path('/'.$locale.'.json');
                    $output = json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $this->filesystem->put($path, $output);
                }
            }

            Translation::ofTranslatedGroups(self::GROUP_JSON)->update([
                'status' => Translation::STATUS_SAVED
            ]);
        }

        \Artisan::call('app:export-translations -j');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getGroups(): \Illuminate\Support\Collection
    {
        $query = Translation::groupBy('group');
        $excludedGroups = config('translation-manager.excluded_groups');
        if (!empty($excludedGroups)) {
            $query->whereNotIn('group', $excludedGroups);
        }

        return $query->select('group')->orderBy('group')->get()->pluck('group', 'group');
    }

    /**
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getIgnoredLocales(): array
    {
        if (!$this->filesystem->exists($this->ignoreFilePath)) {
            return [];
        }

        $result = json_decode($this->filesystem->get($this->ignoreFilePath));

        return ($result && is_array($result)) ? $result : [];
    }

    /**
     * @param string      $group
     * @param string|null $search
     * @return array
     */
    public function getTranslations(
        string $group,
        string $search = null
    ): array {
        $results = Translation::where(function ($q) use ($group, $search) {
            if ($group !== 'all') {
                $q->where('group', $group);
            }

            if ($search && mb_strlen($search) >= 3) {
                $q->where('key', 'like', "%{$search}%");
            }
        })->orderBy('created_at', 'desc')->get();
        $translations = [];

        if ($results->isNotEmpty()) {
            foreach ($results as $result) {
                $translations[$result->key][$result->locale] = $result;
            }
        }

        return $translations;
    }

    /**
     * @param string $key
     * @param string|array $value
     * @param string $locale
     * @param string $group
     * @param bool   $replace
     * @return bool
     */
    public function importTranslation(
        string $key,
        string|array $value,
        string $locale,
        string $group,
        bool $replace = false
    ): bool {
        if (is_array($value)) {
            return false;
        }

        $translation = Translation::firstOrNew([
            'locale' => $locale,
            'group' => $group,
            'key' => $key
        ]);

        $status = $translation->value === $value ? Translation::STATUS_SAVED : Translation::STATUS_CHANGED;
        if ($status !== (int)$translation->status) {
            $translation->status = $status;
        }

        if ($replace || !$translation->value) {
            $translation->value = $value;
        }

        $translation->save();

        return true;
    }

    /**
     * @param int         $replace
     * @param string|null $basePath
     * @param bool        $importGroup
     * @return int
     */
    public function importTranslations(int $replace = 0, string $basePath = null, bool $importGroup = false): int
    {
        $count = 0;
        $vendor = true;

        if (is_null($basePath)) {
            $basePath = lang_path();
            $vendor = false;
        }

        foreach ($this->filesystem->directories($basePath) as $path) {
            $locale = basename($path);

            if ($locale === 'vendor') {
                foreach ($this->filesystem->directories($path) as $vendor) {
                    $count += $this->importTranslations($replace, $vendor);
                }

                continue;
            }

            $vendorName = $this->filesystem->name($this->filesystem->dirname($path));
            foreach ($this->filesystem->allFiles($path) as $file) {
                $info = pathinfo($file);
                $group = $info['filename'];
                if ($importGroup) {
                    if ($importGroup !== $group) {
                        continue;
                    }
                }

                if (in_array($group, config('translation-manager.excluded_groups'))) {
                    continue;
                }

                $subPath = str_replace($path.DIRECTORY_SEPARATOR, '', $info['dirname']);
                $subPath = str_replace(DIRECTORY_SEPARATOR, '/', $subPath);
                $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);

                if ($subPath !== $path) {
                    $group = $subPath.'/'.$group;
                }

                if (!$vendor) {
                    $translations = \Lang::getLoader()->load($locale, $group);
                } else {
                    $translations = include $file;
                    $group = 'vendor/'.$vendorName;
                }

                if ($translations && is_array($translations)) {
                    foreach (\Arr::dot($translations) as $key => $value) {
                        $importedTranslation = $this->importTranslation($key, $value, $locale, $group, $replace);
                        $count += $importedTranslation ? 1 : 0;
                    }
                }
            }
        }

        foreach ($this->filesystem->files(lang_path()) as $jsonFile) {
            if (strpos($jsonFile, '.json') === false) {
                continue;
            }

            $locale = basename($jsonFile, '.json');
            $group = self::GROUP_JSON;
            $translations = \Lang::getLoader()->load($locale, '*', '*');

            if ($translations && is_array($translations)) {
                foreach ($translations as $key => $value) {
                    $importedTranslation = $this->importTranslation($key, $value, $locale, $group, $replace);
                    $count += $importedTranslation ? 1 : 0;
                }
            }
        }

        return $count;
    }

    /**
     * @param $array
     * @param $key
     * @param $value
     * @return mixed
     */
    public function jsonSet(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }
        $array[$key] = $value;

        return $array;
    }

    /**
     * @param      $translations
     * @param bool $isJson
     * @return array
     */
    protected function makeTree($translations, bool $isJson = false): array
    {
        $array = [];
        foreach ($translations as $translation) {
            // For JSON and sentences, do not use dotted notation
            if ($isJson || \Str::contains($translation->key, [' ']) || \Str::endsWith($translation->key, ['.'])) {
                $this->jsonSet($array[$translation->locale][$translation->group], $translation->key,
                    $translation->value);
            } else {
                \Arr::set($array[$translation->locale][$translation->group], $translation->key,
                    $translation->value);
            }
        }

        return $array;
    }

    /**
     * @param string $namespace
     * @param string $group
     * @param string $key
     */
    public function missingKey(string $namespace, string $group, string $key): void
    {
        if (!in_array($group, config('translation-manager.excluded_groups'))) {
            Translation::firstOrCreate([
                'locale' => config('app.locale'),
                'group' => $group,
                'key' => $key
            ]);
        }
    }

    /**
     * @param string      $key
     * @param string      $language
     * @param string      $value
     * @param string|null $group
     * @return Translation
     */
    public function saveTranslation(string $key, string $language, string $value, string $group = null): Translation
    {
        $translation = Translation::firstOrNew([
            'group' => $group,
            'locale' => $language,
            'key' => $key
        ]);
        $translation->value = (string)$value ?: null;
        $translation->save();

        return $translation;
    }
}
