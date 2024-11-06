<?php



use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

require_once __DIR__ . '/../vendor/autoload.php';

Class LoggerConfig {

    /**
     * Funzione per restituire un'istanza di Logger.
     *
     * @return Logger
     */
    public static function getLogger(): Logger
    {
        // Creiamo il logger
        $log = new Logger('ultra_admin_log');

        // Aggiungiamo un handler: i log verranno scritti nel file ultra_admin.log
        $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/ultra_admin.log', Level::Debug));

        return $log;
    }

}