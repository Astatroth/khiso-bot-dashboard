<?php

namespace App\Pipes;

use App\Models\Post;
use App\Services\PostService;

class StartDispatchingPipe
{
    /**
     * @param PostService $service
     */
    public function __construct(protected PostService $service)
    {

    }

    /**
     * @param Post $post
     * @param      $next
     * @return mixed
     */
    public function handle(Post $post, $next)
    {
        $this->service->markAsSending($post->id);

        return $next($post);
    }
}
