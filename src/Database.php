<?php
/**
 * Клас Database - Singleton для роботи з базою даних
 * 
 * Демонструє:
 * - Singleton паттерн
 * - PDO для безпечної роботи з БД
 * - Підготовлені запити для захисту від SQL-ін'єкцій
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $this->connection = new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Помилка підключення до БД: ' . $e->getMessage());
        }
    }
    
    /**
     * Отримання єдиного екземпляра Database (Singleton)
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Виконання SQL запиту з підготовленими параметрами
     */
    public function execute($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Отримання одного рядка результату
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Отримання всіх рядків результату
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Отримання ID останнього вставленого запису
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    /**
     * Отримання кількості рядків, які були змінені
     */
    public function rowCount($stmt) {
        return $stmt->rowCount();
    }
}
