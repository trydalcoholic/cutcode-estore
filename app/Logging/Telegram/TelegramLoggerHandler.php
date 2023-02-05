<?php

declare(strict_types = 1);

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int    $chat_id;
    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->chat_id = (int)$config['chat_id'];
        $this->token = $config['token'];
    }

    protected function write(array $record): void
    {
        TelegramBotApi::sendMessage(
            $this->token,
            $this->chat_id,
            $record['formatted']
        );
    }
}
