<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\Exceptions\TelegramBotApiException;
use Services\Telegram\TelegramBotApiContract;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int    $chat_id;

    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->chat_id = (int) $config['chat_id'];
        $this->token = $config['token'];
    }

    /**
     * @throws TelegramBotApiException
     */
    protected function write(array $record): void
    {
        app(TelegramBotApiContract::class)::sendMessage(
            $this->token,
            $this->chat_id,
            $record['formatted']
        );
    }
}
