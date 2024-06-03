<?php

namespace App\Console\Commands;

use App\Modules\TranslationExport\Exporter;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ExportTranslations extends Command
{
    /**
     * @var Exporter
     */
    protected $exporter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-translations
        {target? : Output path}
        {--j|json : Export as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates JS translation files which can be used by a frontend framework.';

    /**
     * ExportTranslations constructor.
     *
     * @param Exporter $generator
     */
    public function __construct(Exporter $exporter)
    {
        $this->exporter = $exporter;

        parent::__construct();
    }

    /**
     * @return string
     */
    protected function getDefaultPath(array $options): string
    {
        return public_path('messages.'.($options['json'] ? 'json' : 'js'));
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $options = [
            'json' => $this->option('json')
        ];
        $target = $this->argument('target') ?: $this->getDefaultPath($options);

        if ($this->exporter->performExport($target, $options) !== false) {
            $this->info("File created: {$target}");

            return 0;
        }

        $this->error("Could not create file: {$target}");

        return 1;
    }
}
