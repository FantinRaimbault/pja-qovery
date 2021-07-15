<?php


namespace App\Core\Database;

use PDO;
use Throwable;
use App\Core\Logger;

class Connection
{
    private static $instance;

    public static function getInstance()
    {
        Logger::dd(getenv('MYSQL_DATABASE'));
        if (is_null(self::$instance)) {
            try {
                $pdo = new PDO(
                    'mysql:dbname=' . getenv('MYSQL_DATABASE') . ';host=' . getenv('MYSQL_HOST'),
                    getenv('MYSQL_USER'),
                    getenv('MYSQL_PASSWORD')
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                self::$instance = $pdo;
            } catch (Throwable $th) {
                die('connection failed ' . $th . PHP_EOL);
            }
        }
        return self::$instance;
    }
}
