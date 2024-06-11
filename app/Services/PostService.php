<?php

namespace App\Services;

use App\Models\Post;
use App\Traits\StatusTrait;
use Illuminate\Support\Collection;

class PostService
{
    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return Post::queued()->get();
    }

    /**
     * @param int $postId
     * @return void
     */
    public function markAsFailed(int $postId): void
    {
        $post = Post::with('postable')->where('id', $postId)->first();

        $post->update([
            'status' => Post::STATUS_FAILED
        ]);

        /**
         * @var StatusTrait $post->postable
         */
        $post->postable()->update([
            'status' => $post->postable::STATUS_FAILED
        ]);
    }

    /**
     * @param int $postId
     * @return void
     */
    public function markAsSending(int $postId): void
    {
        $post = Post::with('postable')->where('id', $postId)->first();

        $post->update([
            'status' => Post::STATUS_SENDING
        ]);

        /**
         * @var StatusTrait $post->postable
         */
        $post->postable()->update([
            'status' => $post->postable::STATUS_SENDING
        ]);
    }

    /**
     * @param int $postId
     * @return void
     */
    public function markAsSent(int $postId): void
    {
        $post = Post::with('postable')->where('id', $postId)->first();

        $post->update([
            'status' => Post::STATUS_SENT
        ]);

        /**
         * @var StatusTrait $post->postable
         */
        $post->postable()->update([
            'status' => $post->postable::STATUS_SENT,
            'published_at' => now()
        ]);
    }
}
