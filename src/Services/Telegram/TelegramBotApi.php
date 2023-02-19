<?php

declare(strict_types=1);

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\Exceptions\TelegramBotApiException;
use Throwable;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chat_id, string $text): bool
    {
        try {
            $response = Http::get(self::HOST.$token.'/sendMessage', [
                'chat_id' => $chat_id,
                'text' => $text,
            ])->throw()->json();

            return $response['ok'] ?? false;
        } catch (Throwable $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        }
    }
}
