<?php

declare(strict_types=1);

namespace PHPOMG\Psr3;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Stringable;

class DelegatingLogger extends AbstractLogger
{
    public $loggers = [
        LogLevel::EMERGENCY => [],
        LogLevel::ALERT => [],
        LogLevel::CRITICAL => [],
        LogLevel::ERROR => [],
        LogLevel::WARNING => [],
        LogLevel::NOTICE => [],
        LogLevel::INFO => [],
        LogLevel::DEBUG => [],
    ];

    public function addLogger(
        LoggerInterface $logger,
        $levels = [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::NOTICE,
            LogLevel::INFO,
            LogLevel::DEBUG,
        ]
    ): self {
        foreach ($levels as $level) {
            $this->loggers[$level][] = $logger;
        }
        return $this;
    }

    public function log($level, string|Stringable $message, array $context = []): void
    {
        foreach ($this->loggers[$level] ?? [] as $logger) {
            $logger->log($level, $message, $context);
        }
    }
}
