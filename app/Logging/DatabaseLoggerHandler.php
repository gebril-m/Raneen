<?php
namespace App\Logging;
use Monolog\Logger;
use App\Rlogger;
use Monolog\Handler\AbstractProcessingHandler;

class DatabaseLoggerHandler extends AbstractProcessingHandler {

    function __construct($level = Logger::DEBUG){
        parent::__construct($level);
    }

    function write(array $record){
        Rlogger::create($record['context']);
    }

}