<?php
declare(strict_types=1);

namespace App\Logger;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Processor\UidProcessor;
use \Monolog\Logger as MLogger;
class Logger implements LoggerInterface
{
    /**
     * @param  string|\Stringable $message
     * @param  array              $context
     * @return void
     */
    public function log(string|\Stringable $message, array $context = []): void
    {
        $logFolder = $this->getPath();

        $streamHandler = new StreamHandler($logFolder . "log.", Level::Info);
        $rotatingFileHandler = new RotatingFileHandler(
            $logFolder ."log.rotate.",
            1
        );

        $jsonFormatter = new JsonFormatter();

        $streamHandler->setFormatter($jsonFormatter);
        $rotatingFileHandler->setFormatter($jsonFormatter);

        $logger = new MLogger('channelName',  [$rotatingFileHandler], [new UidProcessor()]);

        $logger->info($message);
    }

    protected function getPath(): string
    {
        $dir = explode('/', __DIR__);
        array_splice($dir, -2);
        return implode('/', $dir) . '/log/';
    }
}
