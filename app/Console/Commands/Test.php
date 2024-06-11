<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\SmsService;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $post = Post::with('postable')->where('id', 4)->first();
        dd($post->postable::STATUS_SENT);
    }
}
