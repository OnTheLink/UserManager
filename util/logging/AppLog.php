<?php

namespace UserManager\Util\Logging;

class AppLog
{
    public function log($type, $message): void
    {
        $log = fopen(__DIR__ . '/../../logs/app.log', 'a');
        fwrite($log, '[' . date('Y-m-d H:i:s') . '] [' . $type . '] ' . $message . PHP_EOL);
        fclose($log);
    }

    public function clear(): void
    {
        $log = fopen(__DIR__ . '/../../logs/app.log', 'w');
        fwrite($log, '');
        fclose($log);
    }
}