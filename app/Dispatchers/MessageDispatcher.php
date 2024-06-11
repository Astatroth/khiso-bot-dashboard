<?php

namespace App\Dispatchers;

use App\DTOs\News\NewsDTO;
use App\Models\Post;
use App\Pipes\CompleteDispatchingPipe;
use App\Pipes\DispatchPipe;
use App\Pipes\StartDispatchingPipe;
use Illuminate\Pipeline\Pipeline;

class MessageDispatcher
{
    public function dispatch(Post $post): void
    {
        $pipes = [
            StartDispatchingPipe::class,
            DispatchPipe::class
        ];

        try {
            app(Pipeline::class)
                ->send($post)
                ->through($pipes)
                ->then(function ($post) {
                    return $post;
                });
        } catch (\Exception $e) {
            \Log::error(
                "Error while dispatching post id: {$post->id}, exception: {$e->getMessage()}, trace: {$e->getTraceAsString()}"
            );
        }
    }
}
