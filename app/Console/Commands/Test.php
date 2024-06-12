<?php

namespace App\Console\Commands;

use App\DTOs\Olympiad\QuestionPublicDTO;
use App\Interfaces\Telegram\PostableInterface;
use App\Models\Olympiad;
use App\Models\Post;
use App\Services\OlympiadService;
use App\Services\QuestionService;
use App\Services\SmsService;
use App\Traits\StatusTrait;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

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
        /*$post = Post::with('postable')->where('id', 4)->first();
        dd($post->postable instanceof PostableInterface);*/

        /*$question = (new QuestionService())->find(8);
        (new QuestionPublicDTO())->transform($question);*/

        Olympiad::find(1)->message(4);
    }
}
