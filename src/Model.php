<?php
/**
 * Базовий клас Model - реалізація базової функціональності для всіх моделей
 * 
 * Демонструє:
 * - Успадкування (Inheritance)
 * - DRY принцип (повторне використання коду)
 * - Основні CRUD операції
 */

abstract class Model {
    protected static $table;
    protected $attributes = [];
    protected $original = [];
    
    /**
     * Конструктор моделі
     */
    public function __construct($attributes = []) {
        $this->attributes = $attributes;
        $this->original = $attributes;
    }
    
    /**
     * Магічний метод для доступу до атрибутів
     */
    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }
    
    /**
     * Магічний метод для встановлення атрибутів
     */
    public function __set($name, $value) {
        $this->attributes[$name] = $value;
    }
    
    /**
     * Отримання всіх записів з таблиці
     */
    public static function all() {
        $db = Database::getInstance();
        $records = $db->fetchAll('SELECT * FROM ' . static::$table);
        
        $instances = [];
        foreach ($records as $record) {
            $instances[] = new static($record);
        }
        return $instances;
    }
    
    /**
     * Пошук запису за ID
     */
    public static function find($id) {
        $db = Database::getInstance();
        $record = $db->fetchOne('SELECT * FROM ' . static::$table . ' WHERE id = ?', [$id]);
        
        if ($record) {
            return new static($record);
        }
        return null;
    }
    
    /**
     * Збереження запису (Create або Update)
     */
    public function save() {
        $db = Database::getInstance();
        
        if (isset($this->attributes['id'])) {
            // Update
            $setClause = [];
            $params = [];
            
            foreach ($this->attributes as $key => $value) {
                if ($key !== 'id') {
                    $setClause[] = "$key = ?";
                    $params[] = $value;
                }
            }
            
            $params[] = $this->attributes['id'];
            $sql = 'UPDATE ' . static::$table . ' SET ' . implode(', ', $setClause) . ' WHERE id = ?';
            $db->execute($sql, $params);
        } else {
            // Create
            $columns = array_keys($this->attributes);
            $placeholders = array_fill(0, count($columns), '?');
            
            $sql = 'INSERT INTO ' . static::$table . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
            $db->execute($sql, array_values($this->attributes));
            
            $this->attributes['id'] = $db->lastInsertId();
        }
        
        return $this;
    }
    
    /**
     * Видалення запису
     */
    public function delete() {
        $db = Database::getInstance();
        
        if (isset($this->attributes['id'])) {
            $sql = 'DELETE FROM ' . static::$table . ' WHERE id = ?';
            $db->execute($sql, [$this->attributes['id']]);
            return true;
        }
        return false;
    }
    
    /**
     * Отримання атрибутів як масиву
     */
    public function toArray() {
        return $this->attributes;
    }
}
