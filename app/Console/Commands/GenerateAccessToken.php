<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-access-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an API access token.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = hash('sha256', uniqid().rand(1000000, 9999999));

        $this->info("The new API access token is: {$token}");
    }
}
