<?php
namespace App\Logging;
use Monolog\Logger;

class DatabaseLogger {
    
    function __invoke(array $config){
        $logger = new Logger('custom');
        $logger->pushHandler(new DatabaseLoggerHandler());
        return $logger;
    }

}