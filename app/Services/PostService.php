<?php

namespace App\Services;

use App\Interfaces\Telegram\PostableInterface;
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

        if ($post->postable instanceof PostableInterface) {
            /**
             * @var StatusTrait $post->postable
             */
            $post->postable()->update([
                'status' => $post->postable::STATUS_FAILED
            ]);
        }
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

        if ($post->postable instanceof PostableInterface) {
            /**
             * @var StatusTrait $post->postable
             */
            $post->postable()->update([
                'status' => $post->postable::STATUS_SENDING
            ]);
        }
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

        if ($post->postable instanceof PostableInterface) {
            /**
             * @var StatusTrait $post->postable
             */
            $post->postable()->update([
                'status' => $post->postable::STATUS_SENT
            ]);
        }
    }
}
