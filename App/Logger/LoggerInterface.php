<?php

namespace App\Logger;

interface LoggerInterface
{
    public function log(string|\Stringable $message, array $context = []): void;
}
