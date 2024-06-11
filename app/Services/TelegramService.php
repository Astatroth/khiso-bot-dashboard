<?php

namespace App\Services;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\Types\ForceReply;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class TelegramService
{
    /**
     * @var BotApi
     */
    protected $bot;

    /**
     * @var string
     */
    protected $token;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->token = config('telegram.bot_token');

        $this->bot = new BotApi($this->token);
    }

    /**
     * Use this method to send a group of photos or videos as an album.
     * On success, the sent \TelegramBot\Api\Types\Message is returned.
     *
     * @param int|string $chatId
     * @param ArrayOfInputMedia $media
     * @param bool $disableNotification
     * @param int|null $replyToMessageId
     * @param int|null $messageThreadId
     * @param bool|null $protectContent
     * @param bool|null $allowSendingWithoutReply
     * @param array<string, \CURLFile|\CURLStringFile> $attachments Attachments to use in attach://<attachment>
     *
     * @return Message[]
     * @throws Exception
     */
    public function sendMediaGroup(
        $chatId,
        $media,
        $disableNotification = false,
        $replyToMessageId = null,
        $messageThreadId = null,
        $protectContent = null,
        $allowSendingWithoutReply = null,
        $attachments = []
    ) {
        return $this->bot->sendMediaGroup(
            $chatId,
            $media,
            $disableNotification,
            $replyToMessageId,
            $messageThreadId,
            $protectContent,
            $allowSendingWithoutReply,
            $attachments
        );
    }

    /**
     * @param int                                                                          $chatId
     * @param string                                                                       $text
     * @param string|null                                                                  $parseMode
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup
     * @return Message
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendMessage(
        int $chatId,
        string $text,
        string|null $parseMode = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null
    ): Message {
        return $this->bot->sendMessage(
            $chatId,
            $text,
            $parseMode,
            replyMarkup: $replyMarkup
        );
    }

    /**
     * @param int                                                                          $chatId
     * @param string                                                                       $photo
     * @param string                                                                       $caption
     * @param string|null                                                                  $parseMode
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup
     * @return Message
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendPhoto(
        int $chatId,
        string $photo,
        string $caption,
        string $parseMode = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null
    ): Message {
        return $this->bot->sendPhoto(
            $chatId,
            $photo,
            $caption,
            parseMode: $parseMode,
            replyMarkup: $replyMarkup
        );
    }

    /**
     * @param int                                                                          $chatId
     * @param string                                                                       $video
     * @param string|null                                                                  $caption
     * @param string|null                                                                  $parseMode
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup
     * @return Message
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendVideo(
        int $chatId,
        string $video,
        string $caption = null,
        string $parseMode = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null
    ): Message {
        return $this->bot->sendVideo(
            $chatId,
            $video,
            caption: $caption,
            parseMode: $parseMode,
            replyMarkup: $replyMarkup
        );
    }
}
