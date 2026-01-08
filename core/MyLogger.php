<?php 

namespace Core;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Level;

class MyLogger {
	
	public static $instance = null;

	private $logger;

	private function __construct() {
		$dateFormat = "Y-m-d H:i:s";
		$output     = "[%datetime%] %channel% %level_name%: %message%\n"; // %context% %extra%\n";
		$formatter  = new LineFormatter($output, $dateFormat);
		$stream     = new StreamHandler('./logs/log_budget.log', Level::Debug); // Pour obtenir un fichier de log global
		$stream->setFormatter($formatter);
		$this->logger = new Logger('');
		$this->logger->pushHandler($stream);
	}


	public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->logger;
    }
}
?>