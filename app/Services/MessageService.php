<?php

namespace App\Services;

use App\Events\MessageFailedEvent;
use App\Interfaces\Telegram\HasAdjustableMessagesInterface;
use App\Interfaces\Telegram\HasInlineReplyMarkupInterface;
use App\Models\Post;
use App\Models\PostMessage;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use TelegramBot\Api\HttpException;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\InputMedia\InputMediaPhoto;
use TelegramBot\Api\Types\InputMedia\InputMediaVideo;

class MessageService
{
    /**
     * @param Post    $post
     * @param Model   $model
     * @param Student $recipient
     * @return PostMessage
     */
    public function compileMessage(Post $post, Model $model, Student $recipient): PostMessage
    {
        /**
         * @var PostMessage|null $message
         */
        $message = $post->messages()->where('chat_id', $recipient->chat_id)->first();

        if (is_null($message)) {
            $message = new PostMessage();
            $description = $model->description;

            if (!is_null($model->media) && $model->media->isNotEmpty()) {
                $description = substr($description, 0, 900);
            }

            $description = $this->sanitizeContent($description);
            $type = PostMessage::TYPE_TEXT;
            $media = null;

            if (!is_null($model->media)) {
                if ($model->media->count() > 1) {
                    $type = PostMessage::TYPE_MEDIA_GROUP;

                    foreach ($model->media as $index => $_media) {
                        $media[] = [
                            'type' => $_media->media_type === $_media::TYPE_PHOTO
                                ? PostMessage::TYPE_PHOTO
                                : PostMessage::TYPE_VIDEO,
                            'media' => $_media->media_type === $_media::TYPE_PHOTO
                                ? $_media->media_url
                                : $this->prepareVideoUrl($_media->media_url),
                            'caption' => $index === 0 ? $description : ''
                        ];
                    }
                } else {
                    if ($model->media->isNotEmpty()) {
                        $_media = $model->media->first();
                        $type = $_media->media_type === $_media::TYPE_PHOTO ? PostMessage::TYPE_PHOTO : PostMessage::TYPE_VIDEO;
                        $media[0] = $_media->media_type === $_media::TYPE_PHOTO
                            ? $_media->media_url
                            : $this->prepareVideoUrl($_media->media_url);
                    }
                }
            } elseif ($model->image) {
                if (config('app.env') === 'local') {
                    $media[0] = $model->image;
                } else {
                    $media[0] = config('app.url').'/storage/files/shares'.$model->image;
                }

                $type = PostMessage::TYPE_PHOTO;
            }

            if ($model instanceof HasInlineReplyMarkupInterface) {
                $keyboard = $model->inlineMarkup($recipient->id);
            }

            if ($model instanceof HasAdjustableMessagesInterface) {
                $description = $model->message($recipient->id);
            }

            $message->post_id = $post->id;
            $message->chat_id = $recipient->chat_id;
            $message->message_type = $type;
            $message->message_content = $description;
            $message->message_parse_mode = 'HTML';
            $message->message_reply_markup = $keyboard ?? null;
            $message->message_media = $media;

            $message->save();
        }

        return $message;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function prepareVideoUrl(string $url): string
    {
        $string = $url;
        if (strpos($url, 'yout') !== false) {
            $origin = explode('?', $url)[0];
            $id = explode('/', $origin);

            $string = 'https://www.youtube.com/watch?v='.end($id);
        }

        return $string;
    }

    /**
     * @param string $content
     * @return string
     */
    public function sanitizeContent(string $content): string
    {
        $content = str_replace('<br>', "\r\n\r\n", $content);
        $content = str_replace('&nbsp;', " ", $content);
        $content = str_replace('<p>', " ", $content);
        $content = str_replace('</p>', "\r\n\r\n", $content);
        $content = strip_tags($content, ['a', 'i', 'u', 'b']);

        return $content;
    }

    /**
     * @param PostMessage $message
     * @return void
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendMessage(PostMessage $message): void
    {
        $telegramService = new TelegramService();

        if ($message->message_reply_markup) {
            $keyboard = new InlineKeyboardMarkup([
                [
                    $message->message_reply_markup
                ]
            ]);
        }

        try {
            switch ($message->message_type) {
                case PostMessage::TYPE_PHOTO:
                    // Send photo

                    $telegramService->sendPhoto(
                        $message->chat_id,
                        $message->message_media[0],
                        $message->message_content,
                        $message->message_parse_mode,
                        replyMarkup: $keyboard ?? null
                    );
                    break;
                case PostMessage::TYPE_VIDEO:
                    // Send Video
                    $telegramService->sendVideo(
                        $message->chat_id,
                        $message->message_media[0],
                        $message->message_content,
                        $message->message_parse_mode
                    );
                    break;
                case PostMessage::TYPE_MEDIA_GROUP:
                    // Send media group
                    $media = new ArrayOfInputMedia();
                    foreach ($message->message_media as $_media) {
                        $media->addItem(
                            $_media['type'] === PostMessage::TYPE_PHOTO
                                ? new InputMediaPhoto($_media['media'], $_media['caption'], $message->message_parse_mode)
                                : new InputMediaVideo($_media['media'], $_media['caption'], $message->message_parse_mode)
                        );
                    }

                    $telegramService->sendMediagroup($message->chat_id, $media);
                    break;
                default:
                    // Send text message
                    $telegramService->sendMessage(
                        $message->chat_id,
                        $message->message_content,
                        $message->message_parse_mode
                    );
                    break;
            }
        } catch (\Throwable $e) {
            \Log::debug("Message Service has thrown an Exception: {$e->getMessage()}, trace: {$e->getTraceAsString()}");
            event(new MessageFailedEvent($message));
        }
    }
}
