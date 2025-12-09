<?php
/**
 * Модель Course - Демонстрація Many-to-Many зв'язку
 * 
 * Зв'язок: Course (1) --- (Many) Enrollment --- (Many) Student
 * 
 * Демонструє:
 * - Успадкування від Model
 * - Many-to-Many зв'язок через таблицю enrollments
 * - Метод для отримання пов'язаних студентів
 */

class Course extends Model {
    protected static $table = 'courses';
    
    /**
     * Отримання всіх студентів, записаних на цей курс
     * 
     * Демонстрація Many-to-Many зв'язку:
     * - Курс має багато студентів
     * - Студент може бути записаний на багато курсів
     * - Зв'язок реалізується через таблицю enrollments
     */
    public function getStudents() {
        $db = Database::getInstance();
        
        $sql = '
            SELECT s.* FROM students s
            INNER JOIN enrollments e ON s.id = e.student_id
            WHERE e.course_id = ?
            ORDER BY s.name ASC
        ';
        
        $records = $db->fetchAll($sql, [$this->attributes['id']]);
        
        $students = [];
        foreach ($records as $record) {
            $students[] = new Student($record);
        }
        
        return $students;
    }
    
    /**
     * Отримання кількості студентів на курсі
     */
    public function getStudentCount() {
        $db = Database::getInstance();
        
        $sql = '
            SELECT COUNT(*) as count FROM enrollments
            WHERE course_id = ?
        ';
        
        $result = $db->fetchOne($sql, [$this->attributes['id']]);
        return $result['count'] ?? 0;
    }
    
    /**
     * Перевірка, чи записаний студент на цей курс
     */
    public function hasStudent($studentId) {
        $db = Database::getInstance();
        
        $sql = '
            SELECT COUNT(*) as count FROM enrollments
            WHERE course_id = ? AND student_id = ?
        ';
        
        $result = $db->fetchOne($sql, [$this->attributes['id'], $studentId]);
        return $result['count'] > 0;
    }
    
    /**
     * Додавання студента на курс
     */
    public function addStudent($studentId) {
        if (!$this->hasStudent($studentId)) {
            Enrollment::create($studentId, $this->attributes['id']);
        }
    }
    
    /**
     * Видалення студента з курсу
     */
    public function removeStudent($studentId) {
        $db = Database::getInstance();
        
        $sql = 'DELETE FROM enrollments WHERE course_id = ? AND student_id = ?';
        $db->execute($sql, [$this->attributes['id'], $studentId]);
    }
}
