<?php

namespace App\Console\Commands;

use App\Dispatchers\MessageDispatcher;
use App\Services\PostService;
use Illuminate\Console\Command;

class DispatchMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatches queued messages to Telegram';

    /**
     * @param PostService       $postService
     * @param MessageDispatcher $dispatcher
     */
    public function __construct(protected PostService $postService, protected MessageDispatcher $dispatcher)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $posts = $this->postService->getPosts();

        if ($posts->isEmpty()) {
            return 1;
        }

        $this->info("Dispatching {$posts->count()} posts");

        foreach ($posts as $post) {
            $this->info("Dispatching post id: {$post->id}");

            $this->dispatcher->dispatch($post);
        }

        $this->info("Finished dispatching posts");

        return 0;
    }
}
