<?php
class DB {
    private static $pdo = null;

    public static function init() {
        if (self::$pdo === null) {
            try {
                $host = 'localhost';
                $dbname = 'chat_app';
                $username = 'root';
                $password = '';

                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Błąd połączenia z bazą danych: " . $e->getMessage());
            }
        }
    }

    public static function getPDO() {
        if (self::$pdo === null) {
            self::init();
        }
        return self::$pdo;
    }
}